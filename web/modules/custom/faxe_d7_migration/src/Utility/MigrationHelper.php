<?php

namespace Drupal\faxe_d7_migration\Utility;

use Drupal\Core\Database\Database;
use Drupal\file\Entity\File;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\taxonomy\Entity\Term;

class MigrationHelper {

  public static $siteUrl = 'https://lokalarkiv.faxekommune.dk';
  public static $fileFolderPath = 'lokalarkiv.subsites.faxekommune.dk';

  /**
   * Sets the moderation state for the node based on a status.
   *
   * @param $status
   *
   * @return string
   */
  function setModerationState($status) {
    if ($status) {
      return 'published';
    }
    else {
      return 'draft';
    }
  }

  /**
   * Create accordion paragraph.
   *
   * @param $field_accordion
   *
   * @return array
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  /**
   * Create accordion paragraph.
   *
   * @param $field_accordion
   *
   * @return array
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  function createAccordionItemParagraph($field_paragraph_text) {
    if (!$field_paragraph_text) {
      return [];
    }
    // Creating text paragraph.
    $text_paragraph = Paragraph::create([
      'type' => 'os2web_simple_text_paragraph',
      'field_os2web_simple_text_heading' => '',
      'field_os2web_simple_text_body' => [
        'value' => $field_paragraph_text['value'],
        'format' => 'wysiwyg_tekst'
      ]
    ]);
    $text_paragraph->save();

    return [
      'target_id' => $text_paragraph->id(),
      'target_revision_id' =>  $text_paragraph->getRevisionId(),
    ];
  }

  /**
   * Gets a downloadable file URL.
   *
   * @param mix $field
   *   Array coming from migration source.
   *
   * @return string
   *   File downloadable URL.
   */
  function getFileDownloadUrl($field) {
    $fileUrl = NULL;
    if ($field) {
      $fid = $field['fid'];

      // Getting connection to migrate database.
      $connection = Database::getConnection('default', 'migrate');

      // Getting file url.
      $fileUrl = $connection->select('file_managed', 'f')
        ->fields('f', array('uri'))
        ->condition('f.fid', $fid)
        ->condition('f.status', 1)
        ->execute()
        ->fetchField();

      if ($fileUrl) {
        //replacing public:// to https://ringsted.dk/sites/default/files/
        $fileUrl = preg_replace('/(public:\/\/)/', MigrationHelper::$siteUrl . '/sites/'. MigrationHelper::$fileFolderPath .'/files/', $fileUrl);
      }
    }
    return $fileUrl;
  }

  /**
   * Generates file destination URI.
   *
   * @param mix $field
   *   Array coming from migration source.
   *
   * @return string
   *   File destination URL.
   */
  function generateFileDestinationPath($field) {
    $fileUrl = '';
    if ($field) {
      $fid = $field['fid'];

      // Getting connection to migrate database.
      $connection = Database::getConnection('default', 'migrate');

      // Getting file url.
      $fileUrl = $connection->select('file_managed', 'f')
        ->fields('f', array('uri'))
        ->condition('f.fid', $fid)
        ->condition('f.status', 1)
        ->execute()
        ->fetchField();
    }
    return $fileUrl;
  }

  /**
   * Creates the file based on the URI or finds an existing one.
   *
   * @param string $uri
   *   Uri of the file.
   *
   * @return int
   *   File ID.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  function createFileManaged($uri) {
    $properties['uri'] = $uri;
    $files = \Drupal::entityTypeManager()->getStorage('file')->loadByProperties($properties);

    $file = reset($files);

    if (empty($file)) {
      $filesystem = \Drupal::service('file_system');
      // Create file entity.
      $file = File::create();
      $file->setFileUri($uri);
      $file->setOwnerId(\Drupal::currentUser()->id());
      $file->setMimeType('image/' . pathinfo($uri, PATHINFO_EXTENSION));
      $file->setFileName($filesystem->basename($uri));
      $file->setPermanent();
      $file->save();
    }
    return $file->id();
  }


  /**
   * Create wrapper paragraph.
   *
   * @param $field_os2web_base_field_spotbox
   *
   * @return array
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  function createWrapperParagraph($field_os2web_base_field_spotbox){
    if (!$field_os2web_base_field_spotbox) {
      return [];
    }
    $spotbox_paragraph = Paragraph::create([
      'type' => 'os2web_spotbox_reference',
      'field_os2web_spotbox_reference' => [
        'target_id' => $field_os2web_base_field_spotbox
      ]
    ]);

    $spotbox_paragraph->save();
    // Creating os2web_wrapper paragraph.
    $os2web_wrapper_paragraph = Paragraph::create([
      'type' => 'os2web_wrapper',
      'field_os2web_paragraphs' => [
        'target_id' => $spotbox_paragraph->id(),
        'target_revision_id' =>  $spotbox_paragraph->getRevisionId()
      ]
    ]);
    $os2web_wrapper_paragraph->save();

    return [
      'target_id' => $os2web_wrapper_paragraph->id(),
      'target_revision_id' => $os2web_wrapper_paragraph->getRevisionId(),
    ];
  }

  /**
   * Helper function to populate links fields.
   *
   * @param $link
   *   Link field.
   *
   * @return int|null
   *   Int if the local node is found. NULL otherwise.
   */
  function getFieldLinks($link) {
    if (strpos($link['url'], 'node') === 0) {
      $urlParts = explode('/', $link['url']);

      // Finding local node URL, if present.
      if ($localNid = MigrationHelper::findLocalNode($urlParts[1])) {
        $urlParts[1] = $localNid;
        $link['url'] = implode('/', $urlParts);
      }
    }

    $fieldLink = [
      'title' => $link['title'],
      'url' => $link['url']
    ];

    return $fieldLink;
  }

  /**
   * Helper function to find local node by remote ID.
   *
   * @param $sourceNodeId
   *   Remote node ID.
   *
   * @return int|null
   *   Int if the local node is found. NULL otherwise.
   */
  static function findLocalNode($sourceNodeId) {
    $node_migrate_tables = [
      'migrate_map_faxe_d7_node_indholdside',
    ];

    $database = \Drupal::database();
    foreach ($node_migrate_tables as $table) {
      if ($database->schema()->tableExists($table)) {
        $localNid = $database->select($table)->fields($table, [
          'destid1',
        ])
        ->condition('sourceid1', $sourceNodeId)
        ->execute()
        ->fetchField();

        if ($localNid) {
          return $localNid;
        }
      }
    }

    return NULL;
  }

}
