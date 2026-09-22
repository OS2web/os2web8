<?php

namespace Drupal\fic_office_hours;

use Drupal\office_hours\OfficeHoursSeason;
use Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItem;
use Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItemListInterface;

/**
 * Filters Office Hours items so only the active season or normal week is shown.
 *
 * Office Hours' POST_FORMAT event result is not applied by the module, so this
 * filter mutates the item list in PRE_FORMAT (the supported extension point).
 */
class OfficeHoursSeasonDisplayFilter {

  /**
   * Filters an Office Hours item list for display.
   *
   * @param \Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItemListInterface $items
   *   The office hours items (mutated in place).
   * @param int $timestamp
   *   Unix timestamp representing "now" for the formatter.
   */
  public function filter(OfficeHoursItemListInterface $items, int $timestamp): void {
    if ($items->isEmpty()) {
      return;
    }

    $active_season_id = $this->resolveActiveSeasonId($items, $timestamp);
    $deltas_to_remove = [];

    foreach ($items as $delta => $item) {
      if (!$item instanceof OfficeHoursItem) {
        continue;
      }

      // Always keep exception days / headers.
      if ($item->isExceptionDay() || $item->isExceptionHeader()) {
        continue;
      }

      $season_id = (int) $item->getSeasonId();

      if ($active_season_id) {
        // Active season: keep that season's weekdays only (no season header,
        // so the list looks like a normal week that has been replaced).
        if ($season_id !== $active_season_id || $item->isSeasonHeader()) {
          $deltas_to_remove[] = $delta;
        }
      }
      // No active season: keep normal weekdays, drop all seasonal rows.
      elseif ($season_id !== 0) {
        $deltas_to_remove[] = $delta;
      }
    }

    foreach (array_reverse($deltas_to_remove) as $delta) {
      $items->removeItem($delta);
    }
  }

  /**
   * Resolves the season ID that should replace normal hours right now.
   *
   * If multiple seasons contain the current timestamp, the one with the latest
   * start date wins.
   *
   * Intentionally avoids ItemList::getSeasons() here: that method caches season
   * metadata on the list. Calling it before we remove items would leave stale
   * seasons in the formatter after filtering.
   *
   * @param \Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItemListInterface $items
   *   The office hours items.
   * @param int $timestamp
   *   Unix timestamp representing "now".
   *
   * @return int
   *   Active season ID, or 0 when no season is active.
   */
  public function resolveActiveSeasonId(OfficeHoursItemListInterface $items, int $timestamp): int {
    $selected = NULL;

    foreach ($items as $item) {
      if (!$item instanceof OfficeHoursItem || !$item->isSeasonHeader()) {
        continue;
      }

      $season = new OfficeHoursSeason($item);
      if (!$season->id() || !$season->isInRange($timestamp, $timestamp)) {
        continue;
      }

      if ($selected === NULL || $season->getFromDate() >= $selected->getFromDate()) {
        $selected = $season;
      }
    }

    return $selected ? (int) $selected->id() : 0;
  }

}
