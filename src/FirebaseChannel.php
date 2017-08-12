<?php

namespace Liliom\Firebase;

use Liliom\Firebase\Exceptions\CouldNotSendNotification;
use Liliom\Firebase\Exceptions\InvalidConfiguration;
use Illuminate\Notifications\Notification;
use GuzzleHttp\Client;

class FirebaseChannel
{
    /**
     * The API URL for Firebase
     */
    const API_URI = 'https://fcm.googleapis.com/fcm/send';

    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \Liliom\Firebase\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toFirebase($notifiable);

        if ($message->recipientNotGiven()) {
            if (!$to = $notifiable->routeNotificationFor('firebase')) {
                throw CouldNotSendNotification::missingRecipient();
            }

            $message->to($to);
        }

        $this->client->post(self::API_URI, [
            'headers' => [
                'Authorization' => 'key=' . $this->getApiKey(),
                'Content-Type'  => 'application/json',
            ],
            'body' => $message->payload(),
        ]);
    }

    /**
     * @return string
     */
    private function getApiKey()
    {
        $key = config('services.firebase.key');
        if (is_null($key)) {
            throw InvalidConfiguration::configurationNotSet();
        }

        return $key;
    }
}
