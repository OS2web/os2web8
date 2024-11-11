<?php

namespace Drupal\popular_search_keywords\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\search_api\Entity\Index;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides block plugin definitions for popular_search_keywords blocks.
 *
 * @see Drupal\popular_search_keywords\Plugin\Block\PopularSearchBlock
 */
class PopularSearchBlock extends DeriverBase implements ContainerDeriverInterface {
  use StringTranslationTrait;

  /**
   * List of derivative definitions.
   *
   * @var array
   */
  protected $derivatives = [];

  /**
   * The base plugin ID this derivative is for.
   *
   * @var string
   */
  protected $basePluginId;

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs an EntityDeriver object.
   *
   * @param string $base_plugin_id
   *   The base plugin ID.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_manager
   *   The entity manager.
   */
  public function __construct($base_plugin_id, EntityTypeManagerInterface $entity_manager) {
    $this->basePluginId = $base_plugin_id;
    $this->entityTypeManager = $entity_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
    $base_plugin_id,
    $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    $this->derivatives = [];

    /** @var \Drupal\search_api\Entity\Index[] $indexes */
    $indexes = Index::loadMultiple();
    foreach ($indexes as $key => $index) {
      $this->derivatives[$key] = $base_plugin_definition;
      $this->derivatives[$key]['admin_label'] = $this->t('Popular search block: :label', [':label' => $index->label()]);
      $this->derivatives[$key]['config_dependencies']['config'] = [];
    }

    return $this->derivatives;
  }

}
