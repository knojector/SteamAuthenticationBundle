[![GitHub license](https://img.shields.io/github/license/knojector/SteamAuthenticationBundle)](https://github.com/knojector/SteamAuthenticationBundle/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/knojector/SteamAuthenticationBundle)](https://github.com/knojector/SteamAuthenticationBundle/issues)
[![GitHub issues](https://img.shields.io/github/issues-pr/knojector/SteamAuthenticationBundle)](https://github.com/knojector/SteamAuthenticationBundle/pulls)
[![GitHub issues](https://img.shields.io/github/stars/knojector/SteamAuthenticationBundle)](https://github.com/knojector/SteamAuthenticationBundle/stargazers)

# SteamAuthenticationBundle - Steam authentication for Symfony

The SteamAuthenticationBundle provides an easy way to integrate Steams OpenID login for your application.

## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
- [Bugs and ideas?](#bugs-and-ideas)
- [Requirements](#requirements)

## Installation

### Step 1 - Install the bundle
```shell
composer require knojector/steam-authentication-bundle
```

### Step 2 - Configuration
```yaml
knojector_steam_authentication:
    login_success_redirect: 'app.protected_route'
    login_failure_redirect: 'app.error_route'
```
As you can see there are only two options available for configuration. Both are very self-explanatory. The option `login_success_redirect` contains the name of the route the user should be redirected to if the login was successful. The option `login_failure_redirect` contains the route the user is redirected to if the login fails.


Furthermore you have to adjust your `security.yml`. In the following snippet you can see an example with a basic configuration. There are only two important things to consider:
- The firewall name must be `steam`
- You can use any user provider as long as the Steam CommunityId is the property to query for
```yaml
security:
    providers:
        users:
            entity:
              class: 'App\Entity\User'
              property: 'username'
      firewalls:
          dev:
              pattern: ^/(_(profiler|wdt)|css|images|js)/
              security: false
          steam:
              pattern: ^/
              anonymous: true
              lazy: true
              provider: users
```

The final step is to enable the bundle's controller in your `routes.yaml`
```yaml
steam_authentication_callback:
  path: /steam/login_check
  controller: Knojector\SteamAuthenticationBundle\Controller\SteamController::callback
```
## Usage

### Step 1 - Create your own registration subscriber
Technically there is no registration available in this bundle. The bundle receives an ID from Steam and tries to load a user via the configured user provider. If no user exists you can assume that the user logged in for the first time. Instead of throwing an exception, the bundle dispatches an event you can subscribe to. A simple example for your subscriber is shown below

```php
<?php

namespace App\Subscriber;

use App\Entity\User;
use Knojector\SteamAuthenticationBundle\Event\AuthenticateUserEvent;
use Knojector\SteamAuthenticationBundle\Event\FirstLoginEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FirstLoginSubscriber implements EventSubscriberInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            FirstLoginEvent::NAME => 'onFirstLogin'
        ];
    }

    public function onFirstLogin(FirstLoginEvent $event)
    {
        $communityId = $event->getCommunityId();
        
        $user = new User();
        $user->setUsername($communityId);
        
        // e.g. call the Steam API to fetch more profile information
        // e.g. create user entity and persist it
        
        // dispatch the authenticate event in order to sign in the new created user.
        $this->eventDispatcher->dispatch(new AuthenticateUserEvent($user), AuthenticateUserEvent::NAME);
    }
}
```

### Step 2 - Place the login button
To place the "Sign in through Steam" button you can include the following snippet in your template
```
{% include '@KnojectorSteamAuthentication/button.html.twig' %}
```

## Bugs and ideas?
Feel free to open an issue or submit a pull request :wink:

## Requirements
The bundle requires:
- PHP 7.0+
- Symfony 4.0