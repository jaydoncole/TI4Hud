<?php
//namespace controllers;

use repository\ApiRepository;

class ApiController
{
    static public function CreateNewGame()
    {
        $repo = new ApiRepository();
        if(!$repo->CheckCanCreateGame()) {
            $output = json_encode(array(
                'error' => 'You have just recently created a game and must wait to create another.'));
        } else {
            $gameId = $repo->CreateNewGame();
            $gameData = $repo->GetDataByGameId($gameId);
            $output = json_encode($gameData);
        }
        echo $output;
    }

    static public function GetFactionList()
    {
        $repo = new ApiRepository();
        $factions = $repo->ListFactions();
        echo json_encode($factions);
    }

    static public function GetObjectiveList()
    {
        $repo = new ApiRepository();
        $objectives = $repo->GetObjectiveList();
        echo json_encode($objectives);

    }

    static public function AddObjectiveToGame($gameCode, $objectiveId)
    {
        $repo = new ApiRepository();
        $output = json_encode(array('error' => 'Objective is already in the game'));
        if(!$repo->CheckValidObjective($objectiveId)) {
            $output = json_encode(array('error' => 'Invalid Objective'));
        } else if ($repo->CheckObjectiveExistsInGame($objectiveId, $gameCode) === "0") {
            $objectiveGameId = $repo->AddObjectiveToGame($objectiveId, $gameCode);
            $output = json_encode($objectiveGameId);
        }
        echo $output;
    }


    static public function AddFactionToGame($gameCode, $factionId)
    {
        $repo = new ApiRepository();

        $output = json_encode(array('error' => 'Faction is already in the game!'));
        if (!$repo->CheckValidFaction($factionId)) {
            $output = json_encode(array('error' => 'Invalid faction!'));
        } else if($repo->CheckFactionExistsInGame($factionId, $gameCode) === "0") {
            $factionGameId = $repo->AddFactionToGame($factionId, $gameCode);
            $output = json_encode($factionGameId);
        }
        echo $output;
    }

    static public function GetGameDetails($gameCode)
    {
        $repo = new ApiRepository();
        $factions = $repo->GetFactionsInGame($gameCode);
        $objectives = $repo->GetObjectivesInGame($gameCode);
        foreach($objectives as $objective) {
            $scoredObjectives[$objective['objective_id']] = $repo->GetScoredObjectives($gameCode, $objective['objective_id']);
        }
        echo json_encode(array(
            'Factions' => $factions, 
            'Objectives' => $objectives, 
            'ScoredObjectives' => $scoredObjectives));
    }

    static public function RemoveFactionFromGame($gameCode, $factionId)
    {
        $repo = new ApiRepository();
        $res = $repo->RemoveFactionFromGame($gameCode, $factionId);
    }

    static public function RemoveObjectiveFromGame($gameCode, $objectiveId)
    {
        $repo = new ApiRepository();
        $res = $repo->RemoveObjectiveFromGame($gameCode, $objectiveId);
    }

    static public function UpdateScore($gameCode, $factionId, $score)
    {
        $repo = new ApiRepository();
        $res = $repo->UpdateScore($gameCode, $factionId, $score);
    }


    static public function ScoreObjective($gameCode, $factionId, $objectiveId) 
    {
        $repo = new ApiRepository();
        $res = $repo->ScoreObjective($gameCode, $factionId, $objectiveId);
    }

    static public function UnscoreObjective($gameCode, $factionId, $objectiveId)
    {
        $repo = new ApiRepository();
        $res = $repo->UnscoreObjective($gameCode, $factionId, $objectiveId);
    }
}
