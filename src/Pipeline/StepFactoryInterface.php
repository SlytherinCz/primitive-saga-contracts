<?php

namespace SlytherinCz\Saga\Pipeline;

use SlytherinCz\Saga\Step\StepInterface;

interface StepFactoryInterface
{
    public function create(): StepInterface;
}
