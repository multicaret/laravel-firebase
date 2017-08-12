# laravel-firebase
This package makes it easy to send notifications using [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging/) (FCM) with Laravel Notification Channel.

## Installation

This package can be installed through Composer.

``` bash
composer require liliom/laravel-firebase
```

If you don't use Laravel 5.5+ you have to add the service provider manually

```php
// config/app.php
'providers' => [
    ...
    Liliom\Firebase\FirebaseServiceProvider::class,
    ...
];
```

Now add you Firebase API Key in `config/services.php`.

```php
return [
	....
    'firebase' => [
        'key' => ''
    ],
    ....
];
```

## Usage

Les's create a notification using artisan commend:

```bash
php artisan make:notification FirebaseNotification
```

Now you can use `firebase` channel in your `vie()` mothod.

```php
public function via($notifiable)
{
    return ['firebase'];
}
```

Add a pubilc method `toFirebase($notifiable)` to your notification class, and return an instance of `FirebaseMessage`:

```php
public function toFirebase($notifiable)
{
    return (new \Liliom\Firebase\FirebaseMessage)
        ->notification([
            'title' => 'Notification title',
            'body' => 'Notification body',
            'sound' => '', // Optional
	        'icon' => '', // Optional
	        'click_action' => '' // Optional
        ])
        ->setData([
	        'param' => 'zxy' // Optional
	    ])
	    ->setPriority('high'); // Default is 'normal'
}
```

## Available methods:

- `setData`: To Set `data`.
- `setPriority`: To Set `priority`.
- `setTimeToLive`: To Set `time_to_live`.
- `setCollapseKey`: To Set `collapse_key`.
- `setNotification`: To Set `notification`.
- `setCondition`: To Set `condition`.
- `setContentAvailable`: To Set `content_available`.
- `setMutableContent`: To Set `mutable_content`.
- `setPackageName`: To Set `restricted_package_name`.

When sending to specific device(s), make sure your notifiable entity has `routeNotificationForFirebase` method defined:
> **Note:** You can send to many devices by return an array of tokens.

```php
/**
 * Route notifications for Firebase channel.
 *
 * @return string|array
 */
public function routeNotificationForFirebase()
{
    return $this->device_tokens;
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
