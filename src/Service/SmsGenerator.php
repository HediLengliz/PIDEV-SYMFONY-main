<?php

namespace App\Service;

use Twilio\Rest\Client;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;

class TwilioService
{
    private $client;

    public function __construct()
    {
        try {
            $sid = $_ENV['twilio_account_sid'];
            $token = $_ENV['twilio_auth_token'];
            $this->client = new Client($sid, $token);
        } catch (ConfigurationException $e) {
            // Handle configuration exceptions, for example:
            error_log('Twilio Configuration Error: ' . $e->getMessage());
            // Depending on your application's needs, you might want to throw the exception, return, or handle it differently
        }
    }

    public function sendSms($to, $body): ?string
    {
        try {
            $from = $_ENV['twilio_from_number'];
            $message = $this->client->messages->create($to, [
                'from' => $from,
                'body' => $body
            ]);
            return $message->sid;
        } catch (TwilioException $e) {
            // Handle general Twilio exceptions, for example:
            error_log('Twilio Error: ' . $e->getMessage());
            // Depending on your application's needs, you might want to throw the exception, return null, or handle it differently
            return null;
        }
    }
}