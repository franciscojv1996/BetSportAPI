<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SportsController extends Controller
{
    public function index()
    {
        $associations = $this->getSports();

        $filteredAssociations = array_filter($associations, function ($sport) {
            return in_array($sport['group'], ['Basketball', 'Soccer']);
        });
        $filteredAssociations = array_values($filteredAssociations);

        return response()->json($filteredAssociations);
    }

    public function countryAssociations()
    {
        $country = [
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

        return response()->json([
            'country ' => $country
        ]);
    }

    public function associations()
    {
        $associations = $this->getSports();

        $basketballKeys = [];
        $soccerKeys = [];

        foreach ($associations as $sport) {
            if ($sport['group'] === 'Basketball') {
                $basketballKeys[] = $sport['key'];
            } else if ($sport['group'] === 'Soccer') {
                $soccerKeys[] = $sport['key'];
            }
        }

        return response()->json([
            'associationsBasketballKeys' => $basketballKeys,
            'associationsSoccerKeys' => $soccerKeys,
        ]);
    }

    public function associationsOdds(Request $request)
    {
        $validated = $request->validate([
            'sports' => 'required|string',
            'regions' => 'required|in:us,us2,uk,au,eu',
            'markets' => 'required|string',
        ]);

        $sports = $validated['sports'];
        $regions = $validated['regions'];
        $markets = $validated['markets'];

        $associations = $this->getOdds($sports, $regions, $markets);
        $country = $this->findSportTitle($sports);

        foreach ($associations as &$association) {
            $id = $association['id'];
            unset($association['id']);
            $association = array_merge(['id' => $id, 'country' => $country], $association);
        }

        return response()->json([
            'associations' => $associations,
            'sports'  => $sports,
            'regions' => $regions,
            'markets' => $markets
        ]);
    }

    public function associationsScores(Request $request)
    {
        $validated = $request->validate([
            'sports' => 'required|string',
            'daysFrom' => 'required|integer',
        ]);

        $sports = $validated['sports'];
        $daysFrom = $validated['daysFrom'];

        $associations = $this->getScores($sports, $daysFrom);
        $country = $this->findSportTitle($sports);

        foreach ($associations as &$association) {
            $id = $association['id'];
            unset($association['id']);
            $association = array_merge(['id' => $id, 'country' => $country], $association);
        }

        return response()->json([
            'associations' => $associations,
            'sports'  => $sports,
            'daysFrom' => $daysFrom,
        ]);
    }

    public function associationsEvents(Request $request)
    {
        $validated = $request->validate([
            'sports' => 'required|string',
        ]);

        $sports = $validated['sports'];

        $associations = $this->getEvents($sports);
        $country = $this->findSportTitle($sports);

        foreach ($associations as &$association) {
            $id = $association['id'];
            unset($association['id']);
            $association = array_merge(['id' => $id, 'country' => $country], $association);
        }

        return response()->json([
            'associations' => $associations,
            'sports'  => $sports,
        ]);
    }

    public function associationsOddsEvents(Request $request)
    {
        $validated = $request->validate([
            'sports' => 'required|string',
            'idEvents' => 'required|string',
            'regions' => 'required|in:us,us2,uk,au,eu',
            'markets' => 'required|string',
            'oddsFormat' => 'required|in:american,decimal,fractional',
        ]);

        $sports = $validated['sports'];
        $idEvents = $validated['idEvents'];
        $regions = $validated['regions'];
        $markets = $validated['markets'];
        $oddsFormat = $validated['oddsFormat'];

        $associations = $this->getEventsOdds($sports, $idEvents, $regions, $markets, $oddsFormat);
        $country = $this->findSportTitle($sports);

        foreach ($associations as &$association) {
            $id = $association['id'];
            unset($association['id']);
            $association = array_merge(['id' => $id, 'country' => $country], $association);
        }

        return response()->json([
            'associations' => $associations,
            'sports' => $sports,
            'idEvents' => $idEvents,
            'regions' => $regions,
            'markets' => $markets,
            'oddsFormat' => $oddsFormat
        ]);
    }
}
