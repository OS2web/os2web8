<?php
namespace Drupal\bc_taxonomy_reference_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @Block (
 *   id = "taxblock",
 *   admin_label = "some taxblock label"
 * )
 */
Class TaxBlock extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) : array {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    $form['field'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Entity field'),
      '#description' => $this->t('The target_id field that is connected to the taxonomy.'),
      '#default_value' => $config['field'] ?? '',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) : void {
    parent::blockSubmit($form, $form_state);

    $this->configuration['field'] = $form_state->getValue('field');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    $list = \Drupal\bc_taxonomy_reference_block\Controller\TaxonomyReference::getList($config['field']);

    $renderable = array(
      '#theme' => 'taxonomy-reference-block',
      '#listdata' => $list,
    );

    return $renderable;
  }

}
