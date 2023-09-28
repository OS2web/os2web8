<?php

use Drupal\Core\Database\Database;

$database = \Drupal::database();
$migrateDatabase = Database::getConnection('default', 'migrate');

$jsonFilePath = '/var/www/nodeDocuments.json';

if (file_exists($jsonFilePath) && is_readable($jsonFilePath)) {
  $jsonContent = file_get_contents($jsonFilePath);

  // Check if the file content was successfully read.
  if ($jsonContent !== false) {
    // Decode the JSON content into a PHP array.
    $data = json_decode($jsonContent, true); // The 'true' argument returns an associative array.

    // Check if JSON decoding was successful.
    if ($data !== null) {
      $i = 1;
      foreach ($data as $nid => $row) {
        $localNid = \Drupal\fk_d7_migration\Utility\MigrationHelper::findLocalNode($nid);

        if ($localNid) {
          $node = \Drupal\node\Entity\Node::load($localNid);

          print_r($i . '. ' . $node->label() . ' [' . $node->id() . ']: ' . $node->toUrl()->setAbsolute()->toString());
          $body = $node->field_os2web_page_description->value;
          $body .= '<p>Dokumenter: ' . $row . '</p>';
          $node->field_os2web_page_description->value = $body;
          $node->field_os2web_page_description->format = 'wysiwyg_tekst';
          $node->save();
          print_r(PHP_EOL);
          $i++;
        }
      }
    } else {
      echo "Error decoding JSON.";
    }
  } else {
    echo "Error reading the JSON file.";
  }
} else {
  echo "The JSON file does not exist or is not readable.";
}
