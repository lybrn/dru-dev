<?php

namespace Drupal\mymodule\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\user\Event\UserLoginEvent;
use Drupal\user\UserEvents;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginSubscriber implements EventSubscriberInterface {

  protected $session;

  public function __construct(SessionInterface $session) {
    $this->session = $session;
  }

  public static function getSubscribedEvents() {
    return [
      UserEvents::LOGIN => 'onUserLogin',
    ];
  }

  public function onUserLogin(UserLoginEvent $event) {
    // Set a flag so we know a login just occurred.
    $this->session->set('mymodule_login_redirect', TRUE);
  }

}