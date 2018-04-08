<?php

namespace Linfo\Info\Cpu;

class Processor
{
    /** @var string */
    private $model;
    /** @var float */
    private $speed;
    /** @var int */
    private $l2Cache;
    /** @var string[]|null */
    private $flags;
    /** @var string */
    private $architecture;

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return $this
     */
    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return float
     */
    public function getSpeed(): float
    {
        return $this->speed;
    }

    /**
     * @param float $speed
     * @return $this
     */
    public function setSpeed(float $speed): self
    {
        $this->speed = $speed;
        return $this;
    }

    /**
     * @return int
     */
    public function getL2Cache(): int
    {
        return $this->l2Cache;
    }

    /**
     * @param int $l2Cache
     * @return $this
     */
    public function setL2Cache(int $l2Cache): self
    {
        $this->l2Cache = $l2Cache;
        return $this;
    }

    /**
     * @see https://unix.stackexchange.com/questions/43539/what-do-the-flags-in-proc-cpuinfo-mean#answer-43540
     * @return null|string[]
     */
    public function getFlags(): ?array
    {
        return $this->flags;
    }

    /**
     * @param null|string[] $flags
     * @return $this
     */
    public function setFlags(?array $flags): self
    {
        $this->flags = $flags;
        return $this;
    }

    /**
     * @param string $architecture (x86|x64|ia64) currently arm or mips not supported
     * @return $this
     */
    public function setArchitecture(string $architecture): self
    {
        $this->architecture = $architecture;
        return $this;
    }

    /**
     * @return string (x86|x64|ia64) currently arm or mips not supported
     */
    public function getArchitecture()
    {
        return $this->architecture;
    }
}
