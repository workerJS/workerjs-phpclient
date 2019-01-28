<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 4:38 AM
 */

namespace WorkerJS\PHPClient;

use WorkerJS\PHPClient\exceptions\TaskNotSetException;

abstract class Task {
	private $client;
	protected $task;

	public function __construct($client, $params) {
		if( is_string($params) ) {
			$name = $params;
			$this->task = [
				"name" => null,
				"task" => null,
                "task-webhook" => null,
			];

			$this->task["name"] = $name;
		} else {
			$this->task = $params;
		}
	}

	public function getTask() {
		return $this->task;
	}

	/**
	 * @return mixed
	 * @throws TaskNotSetException
	 */

	public function getTaskID() {
		if(isset($this->task["taskID"])){
			return $this->task["taskID"];
		} else {
			throw new TaskNotSetException("TaskID is not defined yet, you need to send task first. ");
		}
	}

	public function setParams($body) {
		$this->task["task"] = $body;
		$this->preProcessParams();
	}

	abstract public function sendTask();

	abstract public function sendMessage($payload);

	private function preProcessParams() {
		//Optional override
	}

	public function getHandlerName() {
		return $this->task["name"];
	}
}
