<?php

namespace Drupal\fic_office_hours\EventSubscriber;

use Drupal\fic_office_hours\OfficeHoursSeasonDisplayFilter;
use Drupal\office_hours\Event\OfficeHoursEvent;
use Drupal\office_hours\Event\OfficeHoursEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Applies season/normal-hours display filtering before Office Hours formats.
 */
class OfficeHoursSeasonSubscriber implements EventSubscriberInterface {

  /**
   * Constructs the subscriber.
   *
   * @param \Drupal\fic_office_hours\OfficeHoursSeasonDisplayFilter $seasonDisplayFilter
   *   The season display filter.
   */
  public function __construct(
    protected OfficeHoursSeasonDisplayFilter $seasonDisplayFilter,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    // Run late so other PRE_FORMAT listeners can add/alter items first.
    return [
      OfficeHoursEvents::PRE_FORMAT => ['onPreFormat', -100],
    ];
  }

  /**
   * Filters items before the formatter builds display rows.
   *
   * @param \Drupal\office_hours\Event\OfficeHoursEvent $event
   *   The Office Hours event.
   */
  public function onPreFormat(OfficeHoursEvent $event): void {
    $this->seasonDisplayFilter->filter($event->getItems(), $event->getTimestamp());
  }

}
