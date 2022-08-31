<?php

namespace Drupal\bc_utility\Plugin\RulesAction;

use Drupal\node\NodeInterface;
use Drupal\rules\Core\RulesActionBase;

/**
 * Sets state for the node ans saved is.
 *
 * @RulesAction(
 *   id = "bc_utility_node_set_state_save",
 *   label = @Translation("Set state for selected node and save"),
 *   category = @Translation("Content"),
 *   context_definitions = {
 *     "node" = @ContextDefinition("entity:node",
 *       label = @Translation("Node"),
 *       description = @Translation("Sets the content state and save."),
 *       assignment_restriction = "selector"
 *     ),
 *    "moderation_state" = @ContextDefinition("string",
 *       label = @Translation("Moderation state"),
 *       description = @Translation("New node moderation state."),
 *       default_value = "foraeldet",
 *     ),
 *   }
 * )
 */
class NodeSetStateSave extends RulesActionBase {

  /**
   * Executes the action with the given context.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node to modify.
   * @param string $moderation_state
   *   The moderation state to test against.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function doExecute(NodeInterface $node, $moderation_state) {
    $node->set('moderation_state', $moderation_state);
    $node->save();
  }
}
