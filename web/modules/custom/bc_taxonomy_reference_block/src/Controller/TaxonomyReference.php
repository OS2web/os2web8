<?php
namespace Drupal\bc_taxonomy_reference_block\Controller;


Class TaxonomyReference {

  public static function getList($field=null) {
    $output = array();

    if (!empty($field)) {
      $bundleInfo = \Drupal::service('entity_type.bundle.info');
      $taxonomy_fields = \Drupal::entityTypeManager()
        ->getStorage('field_storage_config')
        ->loadByProperties([
          'field_name' => $field,
          'type' => 'entity_reference',
          'settings' => ['target_type' => 'taxonomy_term'],
        ]);
      $list = [];

      foreach ($taxonomy_fields as $taxfield) {
        $entityType = $taxfield->get('entity_type');
        $bundles = $bundleInfo->getBundleInfo($entityType);
        foreach ($bundles as $bundleKey => $bundle) {
          if (!empty($entityType) && !empty($bundleKey)) {
            $list[] = (object) [
              "type" => $entityType,
              "bundle" => $bundleKey,
              'list' => []
            ];
          }
        }
      }

      foreach ($list as $idx => $n) {
        $query = \Drupal::entityQuery($n->type)
          ->condition($field, NULL, 'IS NOT NULL')
          ->accessCheck(TRUE);
        if ($n->type === 'node') {
          $query->condition('type', $n->bundle);
        }
        $result = $query->execute();

        if (!empty($result)) {
          foreach ($result as $idx => $id) {
            $entity = \Drupal::entityTypeManager()
              ->getStorage($n->type)
              ->load($id);
            if ($entity) {
              $tid = $entity->get($field)->target_id;
              $term = \Drupal::entityTypeManager()
                ->getStorage('taxonomy_term')
                ->load($tid);
              if ($term) {
                $output[$tid]['label'] = $term->label();
                $output[$tid][] = [
                  'name' => $entity->label(),
                  'url' => $entity->toUrl('canonical')
                    ->setAbsolute(TRUE)
                    ->toString()
                ];
              }
            }
          }
        }
      }
    }

    return $output;
  }

}