<?php

namespace SlytherinCz\Saga\Pipeline;

class PipelineResult implements PipelineResultInterface
{
    public function __construct(
        private array $executionResults,
        private array $compensationResults
    ){}


    public function getExecutionResults(): array
    {
        return $this->executionResults;
    }

    public function getCompensationResults(): array
    {
        return $this->compensationResults;
    }

    public function isCompensated(): bool
    {
        return count($this->compensationResults) > 0;
    }
}
