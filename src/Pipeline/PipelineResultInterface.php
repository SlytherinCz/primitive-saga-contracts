<?php

namespace SlytherinCz\Saga\Pipeline;

interface PipelineResultInterface
{
    public function getExecutionResults(): array;
    public function getCompensationResults(): array;
    public function isCompensated(): bool;
}
