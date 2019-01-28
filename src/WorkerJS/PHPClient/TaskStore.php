<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 5:27 AM
 */

namespace WorkerJS\PHPClient;

use WorkerJS\PHPClient\exceptions\TaskNotFoundException;

abstract class TaskStore {
	protected $client;

	public function __construct($client) {
		$this->client = $client;
	}

    /**
     * @param $taskID
     * @param Task $task
     * @return mixed
     */
	abstract public function setTask($taskID, Task $task);

	/**
	 * @param $taskID
	 * @return mixed
	 * @throws TaskNotFoundException
	 */
	abstract public function getTask($taskID);

    /**
     * @return mixed
     */
    abstract public function lock();

    /**
     * @return mixed
     */
    abstract public function unlock();
}

