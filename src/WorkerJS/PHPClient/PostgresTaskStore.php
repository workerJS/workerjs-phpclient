<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 4:38 AM
 */

 namespace WorkerJS\PHPClient;

 use WorkerJS\PHPClient\exceptions\TaskNotFoundException;

 class PostgresTaskStore extends TaskStore {
	private $connection;

	public function __construct($client) {
		parent::__construct($client);

		$connection = parse_url($this->client->getSetting("store")["uri"]);
		$params = "host=".$connection["host"]." dbname=".trim($connection["path"], "/")." user=".@$connection["user"]." password=".@$connection["pass"];

		$this->connection = pg_connect($this->client->getSetting("store")["uri"]);
	}

	public function getTask($taskID) {
		$result = pg_query($this->connection, "SELECT task FROM tasks WHERE \"taskID\" = '".pg_escape_string($this->connection, $taskID)."'");

		if(pg_num_rows($result) === 0){
			throw new TaskNotFoundException("Task $taskID not found.");
		} else {
			$task = pg_fetch_assoc($result)["task"];

			return json_decode($task, true);
		}
	}

	public function setTask($taskID, Task $task) {
		pg_query($this->connection, "INSERT INTO tasks (\"taskID\", task) VALUES ('".pg_escape_string($this->connection, $taskID)."', '".pg_escape_string($this->connection, json_encode($task->getTask()))."')");
	}

	public function lock() {
        pg_query($this->connection,"BEGIN WORK; LOCK TABLE tasks IN ACCESS EXCLUSIVE MODE;");
    }

    public function unlock() {
        pg_query($this->connection,"COMMIT WORK;");
    }
 }

