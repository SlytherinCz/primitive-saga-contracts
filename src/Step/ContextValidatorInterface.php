<?php

namespace SlytherinCz\Saga\Step;

interface ContextValidatorInterface
{
    public function validate(StepResultInterface $result):void;
}
