<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 4:38 AM
 */

namespace WorkerJS\PHPClient;

use WorkerJS\PHPClient\exceptions\UndefinedSettingsException;
use WorkerJS\PHPClient\exceptions\StoreNotImplementedException;
use WorkerJS\PHPClient\exceptions\InvalidApiException;

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

	/**
	 * Client constructor.
	 * @param $options
	 * @throws StoreNotImplementedException
	 */
	public function __construct($options) {
		$this->options = $options;

		$this->taskMessageRouter = TaskMessageRouter::getTaskMessageRouter();

		if($this->options["store"]["type"] == "mysql"){
			$this->taskStore = new MySQLTaskStore($this);
		} else if($this->options["store"]["type"] == "postgres"){
			$this->taskStore = new PostgresTaskStore($this);
		} else {
			throw new StoreNotImplementedException("Invalid Store choice.");
		}
	}

	/**
	 * @param $name
	 * @return mixed
	 * @throws UndefinedSettingsException
	 */

	public function getSetting($name) {
		if(isset($this->options[$name])){
			return $this->options[$name];
		} else if(isset($this->defaultOptions[$name])) {
			return $this->defaultOptions[$name];
		} else {
			throw new UndefinedSettingsException("Option $name is not defined. ");
		}
	}

	/**
	 * @param $taskID
	 * @return mixed|HTTPClientTask
	 * @throws InvalidApiException
	 * @throws UndefinedSettingsException
	 */

	public function getTaskByID($taskID) {
		$taskStore = $this->getTaskStore();

		$task = $taskStore->getTask($taskID);
		$task["taskID"] = $taskID;

		$task = $this->newTask($task);

		return $task;
	}

	/**
	 * @return TaskMessageRouter
	 */

	public function getTaskMessageRouter() {
		return $this->taskMessageRouter;
	}

	/**
	 * @return PostgresTaskStore
	 */

	public function getTaskStore() {
		return $this->taskStore;
	}

	/**
	 * @param $name
	 * @return HTTPClientTask
	 * @throws InvalidApiException
	 * @throws UndefinedSettingsException
	 */

	public function newTask($name) {
		if($this->getSetting("api") == "httpclient"){
			return new HTTPClientTask($this, $name);
		} else {
			throw new InvalidApiException("Invalid API choice. ");
		}
	}
}

