<?php

namespace Drupal\faxe_d7_migration\Utility;

use Drupal\Core\Database\Database;
use Drupal\file\Entity\File;
use Drupal\os2web_borgerdk\Entity\BorgerdkArticle;
use Drupal\os2web_borgerdk\Entity\BorgerdkMicroarticle;
use Drupal\os2web_borgerdk\Entity\BorgerdkSelfservice;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\taxonomy\Entity\Term;

class MigrationHelper {

  public static $siteUrl = 'https://lokalarkiv.faxekommune.dk';
  public static $fileFolderPath = 'lokalarkiv.subsites.faxekommune.dk';

  function createUrlFromNid($nid) {
    return MigrationHelper::$siteUrl . '/node/' . $nid;
  }

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
   * Find or create term 'Media' in os2web_keyword vocabulary.
   *
   * @param int $nid
   *   Node Id.
   *
   * @return array
   *   [
   *     'tid'
   *   ]
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  function createMediaKeywordTerm($nid) {
    $name = 'Media';
    $vid = 'os2web_keyword';

    $properties['name'] = $name;
    $properties['vid'] = $vid;

    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties($properties);
    $term = reset($terms);

    if (empty($term)) {
      $term = Term::create([
        'name' => $name,
        'vid' => $vid,
      ]);
      $term->save();
    }

    return [$term->id()];
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
   * Helper function to find local node by remote ID.
   *
   * @param $sourceNodeId
   *   Remote node ID.
   *
   * @return int|null
   *   Int if the local node is found. NULL otherwise.
   */
  function findLocalNode($sourceNodeId) {
    $node_migrate_tables = [
      'migrate_map_ballerup_d7_node_gallery_slide',
      'migrate_map_ballerup_d7_node_indholdside',
      'migrate_map_ballerup_d7_node_institution_page',
      'migrate_map_ballerup_d7_node_news',
    ];

    $database = \Drupal::database();
    foreach ($node_migrate_tables as $table) {
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

    return NULL;
  }

}
