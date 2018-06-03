<?php
include_once 'bootstrap.php';

//use controllers\ApiController;
include_once 'controllers/ApiController.php';
Epi::setSetting('exceptions', true);
Epi::setPath('base', 'src');
Epi::init('api', 'database');

EpiDatabase::employ('mysql', 'ti4hud', 'mysql', 'root', 'welcome');


getRoute()->get('/', 'showEndpoints');

getRoute()->get('/CreateNewGame', 
    array('ApiController', 'CreateNewGame'), EpiApi::external);
getRoute()->get('/GetFactionList', 
    array('ApiController', 'GetFactionList'), EpiApi::external);
getRoute()->get('/GetObjectiveList',
    array('ApiController', 'GetObjectiveList'), EpiApi::external);
getRoute()->get('/AddFaction/(\w+)/(\d+)',
    array('ApiController', 'AddFactionToGame'), EpiApi::external);
getRoute()->get('/AddObjective/(\w+)/(\d+)', 
    array('ApiController', 'AddObjectiveToGame'), EpiApi::external);
getRoute()->get('/GetGameDetails/(\w+)', 
    array('ApiController', 'GetGameDetails'), EpiApi::external);
getRoute()->get('/RemoveFaction/(\w+)/(\d+)',
    array('ApiController', 'RemoveFactionFromGame'), EpiApi::external);
getRoute()->get('/RemoveObjective/(\w+)/(\d+)', 
    array('ApiController', 'RemoveObjectiveFromGame'), EpiApi::external);
getRoute()->get('/UpdateScore/(\w+)/(\d+)/(\d+)', 
    array('ApiController', 'UpdateScore'), EpiApi::external);
getRoute()->get('/ScoreObjective/(\w+)/(\d+)/(\d+)',
    array('ApiController', 'ScoreObjective'), EpiApi::external);
getRoute()->get('/UnscoreObjective/(\w+)/(\d+)/(\d+)',
    array('ApiController', 'UnscoreObjective'), EpiApi::external);

getRoute()->run();

function showEndpoints()
{
    $html = <<<HTML
<ul>
    <li><a href="/">/</a> -> (home)</li>
    <li><a href="/CreateNewGame">/CreateNewGame</a> -> Create new Game</li>
    <li><a href="/GetFactionList">/GetFactionList</a> -> Get list of factions</li>
    <li><a href="/GetObjectiveList">/GetOpjectiveList</a> -> Get list of objectives</li>
    <li><a href="/AddFaction/">/AddFaction/&lt;Game Code&gt;/&lt;Faction Id&gt;</a> -> Add faction to a game</li>
    <li><a href="/AddObjective/">/AddFaction/&lt;Game Code&gt;/&lt;Objective ID&gt;</a> -> Add faction to a game</li>
    <li><a href="/GetGameDetails/">/GetGameDetails/&lt;Game Code&gt;</a> -> Get status of the game</li>
    <li><a href="/RemoveFaction/">/RemoveFaction/&lt;Game Code&gt;/&lt;Faction Id&gt;</a> -> Remove a faction from the game</li>
    <li><a href="/RemoveObjective/">/RemoveObjective/&lt;Game Code&gt;/&lt;Objective Id&gt;</a> -> Remove objective from the game</li>
    <li><a href="/UpdateScore/">/UpdateScore/&lt;Game Code&gt;/&lt;Faction ID&gt;/&lt;New Score&gt;</a> -> Updates the score for a faction</li>
    <li><a href="/ScoreObjective/">/ScoreObjective/&lt;Game Code&gt;/&lt;Faction ID&gt;/&lt;Objective ID&gt;</a> -> Score an objective for the faction</li>
    <li><a href="/UnscoreObjective/">/UnscoreObjective/&lt;Game Code&gt;/&lt;Faction ID&gt;/&lt;Objective ID&gt;</a> -> Remove a faction from a scored objective</li>

</ul>
HTML;
    echo $html;
}
