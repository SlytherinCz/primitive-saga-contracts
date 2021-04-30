<?php

namespace SlytherinCz\Saga\Step;

interface CompensatorInterface
{
    public function compensate(): StepResultInterface;
}
