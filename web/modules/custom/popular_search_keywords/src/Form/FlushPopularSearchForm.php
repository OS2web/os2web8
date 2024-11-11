<?php

namespace Drupal\popular_search_keywords\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;

/**
 * Form to handle postcode autocomplete.
 */
class FlushPopularSearchForm extends FormBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * The messenger.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * FlushPopularSearchForm constructor.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger.
   */
  public function __construct(Connection $connection, MessengerInterface $messenger) {
    $this->connection = $connection;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
       $container->get('database'),
       $container->get('messenger')
     );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'flush_popular_search';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['tabs'] = [
      '#type' => 'horizontal_tabs',
    ];

    $form['popular_search'] = [
      '#type' => 'details',
      '#title' => $this->t('Flush popular search keywords'),
      '#description' => $this->t('It will truncate all popular search keywords from the website. Please perform it carefully.'),
      '#open' => TRUE,
      '#group' => 'tabs',
    ];

    $form['popular_search']['button'] = [
      '#type' => 'submit',
      '#value' => $this->t('Flush popular search'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $form_state->setRedirectUrl(Url::fromRoute('popular_search_keywords.popular_search_delete'));
  }

}
