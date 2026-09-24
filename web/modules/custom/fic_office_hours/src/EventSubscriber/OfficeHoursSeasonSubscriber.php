<?php

namespace Drupal\fic_office_hours\EventSubscriber;

use Drupal\fic_office_hours\OfficeHoursSeasonDisplayFilter;
use Drupal\office_hours\Event\OfficeHoursEvent;
use Drupal\office_hours\Event\OfficeHoursEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Prepares Office Hours items before formatting (season swap / cleanup).
 */
class OfficeHoursSeasonSubscriber implements EventSubscriberInterface {

  /**
   * Constructs the subscriber.
   */
  public function __construct(
    protected OfficeHoursSeasonDisplayFilter $seasonDisplayFilter,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    // Run late so other PRE_FORMAT listeners can alter items first.
    return [
      OfficeHoursEvents::PRE_FORMAT => ['onPreFormat', -100],
    ];
  }

  /**
   * Strips inactive seasons / remaps active season before OH formats rows.
   *
   * @param \Drupal\office_hours\Event\OfficeHoursEvent $event
   *   The Office Hours event.
   */
  public function onPreFormat(OfficeHoursEvent $event): void {
    $this->seasonDisplayFilter->prepareItemsForFormatting(
      $event->getItems(),
      $event->getTimestamp()
    );
  }

}
