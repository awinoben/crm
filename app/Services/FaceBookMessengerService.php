<?php


namespace App\Services;


use App\Traits\NodeProcessing;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

class FaceBookMessengerService
{
    use NodeProcessing;

    /**
     * @var Repository|Application|mixed
     */
    private $baseUri;
    /**
     * @var string
     */
    private $bodyType;

    /**
     * create instance of
     * AuthorService
     */
    public function __construct()
    {
        $this->baseUri = 'https://graph.facebook.com/';
        $this->bodyType = 'json';
    }

    /**
     * posting to messenger
     */
    public function sendBasicText()
    {
        $load = [
            'recipient' => [
                'id' => env('PAGE_ID')
            ],
            'message' => [
                'text' => "Hello , testing the outdoor crm messenger api."
            ]
        ];

        return $this->processRequest(
            'v8.0/me/messages?access_token=' . env('PAGE_ACCESS_TOKEN'),
            $load
        );
    }

}
