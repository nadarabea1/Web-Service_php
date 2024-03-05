<?php

class Weather {
    private $apiKey;
    private $weatherUrl;
    private $citiesFile;

    public function __construct($apiKey, $weatherUrl, $citiesFile) {
        $this->apiKey = $apiKey;
        $this->weatherUrl = $weatherUrl;
        $this->citiesFile = $citiesFile;
    }

    public function getCities() {
        $cities = [];
        $data = json_decode(file_get_contents($this->citiesFile), true);
        foreach ($data as $city) {
            if ($city['country'] == 'EG') {
                $cities[$city['id']] = $city['name'];
            }
        }
        return $cities;
    }

    public function getWeather($cityId) {
        $url = str_replace(['{{cityid}}', '{{apikey}}'], [$cityId, $this->apiKey], $this->weatherUrl);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}