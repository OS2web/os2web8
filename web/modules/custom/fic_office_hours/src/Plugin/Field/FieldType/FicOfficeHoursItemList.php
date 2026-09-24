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

      return parent::getRows($settings, $field_settings, $third_party_settings, $time, $plugin);
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
