<?php
include_once 'src/Epi.php';
Epi::setPath('base', 'src');
Epi::init('api');
Epi::init('database');

EpiDatabase::employ('mysql', 'ti4hud', 'mysql', 'root', 'welcome');

$test = getDatabase()->all('SELECT * FROM games');
var_dump($test);

getRoute()->get('/', 'showEndpoints');
getRoute()->get('/createGame', 'createNewGame');

getRoute()->run();
function showEndpoints()
{
    $html = <<<HTML
<ul>
    <li><a href="/">/</a> -> (home)</li>
</ul>
HTML;
    echo $html;
}


function createNewGame()
{
    $sql = <<<SQL
INSERT INTO
    Games
    ()
SQL;
}


function generateGameCode()
{
}
