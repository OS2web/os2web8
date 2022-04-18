<?php

namespace Drupal\du_screen_questions\Form;

use Drupal\Component\Utility\Html;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

/**
 * Configure os2web_borgerdk settings for this site.
 */
class RelatedPagesFilterForm extends FormBase {

  private $formId = 'du_sceen_questions_related_pages_filter_form';
  private $nodeAddedSituationKeys;

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return $this->formId;
  }

  /**
   * @inheritDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state, NodeInterface $node = NULL) {
    // Getting screening question keys.
    $field_du_scr_ques_situation = $node->get('field_du_scr_ques_situation')->getValue();
    $situationKeys = array_column($field_du_scr_ques_situation, 'target_id');

    // Getting screening question titles.
    $field_du_scr_ques_title = $node->get('field_du_scr_ques_title')->getValue();
    $situationTitles = array_column($field_du_scr_ques_title, 'value');

    // Checking if the number of keys and values are the same.
    if (count($situationKeys) !== count($situationTitles)) {
      $min = min(count($situationKeys), count($situationTitles));
      $situationKeys = array_slice($situationKeys, 0, $min);
      $situationTitles = array_slice($situationTitles, 0, $min);
    }

    $this->nodeAddedSituationKeys = $situationKeys;
    $filterOptions = array_combine($situationKeys, $situationTitles);

    // Filtering block.
    $form['situation_filters'] = [
      '#type' => 'checkboxes',
      '#options' => $filterOptions,
      '#ajax' => [
        'callback' => '::updateRelatedPages',
        'wrapper' => 'js-related-pages', // This element is updated with this AJAX callback.
        'progress' => [
          'type' => 'none',
          'message' => NULL,
        ],
      ],
    ];

    // Getting related nodes.
    $selectedSituation = $situationKeys;
    if ($form_state->hasValue('situation_filters')) {
      $situationFilters = $form_state->getValue('situation_filters');
      $situationFilters = array_filter($situationFilters);

      if (!empty($situationFilters)) {
        $selectedSituation = $situationFilters;
      }
    }

    // Returns if we have no situation added.
    if (empty($selectedSituation)) {
      return NULL;
    }

    /** @var \Drupal\Component\Transliteration\TransliterationInterface $trans */
    $trans = \Drupal::service('transliteration');

    // Getting relates pages categories.
    $vid = 'du_screen_category';
    $terms =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);
    foreach ($terms as $term) {
      $relatedPageCategories[$term->tid] = [
        'name' => $term->name,
        'transliteratedName' => Html::getClass($trans->transliterate($term->name)),
        'nodes' => [],
      ];
    }

    // Getting relates pages.
    $query = \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('field_du_screen_situation', $selectedSituation, 'IN')
      ->exists('field_du_screen_category');
    $nids = $query->execute();

    $nodes = Node::loadMultiple($nids);
    foreach ($nodes as $node) {
      $view_builder = \Drupal::entityTypeManager()->getViewBuilder('node');
      $build = $view_builder->view($node, 'teaser');
      $nodeRendered = \Drupal::service('renderer')->render($build);
      $relatedPageCategories[$node->field_du_screen_category->target_id]['nodes'][] = $nodeRendered;
    }

    $form['related_pages_categories'] = [
      '#type' => 'container',
      '#theme' => 'du_screen_questions_related_pages_container',
      '#related_pages_categories' => $relatedPageCategories,
      '#attributes' => [
        'id' => ['js-related-pages'],
      ],
    ];

    return $form;
  }

  public function updateRelatedPages(array $form, FormStateInterface $form_state) {
    $form_state->setRebuild(TRUE);
    return $form['related_pages_categories'];
  }

  /**
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

}
