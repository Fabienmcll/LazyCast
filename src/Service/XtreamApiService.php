<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class XtreamApiService
{
    private HttpClientInterface $client;
    private string $apiUrl;
    private string $username;
    private string $password;
    private string $action;
    private string $categoryId;
    private string $serieId;

    public function setAction(string $action): void
    {
        $this->action = $action;
    }
    public function setApiUrl(string $apiUrl): void
    {
        $this->apiUrl = $apiUrl;
    }
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function setSerieId(string $serieId): void
    {
        $this->serieId = $serieId;
    }
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }
    public function getUsername(): string
    {
        return $this->username;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getAction(): string
    {
        return $this->action;
    }
    public function getSerieId(): string
    {
        return $this->serieId;
    }

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function setCategoryId(string $categoryId): void
    {
        $this->categoryId = $categoryId;
    }
    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function getSerieDetails(): array
    {
        $url = $this->apiUrl . '?username=' . $this->username . "&password=" . $this->password . "&action=" . $this->action . '&series_id=' . $this->serieId;
        $response = $this->client->request('GET', $url, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'Accept' => 'application/json',
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception("Erreur API : " . $response->getStatusCode());
        }

        return $response->toArray();
    }

    public function getAllSeries(): array
    {
        $url = $this->apiUrl . '?username=' . $this->username . "&password=" . $this->password . "&action=" . $this->action;
        $response = $this->client->request('GET', $url, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'Accept' => 'application/json',
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception("Erreur API : " . $response->getStatusCode());
        }

        return $response->toArray();
    }

    public function getWithCategoryId(int $categ_id): array
    {
        $url = $this->apiUrl . '?username=' . $this->username . "&password=" . $this->password . "&action=" . $this->action . "&category_id=" . $categ_id;
        $response = $this->client->request('GET', $url, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'Accept' => 'application/json',
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception("Erreur API : " . $response->getStatusCode());
        }

        return $response->toArray();
    }

    public function getVodStreams(): array
    {
        $url = $this->apiUrl . '?username=' . $this->username . "&password=" . $this->password . "&action=" . $this->action;
        $response = $this->client->request('GET', $url, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'Accept' => 'application/json',
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception("Erreur API : " . $response->getStatusCode());
        }

        return $response->toArray();
    }
}