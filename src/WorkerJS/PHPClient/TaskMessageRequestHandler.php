<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 4:58 AM
 */

namespace WorkerJS\PHPClient;

use WorkerJS\PHPClient\exceptions\InvalidRequestException;

class TaskMessageRequestHandler {
	private $client;

	public function __construct(Client $client) {
		$this->client = $client;
	}

	/**
	 * @param string $body
	 * @throws exceptions\InvalidApiException
	 * @throws exceptions\UndefinedSettingsException
	 */
	public function handleRequest(string $body) {
		$body = json_decode($body, true);
		//TODO: Check protocol

		if ($body === null && json_last_error() !== JSON_ERROR_NONE) {
			throw new InvalidRequestException("Invalid request");
		}

		$taskID = $body->taskID;

		$task = $this->client->getTaskByID($taskID);

		$handlerName = $body->message->type;

		try {
			$this->client->getTaskMessageRouter()->call($handlerName, $task, $body);
		} catch(Exception $e) {
			//TODO: Log unimplemented handler
		}
	}
}
