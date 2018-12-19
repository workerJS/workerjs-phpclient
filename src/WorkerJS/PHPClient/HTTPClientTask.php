<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 5:53 AM
 */

namespace WorkerJS\PHPClient;


class HTTPClientTask extends Task{

    private $client;
    private $name;

    public function __construct($client, $name)
    {
        $this->client = $client;
        $this->name = $name;
    }


    public function sendTask(){
        $url = $this->client->getSetting("api_base")."/task";
        $payload = $this->getTask();

        $taskResponse = $this->sendRequest($url, $payload);

        $this->client->getTaskStore()->setTask($taskResponse["taskID"], $this->getTask());
        return $taskResponse;
    }

    public function sendMessage($payload){
        $url = $this->client->getSetting("api_base")."/message";

        $payload->taskID = $this->task->taskID;

        return $this->sendRequest($url, $payload);
    }

    public function preProcess(){
        $this->task->webhook = $this->client->getSetting("webhook");
    }

    private function sendRequest($url, $payload){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($error = curl_error($ch)){
            throw new \Exception($error);
        }else if($code !== 200) {
            throw new \Exception($result);
        } else {
            return json_decode($result, true);
        }
    }
}

