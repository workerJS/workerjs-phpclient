<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 4:37 AM
 */

namespace WorkerJS\PHPClient;

class TaskMessageRouter {
	private static $taskMessageRouter;

	public static function getTaskMessageRouter() {
		if(!self::$taskMessageRouter) {
			self::$taskMessageRouter = new TaskMessageRouter();

			return self::$taskMessageRouter;
		} else {
			return self::$taskMessageRouter;
		}
	}

	public static function subscribe($name, TaskMessageHandler $handler) {
		$taskMessageRouter = self::getTaskMessageRouter();
		$taskMessageRouter->handlers[$name] = $handler;
	}

	public static function call($name, $task, $params) {
		$taskMessageRouter = self::getTaskMessageRouter();

		$handler = $taskMessageRouter->getHandlerByName($name);
		$handler->handle($task, $params);
	}

	private static function getHandlerByName($name)	{
		$taskMessageRouter = self::getTaskMessageRouter();

		if(isset($taskMessageRouter->handlers[$name])) {
			return $taskMessageRouter->handlers[$name];
		} else {
			throw new \Exception("Handler for $name is not registered. ");
		}
	}

	private $handlers = [];

	private function __construct() {}
}

