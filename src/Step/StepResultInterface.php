<?php

namespace SlytherinCz\Saga\Step;

use Spatie\DataTransferObject\DataTransferObject;

interface StepResultInterface
{
    public function getIdentifier(): string;
    public function getData(): DataTransferObject;
}
