<?php

namespace CliCommands;
interface CliCommandInterface
{
    public function execute(array $arguments): void;
}