<?php

namespace SlytherinCz\Saga\Step;

interface StepInterface
{
    public function execute(?StepResultInterface $previousResult, ?array $additionalContext = []): StepResultInterface;
    public function compensate(): StepResultInterface;
}
