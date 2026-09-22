<?php

namespace Drupal\fic_office_hours;

use Drupal\office_hours\OfficeHoursDateHelper;
use Drupal\office_hours\OfficeHoursSeason;
use Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItem;
use Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItemListInterface;

/**
 * Filters Office Hours display rows to active season or normal weekdays.
 */
class OfficeHoursSeasonDisplayFilter {

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

    $active_season_id = $this->resolveActiveSeasonId($items, $timestamp);
    $filtered = [];

    foreach ($office_hours as $key => $info) {
      if (!is_array($info)) {
        continue;
      }

      $day = $info['day'] ?? $key;

      // Always keep exception days.
      if (OfficeHoursDateHelper::isExceptionDay($day)) {
        $filtered[$key] = $info;
        continue;
      }

      // Never show season headers (also avoids OH label bug for day % 100 == 9).
      if (OfficeHoursDateHelper::isSeasonHeader($day)) {
        continue;
      }

      $season_id = (int) OfficeHoursDateHelper::getSeasonId($day);

      if ($active_season_id) {
        if ($season_id === $active_season_id) {
          $filtered[$key] = $info;
        }
      }
      elseif ($season_id === 0) {
        $filtered[$key] = $info;
      }
    }

    return $filtered;
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

      if ($selected === NULL || $season->getFromDate() >= $selected->getFromDate()) {
        $selected = $season;
      }
    }

    return $selected ? (int) $selected->id() : 0;
  }

  /**
   * Checks whether a timestamp falls on a calendar day inside the season.
   *
   * Uses the site timezone and inclusive start/end dates.
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
      // Fall back to Office Hours' own range check.
      return $season->isInRange($timestamp, $timestamp);
    }
  }

}
