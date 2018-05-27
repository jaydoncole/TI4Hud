<?php
include_once 'src/Epi.php';
include_once 'controllers/api.php';

Epi::setPath('base', 'src');
Epi::init('api', 'database');

EpiDatabase::employ('mysql', 'ti4hud', 'mysql', 'root', 'welcome');

$test = getDatabase()->all('SELECT * FROM games');
var_dump($test);

getRoute()->get('/', 'showEndpoints');
getRoute()->get('/CreateNewGame', array('ApiController', 'CreateNewGame'), EpiApi::external);

getRoute()->run();

function showEndpoints()
{
    $html = <<<HTML
<ul>
    <li><a href="/">/</a> -> (home)</li>
    <li><a href="/CreateNewGame">/CreateNewGame</a> -> Create new Game</li>
</ul>
HTML;
    echo $html;
}
