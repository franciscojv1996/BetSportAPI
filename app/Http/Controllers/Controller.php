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

    protected function findSportTitle($sportKey)
    {
        $sports = [
            "USA" => [
                "basketball_nba",
                "basketball_nba_championship_winner",
                "basketball_ncaab",
                "basketball_ncaab_championship_winner",
                "basketball_wncaab",
                "soccer_efl_champ"
            ],
            "Australia" => [
                "basketball_nbl",
                "soccer_australia_aleague"
            ],
            "England" => [
                "soccer_epl",
                "soccer_england_efl_cup",
                "soccer_england_league1",
                "soccer_england_league2",
                "soccer_fa_cup"
            ],
            "Austria" => ["soccer_austria_bundesliga"],
            "France" => [
                "soccer_france_ligue_one",
                "soccer_france_ligue_two"
            ],
            "Germany" => [
                "soccer_germany_bundesliga",
                "soccer_germany_bundesliga2"
            ],
            "Greece" => ["soccer_greece_super_league"],
            "Italy" => [
                "soccer_italy_serie_a",
                "soccer_italy_serie_b"
            ],
            "Ireland" => ["soccer_league_of_ireland"],
            "Mexico" => ["soccer_mexico_ligamx"],
            "Netherlands" => ["soccer_netherlands_eredivisie"],
            "Portugal" => ["soccer_portugal_primeira_liga"],
            "Spain" => [
                "soccer_spain_la_liga",
                "soccer_spain_segunda_division"
            ],
            "Scotland" => ["soccer_spl"],
            "Sweden" => ["soccer_sweden_allsvenskan"],
            "Switzerland" => ["soccer_switzerland_superleague"],
            "Turkey" => ["soccer_turkey_super_league"],
            "UEFA" => [
                "soccer_uefa_champs_league",
                "soccer_uefa_europa_conference_league",
                "soccer_uefa_europa_league"
            ]
        ];
        
        foreach ($sports as $country => $sportKeys) {
            if (in_array($sportKey, $sportKeys)) {
                return $country;
            } 
        }

        return null;
    }
}


/// empotrar 