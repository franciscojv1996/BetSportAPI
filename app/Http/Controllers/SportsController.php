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
