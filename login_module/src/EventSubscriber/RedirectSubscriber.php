<?php

namespace Drupal\mymodule\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Drupal\Core\Session\AccountProxyInterface;

class RedirectSubscriber implements EventSubscriberInterface {

  protected $session;
  protected $currentUser;

  public function __construct(SessionInterface $session, AccountProxyInterface $current_user) {
    $this->session = $session;
    $this->currentUser = $current_user;
  }

  public static function getSubscribedEvents() {
    return [
      // Run after routing is known but early enough to redirect
      'kernel.request' => ['onRequest', 30],
    ];
  }

  public function onRequest(RequestEvent $event) {
    // Only act on main request (not subrequests)
    if (!$event->isMainRequest()) {
      return;
    }

    // Only redirect authenticated users
    if (!$this->currentUser->isAuthenticated()) {
      return;
    }

    // Check our flag
    if ($this->session->get('mymodule_login_redirect')) {

      // Clear it so it only happens once
      $this->session->remove('mymodule_login_redirect');

      // Perform redirect
      $response = new RedirectResponse('/success');
      $event->setResponse($response);
    }
  }

}