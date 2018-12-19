<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/14/18
 * Time: 10:12 PM
 */

require_once("./src/WorkerJS/PHPClient/Client.php");
require_once("./src/WorkerJS/PHPClient/HTTPClientTask.php");
require_once("./src/WorkerJS/PHPClient/MySQLTaskStore.php");
require_once("./src/WorkerJS/PHPClient/Task.php");
require_once("./src/WorkerJS/PHPClient/TaskMessageHandler.php");
require_once("./src/WorkerJS/PHPClient/TaskMessageRequestHandler.php");
require_once("./src/WorkerJS/PHPClient/TaskMessageRouter.php");
require_once("./src/WorkerJS/PHPClient/TaskStore.php");

use \WorkerJS\PHPClient;

$client = new PHPClient\Client([]);

// Message receiver

$router->get("/webhook", function($request, $response){
	$taskMessageRequestHandler = new PHPClient\TaskMessageRequestHandler($client);

    $taskMessageRequestHandler->handleRequest($request->body);
});

// Message handler

class DeliveryReport implements PHPClient\TaskMessageHandler {
    public function handle(\WorkerJS\PHPClient\Task $task, $params)
    {
        $task->sendMessage(["message" => "ok"]);

        // TODO: Implement handle() method.
    }
}

$handler = new DeliveryReport();

$client->getTaskMessageRouter()->subscribe("delivery-report", $handler);

// Creating task

$task = $client->newTask("sendSMS");

$task->setParams([
    "from" => "+3874387483",
    "to" => "+423423423478",
    "body" => "Fdfsfd fwdsfwergf dfgdfg rgergerg. "
]);

$task->sendTask();

