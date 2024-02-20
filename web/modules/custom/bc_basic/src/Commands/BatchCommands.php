<?php
namespace Drupal\bc_basic\Commands;

use Drush\Commands\DrushCommands;
use Drupal\bc_basic\Debug;


Class BatchCommands extends DrushCommands {

  /**
   * bellcom test
   *
   * @command bc:test
   * @aliases bctest
   * @options $options arr AN option that takes multiple values.
   */
  public function test($options = []) {
    echo "bellcom test\n";
    Debug::log(__METHOD__);

  }


  /**
   * bellcom files utility
   *
   * @command bc:files
   * @aliases bcfiles
   *
   * @option usage find usage or un-usage files
   * @option delete if delete files
   * @option number if you want to count files
   * @option delete-if-missing if you want to remove if physically missing
   * @option dry run without doing anything
   */
  public function files($options=array('delete' => false, 'number' => 0, 'usage' => false, 'delete-if-missing' => false)) {

    $file_system = \Drupal::service('file_system');
    $count = 0;
    $delete_if_missing_count = 0;

    $ids = \Drupal::entityQuery('file')->execute();
    foreach ($ids as $fileID) {
      $file = \Drupal::entityTypeManager()->getStorage('file')->load($fileID);
      $usage = \Drupal::service('file.usage')->listUsage($file);

      if ($options['usage'] && !empty($usage)) {
        if ($options['number']) $count++;
        if ($options['delete'] && !$options['dry']) $file->delete();
      }

      if (!$options['usage'] && empty($usage)) {
        if ($options['number']) $count++;
        if ($options['delete'] && !$options['dry']) $file->delete();
      }

      if ($options['delete-if-missing']) {
        $path = $file_system->realpath($file->get('uri')->value);
        if (empty($path) || !file_exists($path)) {
          echo "delete missing " . ($path ?? $file->get('filename')->value) . "\n";
          if (!$options['dry']) $file->delete();
          $delete_if_missing_count++;
        }
      }
    }

    if ($options['number']) echo "total : " . $count . ($options['usage'] ? ' ':' un-') . "usage files\n";
    if ($options['delete-if-missing']) echo "missing files total : " . $delete_if_missing_count . " files\n";
  }


  /**
   * bellcom media utility
   *
   * @command bc:medias
   * @aliases bcmedias
   *
   * @option number if you want to count files
   * @option delete-if-missing
   * @option dry
   */
  public function medias($options = array('number' => false, 'delete-if-missing' => false, 'dry' => false)) {

    $file_system = \Drupal::service('file_system');
    $bundles = array();
    $bundleMap = array(
      'images' => 'field_media_image',
      'document' => 'field_media_file',
      'os2web_video' => 'field_media_video_file',
      'os2web_file' => 'field_media_file_1'
    );

    $ids = \Drupal::entityQuery('media')->execute();
    foreach ( $ids AS $mid ) {
        $media = \Drupal::entityTypeManager()->getStorage('media')->load($mid);
        $fid = 0;
        foreach ($bundleMap AS $key => $bundle ) {
          if (!$fid && $media->hasField($bundle)) {
            $fid = $media->get($bundle)->target_id;

            if (!isset($bundles[$key])) $bundles[$key] = 0;
            $bundles[$key]++;
          }
        }

        if ($fid) {
          $file = \Drupal::entityTypeManager()->getStorage('file')->load($fid);
          if ($file) {
              if ($options['delete-if-missing']) {
                  $path = $file_system->realpath($file->get('uri')->value);
                  if (empty($path) || !file_exists($path)) {
                      if (!$options['dry']) {
                          $media->delete();
                          $file->delete();
                      }
                  }
              }
          } else {
              if ($options['delete-if-missing'] && !$options['dry']) $media->delete();
          }
        }
    }

    if ($options['number']) {
      print_r( $bundles );
    }
  }
  
}
