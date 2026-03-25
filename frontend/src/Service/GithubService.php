<?php

namespace Frontend\Service;

class GithubService
{
    private string $baseUrl = 'https://api.github.com';

    public function getUser(string $username): array
    {
        $url = $this->baseUrl . "/users/" . $username;

        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: PHP\r\n"
            ]
        ]);

        $response = file_get_contents($url, false, $context);

        return json_decode($response, true);
    }
}