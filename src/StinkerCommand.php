<?php

namespace PatentLobster\StinkerPhar;

use Psy\Util\Str;

class StinkerCommand
{

    private $args;

    public function __construct($argv)
    {
        $this->args = $argv;
    }

    private function prepareParams() {
        $request = [];
        $params = \Illuminate\Support\Arr::where($this->args, function ($param) {
            return \strpos($param, '=') !== \false && \strpos($param, '--') === 0;
        });

        foreach ($params as $param) {
            [$paramName, $value] = \explode('=', $param, 2);
            $paramName = \str_replace('--', '', $paramName);
            $request[$paramName] = $value;
        }

        return (object) $request;
    }

    private function prepareCommand($params) {
        $class = "\\PatentLobster\\StinkerPhar\\Commands\\" . \Illuminate\Support\Str::studly($this->args[2]) . "Command";
        $project_path = $this->args[1];
        return (new $class($params, $project_path));
    }

    public function execute() {
        $params = $this->prepareParams();
        $command = $this->prepareCommand($params);
        return $command->execute();
    }
}