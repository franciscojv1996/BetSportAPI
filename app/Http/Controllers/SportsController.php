<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SportsController extends Controller
{
    public function index()
    {
        $basketballKeys = [];
        $soccerKeys = [];
        $basketballData = [];
        $soccerKeysData = [];

        $apiKey = "1fe9dc25095e1dcc4f7ee2c331374298";
        $client = new Client();
        $res = $client->get("https://api.the-odds-api.com/v4/sports/?apiKey={$apiKey}");
        $data = json_decode($res->getBody(), true);

        if ($data === null) {
            return response()->json(['error' => 'Error al decodificar la respuesta de la API'], 500);
        }


        $filterData = array_filter($data, function ($sport) {
            return in_array($sport['group'], ['Basketball', 'Soccer']);
        });
        $filterData = array_values($filterData);

        foreach ($data as $item) {
            if ($item['group'] === 'Basketball') {
                $basketballKeys[] = $item['key'];
            } else if ($item['group'] === 'Soccer') {
                $soccerKeys[] = $item['key'];
            }
        }

        foreach ($basketballKeys as $key) {
            try {
                $response = $client->get("https://api.the-odds-api.com/v4/sports/{$key}/odds/?apiKey={$apiKey}&regions=us&markets=h2h,spreads,totals");
                $basketballData[] = json_decode($response->getBody(), true);
            } catch (\Exception $e) {
                error_log("Error fetching data for key {$key}: " . $e->getMessage());
            }
        }

        foreach ($soccerKeys as $key) {
            try {
                $response = $client->get("https://api.the-odds-api.com/v4/sports/{$key}/odds/?apiKey={$apiKey}&regions=us&markets=h2h,spreads,totals");
                $soccerKeysData[] = json_decode($response->getBody(), true);
            } catch (\Exception $e) {
                error_log("Error fetching data for key {$key}: " . $e->getMessage());
            }
        }

        return response()->json([
            'basketballData' => $basketballData,
            'soccerKeysData' => $soccerKeysData,
            'basketballKeys' => $basketballKeys,
            'soccerKeys' => $soccerKeys,
        ]);
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
