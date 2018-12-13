<?php
/**
 * Created by PhpStorm.
 * User: miljanrakita
 * Date: 12/13/18
 * Time: 5:51 AM
 */

namespace WorkerJS\PHPClient;

interface TaskMessageHandler{
    public function handle(Task $task, $params);
}
