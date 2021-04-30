<?php

namespace SlytherinCz\Saga\Pipeline;

use Closure;
use SlytherinCz\Saga\Step\StepInterface;

class StepWrapper
{
    public function __construct(
        private $label,
        private StepInterface $step,
        private ?array $neededContext = [],
        private ?Closure $callback = null
    ){}

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return StepInterface
     */
    public function getStep(): StepInterface
    {
        return $this->step;
    }

    /**
     * @return Closure|null
     */
    public function getCallback(): ?Closure
    {
        return $this->callback;
    }

    /**
     * @return array|null
     */
    public function getNeededContext(): ?array
    {
        return $this->neededContext;
    }


}
