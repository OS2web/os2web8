<?php

namespace Drupal\popular_search_keywords\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormStateInterface;
use Drupal\search_api\Entity\Index;

/**
 * Provides a 'PopularSearchBlock' block.
 *
 * @Block(
 *   id = "popular_search_block",
 *   admin_label = @Translation("Popular Search block"),
 *   deriver = "Drupal\popular_search_keywords\Plugin\Derivative\PopularSearchBlock"
 * )
 */
class PopularSearchBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $numPhrases = range(2, 20);
    $numPhrases[] = 25;
    $numPhrases[] = 30;
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    // Number of top search phrases to display.
    $form['num_phrases'] = [
      '#type' => 'select',
      '#title' => $this->t('Number of top search phrases to display'),
      '#default_value' => empty($config['num_phrases']) ? 8 : $config['num_phrases'],
      '#options' => array_combine($numPhrases, $numPhrases),
    ];

    // To hide the count of searched keywords.
    $form['hide_search_count'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide the count of searched keywords'),
      '#default_value' => empty($config['hide_search_count']) ? 'search' : $config['hide_search_count'],
    ];

    // Path of search page.
    $form['path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Path of search page'),
      '#default_value' => empty($config['path']) ? 'search' : $config['path'],
    ];

    // Parameter name for the search phrase.
    $form['param_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Parameter name for the search phrase'),
      '#default_value' => empty($config['param_name']) ? 'search' : $config['param_name'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {

    $this->setConfigurationValue('num_phrases', $form_state->getValue('num_phrases'));
    $this->setConfigurationValue('path', $form_state->getValue('path'));
    $this->setConfigurationValue('param_name', $form_state->getValue('param_name'));
    $this->setConfigurationValue('hide_search_count', $form_state->getValue('hide_search_count'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $config = $this->getConfiguration();
    $stats = $this->getStats();

    return [
      '#theme' => 'popular_search_keywords_block',
      '#path' => $config['path'],
      '#param_name' => $config['param_name'],
      '#hide_search_count' => ($config['hide_search_count'] ?? ''),
      '#stats' => $stats,
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * Retrieve keywords, num values from database.
   *
   * @return array
   *   An array of the stats retrieved.
   */
  protected function getStats() {

    $result = [];
    $database = Database::getConnection();

    $config = $this->getConfiguration();
    $serverName = $this->getServer();
    $indexName = $this->getDerivativeId();

    $stats = $database->queryRange("SELECT keywords, COUNT(*) as num FROM popular_search WHERE s_name = :s_name AND i_name=:i_name AND keywords != '' GROUP BY `keywords` ORDER BY num DESC",
      0, $config['num_phrases'],
      [':s_name' => $serverName, ':i_name' => $indexName]);
    foreach ($stats as $stat) {
      $result[$stat->keywords] = $stat->num;
    }

    return $result;
  }

  /**
   * Retrieve the index and use it to get the server ID.
   *
   * @return string
   *   The machine name of the Search API server.
   */
  protected function getServer() {

    $result = '';

    $index = $this->getIndex();
    if (!empty($index)) {
      $result = $index->get('server');
    }

    return $result;
  }

  /**
   * Use the block derivative ID to retrieve the index object.
   *
   * @return Drupal\search_api\Entity\Index
   *   The index object.
   */
  protected function getIndex() {

    $id = $this->getDerivativeId();
    $result = Index::load($id);

    return $result;
  }

}
