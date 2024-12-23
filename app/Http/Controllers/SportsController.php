<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SportsController extends Controller
{
    public function index()
    {
        $apiKey = env('API_KEY');
        $client = new Client();
        $res = $client->get("https://api.the-odds-api.com/v4/sports/?apiKey={$apiKey}");
        $data = json_decode($res->getBody(), true);
        return response()->json($data);
    }
    public function soccer()
    {
        $apiKey = env('API_KEY');
        $client = new Client();
        $res = $client->get("https://api.the-odds-api.com/v4/sports/?apiKey={$apiKey}");
        $data = json_decode($res->getBody(), true);

        $soccerData = $this->filterDataByGroup($data, 'soccer');

        return response()->json($soccerData);
    }

    public function basketball()
    {
        $apiKey = env('API_KEY');
        $client = new Client();
        $res = $client->get("https://api.the-odds-api.com/v4/sports/?apiKey={$apiKey}");
        $data = json_decode($res->getBody(), true);

        $basketballData = $this->filterDataByGroup($data, 'basketball');

        return response()->json($basketballData);
    }

    private function filterDataByGroup($data, $group)
    {
        return array_filter($data, function ($item) use ($group) {
            return isset($item['group']) && strtolower($item['group']) === strtolower($group);
        });
    }
}
