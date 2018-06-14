<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Game;
use App\Faction;
use App\Objective;
use App\GameFaction;
use App\GameObjective;
use App\ScoredObjective;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    public function CreateNewGame()
    {
        if(!$this->CheckCanCreateGame()) {
            $response = response()->json('You have just created a game and must wait to create another.', 400); 
        } else {
            $gameCode = $this->GenerateGameCode();
            $game = new Game;
            $game->code = $gameCode;
            $game->created_by = $_SERVER['REMOTE_ADDR'];
            $game->save();
            $response = response()->json($game);
        }
        return $response;
    }


    public function GetGameDetails($gameCode)
    {
        $game = Game::with(['objectives.objective', 'factions.faction', 'scoredObjectives'])
            ->where('code', $gameCode)->first();
        return response()->json($game);
    }


    public function ListFactions()
    {
        $factions = Faction::all();
        return response()->json($factions);
    }


    public function AddFactionToGame($gameCode, $factionId)
    {
        $game = Game::where('code', $gameCode)->first();
        if(Faction::where('faction_id', $factionId)->count() === 0) {
            return response()->json('Invalid Faction', 400);
        }
        if($game->factions->where('faction_id', $factionId)->count()) {
            return response()->json('Faction is already in the game!', 400);
        }
        $gameFaction = new GameFaction();
        $gameFaction->faction_id = $factionId;
        $gameFaction->game_id = $game->game_id;
        $gameFaction->save();
        return response()->json($gameFaction);
    }

    public function RemoveFactionFromGame($gameCode, $factionId)
    {
        $game = Game::where('code', $gameCode)->first();
        $res = GameFaction::where([['game_id', $game->game_id], ['faction_id', $factionId]])->delete();
        return response()->json($res);
    }


    public function AddObjectiveToGame($gameCode, $objectiveId)
    {
        $game = Game::where('code', $gameCode)->first();
        if(Objective::where('objective_id', $objectiveId)->count() === 0) {
            return response()->json('Invalid Objective', 400);
        } 
        if($game->objectives->where('objective_id', $objectiveId)->count()) {
            return response()->json('Objective is already in the game!', 400);
        }
        $gameObjective = new GameObjective();
        $gameObjective->objective_id = $objectiveId;
        $gameObjective->game_id = $game->game_id;
        $gameObjective->save();
        return response()->json($gameObjective);
    }


    public function RemoveObjectiveFromGame($gameCode, $objectiveId)
    {
        $game = Game::where('code', $gameCode)->first();
        $res = GameObjective::where([['game_id', $game->game_id], ['objective_id', $objectiveId]])->delete();
        return response()->json($res);
    }


    public function ListObjectives()
    {
        $objectives = Objective::all();
        return response()->json($objectives);
    }


    public function ScoreObjective($gameCode, $objectiveId, $factionId)
    {
        $game = Game::where('code', $gameCode)->first();
        if(GameObjective::where([['game_id', $game->game_id], ['objective_id', $objectiveId]])->count() === 0) {
            return response()->json('That objective is not in this game', 400);
        }
        if(GameFaction::where([['game_id', $game->game_id], ['faction_id', $factionId]])->count() === 0) {
            return response()->json('The faction is not in this game', 400);
        }
        if(ScoredObjective::where([
            ['game_id', $game->game_id], 
            ['faction_id', $factionId], 
            ['objective_id', $objectiveId]
        ])->count()) {
            return response()->json('That faction has already scored that objective', 400);
        }
        $scored = new ScoredObjective();
        $scored->game_id = $game->game_id;
        $scored->faction_id = $factionId;
        $scored->objective_id = $objectiveId;
        $scored->save();
        return response()->json($scored);
    }


    public function UnscoreObjective($gameCode, $objectiveId, $factionId)
    {
        $game = Game::where('code', $gameCode)->first();
        $res = ScoredObjective::where([
            ['game_id', $game->game_id], 
            ['objective_id', $objectiveId], 
            ['faction_id', $factionId]
        ])->delete();
        return response()->json($res);
    }


    public function UpdateScore($gameCode, $factionId, $score)
    {
        $game = Game::where('code', $gameCode)->first();
        if(GameFaction::where([['game_id', $game->game_id], ['faction_id', $factionId]])->count() === 0) {
            return response()->json('Faction does not exist in this game', 400);
        }
        $faction = GameFaction::where([['game_id', $game->game_id], ['faction_id', $factionId]])->first();
        $faction->score = $score;
        $faction->save();
        return response()->json($faction);
    }



    private function GenerateGameCode()
    {
        do {
            $seeds = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz23456789';
            $code = '';
            for($i = 0; $i < 8; $i++) {
                $randNum = rand(0, strlen($seeds) - 1);
                $code .= $seeds[$randNum];
            }
        } while (!self::CheckUniqueGameCode($code));
        return $code;
    }


    private function CheckUniqueGameCode($code)
    {
        $res = DB::table('games')->where('code', $code)->count();
        return $res === 0;
    }


    private function CheckCanCreateGame()
    {
        $ip = '0.0.0.0';
        if(isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $date = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $games = DB::table('games')->where([
                ['created_by', $ip], 
                ['date_created', '>', $date]
            ])->count();
        return $games === 0;
    }
}
