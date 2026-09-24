<?php

namespace Drupal\fic_office_hours;

use Drupal\office_hours\OfficeHoursDateHelper;
use Drupal\office_hours\OfficeHoursSeason;
use Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItem;
use Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItemListInterface;

/**
 * Filters Office Hours so only active-season or normal weekdays are shown.
 *
 * Strategy:
 * - Via custom list_class, strip inactive seasons and (when a season is
 *   active) remap that season's weekdays onto normal day numbers, removing
 *   the season header — before Office Hours formats rows.
 * - filterFormattedRows() remains as a display safety net in preprocess.
 */
class OfficeHoursSeasonDisplayFilter {

  /**
   * Prepares field items before Office Hours formats them.
   *
   * @param \Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItemListInterface $items
   *   The office hours items (mutated in place).
   * @param int $timestamp
   *   Unix timestamp representing "now".
   */
  public function prepareItemsForFormatting(OfficeHoursItemListInterface $items, int $timestamp): void {
    if ($items->isEmpty()) {
      return;
    }

    $active_season_id = $this->resolveActiveSeasonId($items, $timestamp);
    $deltas_to_remove = [];

    foreach ($items as $delta => $item) {
      if (!$item instanceof OfficeHoursItem) {
        continue;
      }

      if ($item->isExceptionDay() || $item->isExceptionHeader()) {
        continue;
      }

      $season_id = (int) $item->getSeasonId();

      if ($active_season_id) {
        // Drop season headers entirely (OH cannot safely label day % 100 == 9).
        if ($item->isSeasonHeader()) {
          $deltas_to_remove[] = $delta;
          continue;
        }

        if ($season_id === $active_season_id) {
          // Promote active season slots to normal weekday numbers.
          $weekday = (int) OfficeHoursDateHelper::getWeekday($item->day);
          if ($weekday >= 0 && $weekday <= 6) {
            $item->set('day', $weekday);
          }
          else {
            $deltas_to_remove[] = $delta;
          }
          continue;
        }

        // Remove normal weekdays and other seasons while a season is active.
        $deltas_to_remove[] = $delta;
        continue;
      }

      // No active season: remove all seasonal rows; keep normal weekdays.
      if ($season_id !== 0) {
        $deltas_to_remove[] = $delta;
      }
    }

    foreach (array_reverse($deltas_to_remove) as $delta) {
      $items->removeItem($delta);
    }
  }

  /**
   * Filters already formatted Office Hours rows for display.
   *
   * @param array $office_hours
   *   Formatted rows from Office Hours (keyed by day number).
   * @param \Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItemListInterface $items
   *   The original field item list (used to resolve active season dates).
   * @param int $timestamp
   *   Unix timestamp representing "now".
   *
   * @return array
   *   Filtered rows.
   */
  public function filterFormattedRows(array $office_hours, OfficeHoursItemListInterface $items, int $timestamp): array {
    if ($office_hours === []) {
      return $office_hours;
    }

    // After prepareItemsForFormatting(), rows should already be correct.
    // Still strip any leftover season headers / inactive season rows.
    $active_season_id = $this->resolveActiveSeasonId($items, $timestamp);
    $filtered = [];

    foreach ($office_hours as $key => $info) {
      if (!is_array($info)) {
        continue;
      }

      $day = $info['day'] ?? $key;

      if (OfficeHoursDateHelper::isExceptionDay($day)) {
        $filtered[$key] = $info;
        continue;
      }

      if (OfficeHoursDateHelper::isSeasonHeader($day)) {
        continue;
      }

      $season_id = (int) OfficeHoursDateHelper::getSeasonId($day);

      // Items were remapped to weekdays when a season is active, so season_id
      // is 0 in that case. Keep weekday rows; drop any leftover seasonal rows.
      if ($season_id === 0) {
        $filtered[$key] = $info;
      }
      elseif ($active_season_id && $season_id === $active_season_id) {
        $filtered[$key] = $info;
      }
    }

    return $filtered;
  }

  /**
   * Removes every seasonal item (headers + season weekdays).
   *
   * Used as a last-resort recovery when contrib formatting still throws.
   *
   * @param \Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItemListInterface $items
   *   The office hours items (mutated in place).
   */
  public function stripAllSeasonItems(OfficeHoursItemListInterface $items): void {
    $deltas_to_remove = [];

    foreach ($items as $delta => $item) {
      if (!$item instanceof OfficeHoursItem) {
        continue;
      }
      if ($item->isExceptionDay() || $item->isExceptionHeader()) {
        continue;
      }
      if ((int) $item->getSeasonId() !== 0 || $item->isSeasonHeader()) {
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
      if (!$season->id() || !$this->isTimestampInSeason($season, $timestamp)) {
        continue;
      }

      if ($selected === NULL || (int) $season->getFromDate() >= (int) $selected->getFromDate()) {
        $selected = $season;
      }
    }

    return $selected ? (int) $selected->id() : 0;
  }

  /**
   * Checks whether a timestamp falls on a calendar day inside the season.
   *
   * @param \Drupal\office_hours\OfficeHoursSeason $season
   *   The season.
   * @param int $timestamp
   *   Unix timestamp representing "now".
   *
   * @return bool
   *   TRUE if the timestamp's local date is within the season.
   */
  protected function isTimestampInSeason(OfficeHoursSeason $season, int $timestamp): bool {
    $from = (int) $season->getFromDate();
    $to = (int) $season->getToDate();
    if ($from <= 0 || $to <= 0) {
      return FALSE;
    }

    try {
      $timezone_name = \Drupal::config('system.date')->get('timezone.default') ?: date_default_timezone_get();
      $timezone = new \DateTimeZone($timezone_name);

      $today = (new \DateTimeImmutable('@' . $timestamp))
        ->setTimezone($timezone)
        ->setTime(0, 0, 0);
      $start = (new \DateTimeImmutable('@' . $from))
        ->setTimezone($timezone)
        ->setTime(0, 0, 0);
      $end = (new \DateTimeImmutable('@' . $to))
        ->setTimezone($timezone)
        ->setTime(0, 0, 0);

      return $today >= $start && $today <= $end;
    }
    catch (\Exception $e) {
      return $season->isInRange($timestamp, $timestamp);
    }
  }

}
