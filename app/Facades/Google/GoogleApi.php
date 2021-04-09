<?php

namespace App\Facades\Google;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class GoogleApi
{
    private $baseUrl = 'https://fcm.googleapis.com/fcm/send';
    private $client;
    private $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 50,
        ]);

//         $this->apiKey = env('GOOGLE_API_KEY');
    }

    public function masajidSearch($data)
    {
        $response = $this->client->get('/maps/api/place/nearbysearch/json', [
            RequestOptions::QUERY => [
                'key' => $this->apiKey,
                'location' => "{$data->lat},{$data->long}",
                'radius' => $data->radius,
                'type' => 'mosque',
            ]
        ]);

        return  json_decode($response->getBody()->getContents());
    }

    public function masajidDistanceTime($data, $place_id)
    {
        $response = $this->client->get('/maps/api/directions/json', [
            RequestOptions::QUERY => [
                'key' => $this->apiKey,
                'origin' => "{$data->lat},{$data->long}",
                'destination' => 'place_id:'.$place_id,
                'mode' => 'driving',
            ]
        ]);

        return  json_decode($response->getBody()->getContents());
    }


    public function masajidPlaceCountry($data)
    {
        $response = $this->client->get('/maps/api/geocode/json', [
            RequestOptions::QUERY => [
                'key' => $this->apiKey,
                'latlng' => "{$data->lat},{$data->long}",
//                'address' => $data->$address,
//                'place_id' => $data->google_masajid_id,
                'sensor' => false,
            ]
        ]);

        return  json_decode($response->getBody()->getContents());
    }


    public function getCityData($cityName)
    {
        $response = $this->client->get('/maps/api/geocode/json', [
            RequestOptions::QUERY => [
                'key' => $this->apiKey,
                'components' => "administrative_area:,{$cityName}",
            ]
        ]);

        return  json_decode($response->getBody()->getContents());
    }

    public function nonMasajidSearch($data)
    {
        $response = $this->client->get('/maps/api/place/nearbysearch/json', [
            RequestOptions::QUERY => [
                'key' => $this->apiKey,
                'location' => "{$data->lat},{$data->long}",
                'radius' => $data->radius,
                'type' => $data->type,
                'pagetoken' => $data->pagetoken ?? '',
            ]
        ]);

        return  json_decode($response->getBody()->getContents());
    }

}
