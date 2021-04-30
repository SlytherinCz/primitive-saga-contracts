<?php

namespace SlytherinCz\Saga\Pipeline;

use Closure;
use SlytherinCz\Saga\Step\StepInterface;

class Pipeline
{
    private array $steps = [];
    private array $executionResults = [];
    private array $compensationResults = [];

    public function __construct()
    {}

    public function addStep(
        string $label,
        StepInterface $step,
        ?array $neededContext = [],
        ?Closure $callback = null
    ): static {
        $this->steps[$label] = new StepWrapper(
            $label,
            $step,
            $neededContext,
            $callback
        );
        return $this;
    }

    public function addStepFactory(
        string $label,
        StepFactoryInterface $factory,
        ?array $neededContext = [],
        ?Closure $callback = null
    ): static {
        $this->steps[$label] = new StepWrapper(
            $label,
            $factory->create(),
            $neededContext,
            $callback
        );
        return $this;
    }

    public function execute(): PipelineResultInterface
    {
        $keys = array_keys($this->steps);
        try {
            $lastResult = null;
            for ($i = 0; $i < count($this->steps); $i++) {
               /** @var StepWrapper $stepWrapper */
               $stepWrapper = $this->steps[$keys[$i]];
               $context = $this->getAdditionalContext($stepWrapper->getNeededContext());
               $lastResult = $stepWrapper->getStep()->execute($lastResult, $context);
               $this->executionResults[$keys[$i]] = $lastResult;
            }
        } catch (\Throwable $e) {
            $i = $i - 1;
            for ($i; $i >= 0; $i--) {
                $step = $this->steps[$keys[$i]]->getStep();
                $this->compensationResults[$keys[$i]] = $step->compensate();
            }
        }
        return $this->getResult();
    }

    private function getResult(): PipelineResultInterface
    {
        return new PipelineResult(
            $this->executionResults,
            $this->compensationResults
        );
    }

    private function getAdditionalContext(array $contextLabels): array
    {
        $context = [];
        foreach ($contextLabels as $label) {
            if(empty($this->steps[$label])) {
                throw new \OutOfRangeException("No result of step ${label} available at this time");
            }
            $context[$label] = $this->steps[$label]->getStep()->getExecutionResult();
        }
        return $context;
    }
}
