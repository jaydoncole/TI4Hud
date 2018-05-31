<?php
require_once 'controllers/api.php';

class ApiTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateNewGame() 
    {
        ApiController::CreateNewGame();

    }
}
