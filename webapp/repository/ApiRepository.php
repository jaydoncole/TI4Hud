<?php
namespace repository;

class ApiRepository 
{

    public function CreateNewGame()
    {
        $code = $this->GenerateGameCode();
        $sql = <<<SQL
INSERT INTO 
    games
    (code, date_created, last_played, created_by)
VALUES 
    (?, NOW(), NOW(), ?)
SQL;
        getDatabase()->execute($sql, array($code, $_SERVER['REMOTE_ADDR']));
        $id = getDatabase()->insertId();
        return $id;
    }


    public function CheckCanCreateGame()
    {
        $sql = <<<SQL
SELECT 
    COUNT(*) as count
FROM
    games
WHERE 
    created_by = ?
    AND date_created > ?
SQL;
        $ip = $_SERVER['REMOTE_ADDR'];
        $date = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $games = getDatabase()->One($sql, array($ip, $date));
        return $games['count'] == '0';
    }


    public function GetDataByGameId($gameId)
    {
        $sql = <<<SQL
SELECT 
    *
FROM
    games
WHERE
    game_id = ?
SQL;
        $gameData = getDatabase()->One($sql, array($gameId));
        return $gameData;
    }


    public function AddFactionToGame($factionId, $gameCode)
    {
        $sql = <<<SQL
INSERT INTO game_factions
    (game_id, faction_id, score)
VALUES 
    ((SELECT game_id FROM games WHERE code = ?), ?, 0);
SQL;
        getDatabase()->execute($sql, array($gameCode, $factionId));
        $id = getDatabase()->insertId();
        return $id;

    }


    public function AddObjectiveToGame($objectiveId, $gameCode)
    {
        $sql = <<<SQL
INSERT INTO game_objectives
    (game_id, objective_id)
VALUES 
    ((SELECT game_id FROM games WHERE code = ?), ?);
SQL;
        getDatabase()->execute($sql, array($gameCode, $objectiveId));
        $id = getDatabase()->insertId();
        return $id;
    }

    public function CheckValidFaction($factionId) 
    {
        $sql = "SELECT COUNT(*) AS res FROM factions WHERE faction_id = ?";
        $res = getDatabase()->One($sql, array($factionId));
        return $res['res'] === '1';
    }


    public function CheckValidObjective($objectiveId) 
    {
        $sql = 'SELECT COUNT(*) AS res FROM objectives WHERE objective_id = ?';
        $res = getDatabase()->One($sql, array($objectiveId));
        return $res['res'] === '1';
    }


    public function CheckFactionExistsInGame($factionId, $gameCode)
    {
        $sql = <<<SQL
SELECT 
    COUNT(*) AS res
FROM 
    game_factions
WHERE
    game_id = (SELECT game_id FROM games WHERE code = ?)
    AND faction_id = ?
SQL;
        $res = getDatabase()->One($sql, array($gameCode, $factionId));
        return $res['res'];

    }


    public function CheckObjectiveExistsInGame($objectiveId, $gameCode)
    {
        $sql = <<<SQL
SELECT 
    COUNT(*) AS res
FROM 
    game_objectives
WHERE 
    game_id = (SELECT game_id FROM games WHERE code = ?)
    AND objective_id = ?
SQL;
        $res = getDatabase()->One($sql, array($gameCode, $objectiveId));
        return $res['res'];
    }

    public function GetFactionsInGame($gameCode)
    {
        $sql = <<<SQL
SELECT 
    f.faction_id, f.name, f.icon, gf.score
FROM
    factions AS f,
    game_factions AS gf,
    games AS g
WHERE
    gf.faction_id = f.faction_id
    AND g.game_id = gf.game_id
    AND g.code = ?
SQL;
        $factions = getDatabase()->All($sql, array($gameCode));
        return $factions;
    }


    public function GetObjectivesInGame($gameCode) 
    {
        $sql = <<<SQL
SELECT 
    o.objective_id, o.stage, o.title, o.text
FROM
    objectives AS o,
    game_objectives AS go,
    games AS g
WHERE
    go.objective_id = o.objective_id
    AND g.game_id = go.game_id
    AND g.code = ?
SQL;
        $objectives = getDatabase()->All($sql, array($gameCode));
        return $objectives;
    }

    public function GetScoredObjectives($gameCode, $objectiveId)
    {
        $sql = <<<SQL
SELECT
    faction_id
FROM
    scored_objectives
WHERE
    game_id = (SELECT game_id FROM games WHERE code = ?)
    AND objective_id = ?
SQL;
        $res = getDatabase()->All($sql, array($gameCode, $objectiveId));
        return $res;
    }


    public function ListFactions()
    {
        $sql = <<<SQL
SELECT 
    faction_id, name, icon
FROM 
    factions
SQL;
        $factions = getDatabase()->all($sql, array());
        return $factions;
    }


    public function GetObjectiveList()
    {
        $sql = 'SELECT * FROM objectives ORDER BY stage, title ASC';
        $objectives = getDatabase()->all($sql, array());
        return $objectives;
    }


    public function RemoveFactionFromGame($gameCode, $factionId)
    {
        $sql = <<<SQL
DELETE FROM game_factions
WHERE game_id = (SELECT game_id FROM games WHERE code = ?)
AND faction_id = ?
SQL;
        getDatabase()->execute($sql, array($gameCode, $factionId));
    }


    public function RemoveObjectiveFromGame($gameCode, $objectiveId)
    {
        $sql = <<<SQL
DELETE FROM game_objectives
WHERE game_id = (SELECT game_id FROM games WHERE code = ?)
AND objective_id = ?
SQL;
        getDatabase()->execute($sql, array($gameCode, $objectiveId));
    }


    public function UpdateScore($gameCode, $factionId, $score)
    {
        $sql = <<<SQL
UPDATE game_factions
SET score = ?
WHERE game_id = (SELECT game_id FROM games WHERE code = ?)
AND faction_id = ?
SQL;
        getDatabase()->execute($sql, array($score, $gameCode, $factionId));
    }


    public function ScoreObjective($gameCode, $factionId, $objectiveId)
    {
        $sql = <<<SQL
INSERT INTO scored_objectives (game_id, faction_id, objective_id)
VALUES ((SELECT game_id FROM games WHERE code = ?), ?, ?)
SQL;
        getDatabase()->execute($sql, array($gameCode, $factionId, $objectiveId));
    }


    public function UnscoreObjective($gameCode, $factionId, $objectiveId)
    {
        $sql = <<<SQL
DELETE FROM scored_objectives
WHERE game_id = (SELECT game_id FROM games WHERE code = ?)
AND faction_id = ?
AND objective_id = ?
SQL;
        getDatabase()->execute($sql, array($gameCode, $factionId, $objectiveId));
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
        $result = getDatabase()->one('SELECT code FROM games WHERE code = ?', array($code));
        return empty($result);
    }
}
