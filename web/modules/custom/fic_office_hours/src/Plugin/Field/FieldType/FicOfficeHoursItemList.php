<?php

namespace Drupal\fic_office_hours\Plugin\Field\FieldType;

use Drupal\Core\Field\PluginSettingsBase;
use Drupal\fic_office_hours\OfficeHoursSeasonDisplayFilter;
use Drupal\office_hours\Plugin\Field\FieldType\OfficeHoursItemList;

/**
 * Office Hours item list that prepares seasons before formatting.
 *
 * Avoids Office Hours WSOD around season headers / null comments by cleaning
 * items before the contrib formatter runs — without patching contrib.
 */
class FicOfficeHoursItemList extends OfficeHoursItemList {

  /**
   * {@inheritdoc}
   */
  public function getRows(array $settings, array $field_settings, array $third_party_settings, int $time = 0, ?PluginSettingsBase $plugin = NULL) {
    $timestamp = $time ?: \Drupal::time()->getRequestTime();
    $filter = $this->getSeasonDisplayFilter();

    // First pass: remap/remove seasons so contrib never formats broken rows.
    $filter->prepareItemsForFormatting($this, $timestamp);

    // Drop caches built against the pre-mutation item list. Stale sortedList /
    // seasons let getCurrentSlot() mark day keys that were never added to
    // $office_hours (incomplete rows → warnings in formatTimeSlots).
    $this->clearFormatterCaches();

    try {
      return parent::getRows($settings, $field_settings, $third_party_settings, $time, $plugin);
    }
    catch (\TypeError $e) {
      // Contrib office_hours can still throw on null comments in edge cases.
      // Strip every seasonal row and retry once — never fatal the page.
      if (strpos($e->getMessage(), 'array_map') === FALSE) {
        throw $e;
      }

      $filter->stripAllSeasonItems($this);
      $this->clearFormatterCaches();

      return parent::getRows($settings, $field_settings, $third_party_settings, $time, $plugin);
    }
  }

  /**
   * Ensures every row has the structure formatTimeSlots() expects.
   *
   * Contrib can leave incomplete rows when is_current_slot is set on a day
   * that was never initialized, and groupDays() may call formatTimeSlots()
   * twice (leaving comments as a string on the second pass).
   *
   * {@inheritdoc}
   */
  protected function formatTimeSlots(array $office_hours, array $settings, array $field_settings) {
    $defaults = $this->getOfficeHoursDefault();

    foreach ($office_hours as $key => &$info) {
      if (!is_array($info)) {
        unset($office_hours[$key]);
        continue;
      }

      // Drop incomplete marker-only rows (e.g. only is_current_slot).
      if (!array_key_exists('items', $info) && !array_key_exists('day', $info)) {
        unset($office_hours[$key]);
        continue;
      }

      $info += $defaults;
      $info['items'] = is_array($info['items']) ? $info['items'] : [];
      // groupDays() may already have stringified these; reset so the second
      // formatTimeSlots pass can rebuild from items.
      $info['comments'] = is_array($info['comments']) ? $info['comments'] : [];
      $info['formatted_slots'] = is_array($info['formatted_slots']) ? $info['formatted_slots'] : [];
    }
    unset($info);

    return parent::formatTimeSlots($office_hours, $settings, $field_settings);
  }

  /**
   * Clears Office Hours formatter caches after mutating field items.
   */
  protected function clearFormatterCaches(): void {
    $this->sortedList = NULL;

    // OfficeHoursItemList::$seasons is private; reflection is the only way to
    // invalidate it from a subclass after we strip/remap season rows.
    try {
      $property = new \ReflectionProperty(OfficeHoursItemList::class, 'seasons');
      $property->setAccessible(TRUE);
      $property->setValue($this, NULL);
    }
    catch (\ReflectionException $e) {
      // If the property disappears upstream, formatting still continues.
    }
  }

  /**
   * Returns the season display filter service.
   *
   * @return \Drupal\fic_office_hours\OfficeHoursSeasonDisplayFilter
   *   The filter service.
   */
  protected function getSeasonDisplayFilter(): OfficeHoursSeasonDisplayFilter {
    return \Drupal::service('fic_office_hours.season_display_filter');
  }

}
