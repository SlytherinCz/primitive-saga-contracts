<?php

namespace SlytherinCz\Saga\Step;

class SynchronousStep implements StepInterface
{
    private ?StepResultInterface $executionResult = null;

    private ?StepResultInterface $compensationResult = null;

    public function __construct(
        private ExecutorInterface $executor,
        private CompensatorInterface $compensator,
        private ?ContextValidatorInterface $executionContextValidator = null,
        private ?FormatterInterface $executionInputFormatter = null,
        private ?FormatterInterface $executionOutputFormatter = null,
        private ?FormatterInterface $compensationInputFormatter = null,
        private ?FormatterInterface $compensationOutputFormatter = null
    ) {}

    public function execute(?StepResultInterface $previousResult, ?array $additionalContext = []): StepResultInterface
    {
        if (!is_null($previousResult) && !is_null($this->executionInputFormatter)) {
            $previousResult = $this->executionInputFormatter->format($previousResult);
        }
        if (!is_null($previousResult) && !is_null($this->executionContextValidator)) {
            $this->executionContextValidator->validate($previousResult);
        }
        $this->executionResult = $this->executor->execute($previousResult, $additionalContext);
        $result = $this->executionResult;
        if (!is_null($this->executionOutputFormatter)) {
            return $this->executionOutputFormatter->format($result);
        }
        return $result;
    }

    public function compensate(): StepResultInterface
    {
        $executionResult = $this->executionResult;
        if (!is_null($this->compensationInputFormatter)) {
            $executionResult = $this->compensationInputFormatter->format($executionResult);
        }
        $this->compensationResult = $this->compensator->compensate($executionResult);
        $result = $this->compensationResult;
        if (!is_null($this->compensationOutputFormatter)) {
            return $this->compensationOutputFormatter->format($result);
        }
        return $result;
    }

    /**
     * @return StepResultInterface|null
     */
    public function getExecutionResult(): ?StepResultInterface
    {
        return $this->executionResult;
    }

    /**
     * @return StepResultInterface|null
     */
    public function getCompensationResult(): ?StepResultInterface
    {
        return $this->compensationResult;
    }
}
