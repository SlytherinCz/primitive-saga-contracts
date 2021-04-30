<?php

namespace SlytherinCz\Saga\Step;

class StepBuilder
{
    private ?FormatterInterface $executionInputFormatter = null;
    private ?FormatterInterface $executionOutputFormatter = null;
    private ?FormatterInterface $compensationInputFormatter = null;
    private ?FormatterInterface $compensationOutputFormatter = null;
    private ?ContextValidatorInterface $contextValidator = null;

    public function __construct(
        private ExecutorInterface $executor,
        private CompensatorInterface $compensator,
    ) {}

    public function getSynchronous(): SynchronousStep
    {
        return new SynchronousStep(
            $this->executor,
            $this->compensator,
            $this->contextValidator,
            $this->executionInputFormatter,
            $this->executionOutputFormatter,
            $this->compensationInputFormatter,
            $this->compensationOutputFormatter
        );
    }

    public function withContextValidator(ContextValidatorInterface $validator): static
    {
        $this->contextValidator = $validator;
        return $this;
    }

    public function withExecutionInputFormatter(FormatterInterface $formatter): static
    {
        $this->executionInputFormatter = $formatter;
        return $this;
    }

    public function withExecutionOutputFormatter(FormatterInterface $formatter): static
    {
        $this->executionOutputFormatter = $formatter;
        return $this;
    }

    public function withCompensationInputFormatter(FormatterInterface $formatter): static
    {
        $this->compensationInputFormatter = $formatter;
        return $this;
    }

    public function withCompensationOutputFormatter(FormatterInterface $formatter): static
    {
        $this->compensationOutputFormatter = $formatter;
        return $this;
    }
}
