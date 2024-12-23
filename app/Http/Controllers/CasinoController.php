<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CasinoController extends Controller
{

    public function game()
    {
        $agentToken=ENV('AGENT_TOKEN');
        $postArray = [
            'method' => 'game_list',
            'agent_code' => 'juv_ARS',
            'agent_token' => $agentToken,
            "provider_code" => 'PRAGMATIC',
        ];

        $client = new Client();
        $response = $client->post('https://api.fiverscan.com', [
            'json' => $postArray,
            'headers' => ['Content-Type' => 'application/json'],
            'timeout' => 5,
        ]);

        $res = $response->getBody()->getContents();
        $decodedRes = json_decode($res, true);

        return response()->json($decodedRes, 200, [], JSON_PRETTY_PRINT);
    }

    public function gameProvider($id)
    {
        $agentToken=ENV('AGENT_TOKEN');
        $postArray = [
            'method' => 'game_list',
            'agent_code' => 'juv_ARS',
            'agent_token' => $agentToken,
            "provider_code" => $id,
        ];

        $client = new Client();
        $response = $client->post('https://api.fiverscan.com', [
            'json' => $postArray,
            'headers' => ['Content-Type' => 'application/json'],
            'timeout' => 5,
        ]);

        $res = $response->getBody()->getContents();
        $decodedRes = json_decode($res, true);

        return response()->json($decodedRes, 200, [], JSON_PRETTY_PRINT);
    }

    public function provider()
    {
        $agentToken=ENV('AGENT_TOKEN');
        $postArray = [
            'method' => 'provider_list',
            'agent_code' => 'juv_ARS',
            'agent_token' => $agentToken,
        ];

        $client = new Client();
        $response = $client->post('https://api.fiverscan.com', [
            'json' => $postArray,
            'headers' => ['Content-Type' => 'application/json'],
            'timeout' => 5,
        ]);

        $res = $response->getBody()->getContents();
        $decodedRes = json_decode($res, true);

        return response()->json($decodedRes, 200, [], JSON_PRETTY_PRINT);
    }
}
