<?php

declare(strict_types=1);

namespace App\NasaMarsAPI;

use App\Entity\HolidaysDates;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class NasaMarsAPIClient
{
    private array $rovers;
    private array $cameras;
    private string $nasaMarsApiV1Url;
    private string $nasaApiKey;
    private HttpClientInterface $httpClient;

    public function __construct(Rovers $rovers, Cameras $cameras, string $nasaMarsApiV1Url, string $nasaApiKey)
    {
        $this->httpClient = HttpClient::create();
        $this->rovers = $rovers->getRovers();
        $this->cameras = $cameras->getCameras();
        $this->nasaMarsApiV1Url = $nasaMarsApiV1Url;
        $this->nasaApiKey = $nasaApiKey;
    }

    public function getImagesForDate(HolidaysDates $date): array
    {
        $images = [];

        foreach ($this->buildRequestsUrls($date) as $requestUrl) {
            $response = $this->httpClient->request('GET', $requestUrl);
            $photos = $response->toArray()['photos'] ?? null;
            if ($photos) {
                foreach ($photos as $photo) {
                    $images[] = $photo;
                }
            }
        }

        return $images;
    }

    private function buildRequestsUrls(HolidaysDates $date): array
    {
        $requestsUrls = [];

        foreach ($this->rovers as $rover) {
            foreach ($this->cameras as $camera) {
                $requestsUrls[] = $this->nasaMarsApiV1Url . $rover
                    . "/photos?earth_date=" . $date->getDate()->format('Y-m-d')
                    . "&camera=" . $camera
                    . "&api_key=" . $this->nasaApiKey;
            }
        }

        return $requestsUrls;
    }

}