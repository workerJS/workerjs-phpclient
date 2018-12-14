<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 4:38 AM
 */

namespace WorkerJS\PHPClient;

class Client{
    private $options;

    private $taskMessageRouter;
    private $taskStore;

    private $defaultOptions = [
        "api" => "httpclient",
        "store" => [
            "type" => "mysql",
            "uri" => "mysql://root:toor@localhost/dbname"
        ]
    ];

    public function __construct($options){
        $this->options = $options;

        $this->taskMessageRouter = TaskMessageRouter::getTaskMessageRouter();

        if($this->options["store"]["type"] == "mysql"){
            $this->taskStore = new MySQLTaskStore($this);
        } else {
            throw new \Exception("Invalid Store choice. ");
        }
    }

    public function getSetting($name){
        if(isset($this->options[$name])){
            return $this->options[$name];
        } else if(isset($this->defaultOptions[$name])) {
            return $this->defaultOptions[$name];
        } else {
            throw new \Exception("Option $name is not defined. ");
        }
    }

    public function getTaskMessageRouter(){
        return $this->taskMessageRouter;
    }

    public function getTaskStore(){
        return $this->taskStore;
    }

    public function newTask($name){
        if($this->getSetting("api") == "httpclient"){
            return new HTTPClientTask($this, $name);
        } else {
            throw new \Exception("Invalid API choice. ");
        }
    }
}

