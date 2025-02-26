<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class XtreamApiService
{
    private HttpClientInterface $client;
    private string $apiUrl = "http://365hub.cc:2103/player_api.php";
    private string $username = "aFAChxw1";
    private string $password = "crjkQz2";
    private string $action = "get_vod_streams";

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

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getVodStreams(): array
    {
        $url=$this->apiUrl . '?username=' . $this->username . "&password=" . $this->password . "&action=" . $this->action;
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
