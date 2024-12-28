<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $apiKey = "808067842d5ac71b85d08a47e7c4ea66";

    //consulta de deporte generales
    protected function getSports()
    {
        $client = new Client();
        $res = $client->get("https://api.the-odds-api.com/v4/sports/?apiKey={$this->apiKey}");
        return json_decode($res->getBody(), true);
    }

    //consulta de la asociacion de deportes, region y tipo de mercado de apuestas
    protected function getOdds($sports, $regions, $markets)
    {
        $client = new Client();
        $res = $client->get("https://api.the-odds-api.com/v4/sports/{$sports}/odds/?apiKey={$this->apiKey}&regions={$regions}&markets={$markets}");
        return json_decode($res->getBody(), true);
    }

    protected function getScores($sports, $daysFrom)
    {
        $client = new Client();
        $res = $client->get("https://api.the-odds-api.com/v4/sports/{$sports}/scores/?daysFrom={$daysFrom}&apiKey={$this->apiKey}");
        return json_decode($res->getBody(), true);
    }

    protected function getEvents($sports)
    {
        $client = new Client();
        $res = $client->get("https://api.the-odds-api.com/v4/sports/{$sports}/events?apiKey={$this->apiKey}");
        return json_decode($res->getBody(), true);
    }

    protected function getEventsOdds($sports, $idEvents, $regions, $markets, $oddsFormat)
    {
        $client = new Client();
        $res = $client->get("https://api.the-odds-api.com/v4/sports/{$sports}/events/{$idEvents}/odds?apiKey={$this->apiKey}&regions={$regions}&markets={$markets}&oddsFormat={$oddsFormat}");
        return json_decode($res->getBody(), true);
    }

    //https://api.the-odds-api.com/v4/sports/americanfootball_nfl/events/1bccaf2a9388f9d02f8f0c23cbc6b121/odds?apiKey=808067842d5ac71b85d08a47e7c4ea66&regions=us&markets=player_pass_tds,h2h,spreads,totals&oddsFormat=american
}

//player_pass_tds%2Ch2h%2Cspreads%2Ctotals