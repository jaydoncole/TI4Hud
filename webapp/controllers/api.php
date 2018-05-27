<?php
class ApiController
{
    static public function CreateNewGame()
    {
        $code = self::GenerateGameCode();
        $sql = getDatabase()->execute('INSERT INTO games (code, date_created, last_played) VALUES (?, NOW(), NOW())', array($code));
        var_dump("Got here"); 
        die;
    }

    static private function GenerateGameCode()
    {
        do {
            $seeded = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz23456789';
            $code = '';
            for($i = 0; $i < 8; $i++) {
                $randNum = rand(0, strlen($seeded) - 1);
                $code .= $seeded[$randNum];
            }
        } while (!self::CheckUniqueGameCode($code));
        return $code;
    }

    static private function CheckUniqueGameCode($code)
    {
        $result = getDatabase()->one('SELECT code FROM games WHERE code = ?', array($code));
        return empty($result);
    }
}
