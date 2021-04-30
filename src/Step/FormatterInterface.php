<?php

namespace SlytherinCz\Saga\Step;

interface FormatterInterface
{
    public function format(StepResultInterface $input): StepResultInterface;
}
