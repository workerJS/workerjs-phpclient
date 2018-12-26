<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 5:51 AM
 */

namespace WorkerJS\PHPClient;

use WorkerJS\PHPClient\exceptions\UndefinedSettingsException;

interface TaskMessageHandler{
	/**
	 * @param Task $task
	 * @param $params
	 * @return mixed
	 * @throws UndefinedSettingsException
	 */

	public function handle(Task $task, $params);
}

