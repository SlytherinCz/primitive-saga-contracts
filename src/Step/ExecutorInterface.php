<?php

namespace SlytherinCz\Saga\Step;

interface ExecutorInterface
{
    public function execute(?StepResultInterface $previousResult, ?array $additionalContext = []): StepResultInterface;
}
