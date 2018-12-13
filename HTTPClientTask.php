<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 5:53 AM
 */

namespace App;


class HTTPClientTask extends Task{
    public function sendTask(){
        $url = TaskConfig::getOption("api_base")."/task";
        $payload = $this->getTask();

        return $this->sendRequest($url, $payload);
    }

    public function sendMessage($payload){
        $url = TaskConfig::getOption("api_base")."/message";

        return $this->sendRequest($url, $payload);
    }

    public function preProcess(){
        $this->task->webhook = TaskConfig::getOption("webhook");
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
            throw new Exception($error);
        }else if($code !== 200) {
            throw new Exception($result);
        } else {
            return $result;
        }
    }
}

