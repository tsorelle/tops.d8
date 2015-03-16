<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 3/12/2015
 * Time: 10:05 AM
 */
namespace Drupal\tops\EventSubscriber;

use Drupal\Core\Path\AliasManagerInterface;
use Drupal\Core\Path\CurrentPathStack;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tops\drupal\TViewModel;

class TopsSubscriber implements EventSubscriberInterface {

    public function checkForViewModel(GetResponseEvent $event) {
        $req = $event->getRequest();
        TViewModel::Initialize($req);
    }

    /**
     * {@inheritdoc}
     */
    static function getSubscribedEvents() {

        // $events[KernelEvents::VIEW][] = array('checkForViewModel');
        $events[KernelEvents::REQUEST][] = array('checkForViewModel');
        return $events;
    }

}

