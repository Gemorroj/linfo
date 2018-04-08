<?php

/**
 * This file is part of Linfo (c) 2010 Joseph Gillotti.
 *
 * Linfo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Linfo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Linfo. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace Linfo\Info\Samba;

class Service
{
    /** @var string */
    private $service;
    /** @var int */
    private $pid;
    /** @var string */
    private $machine;
    /** @var \DateTime */
    private $connectedAt;
    /** @var string|null */
    private $encryption;
    /** @var string|null */
    private $signing;

    /**
     * @return null|string after samba 4.4
     */
    public function getEncryption(): ?string
    {
        return $this->encryption;
    }

    /**
     * @param null|string $encryption
     * @return $this
     */
    public function setEncryption(?string $encryption): self
    {
        $this->encryption = $encryption;
        return $this;
    }

    /**
     * @return null|string after samba 4.4
     */
    public function getSigning(): ?string
    {
        return $this->signing;
    }

    /**
     * @param null|string $signing
     * @return $this
     */
    public function setSigning(?string $signing): self
    {
        $this->signing = $signing;
        return $this;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @param string $service
     * @return $this
     */
    public function setService(string $service): self
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return int
     */
    public function getPid(): int
    {
        return $this->pid;
    }

    /**
     * @param int $pid
     * @return $this
     */
    public function setPid(int $pid): self
    {
        $this->pid = $pid;
        return $this;
    }

    /**
     * @return string
     */
    public function getMachine(): string
    {
        return $this->machine;
    }

    /**
     * @param string $machine
     * @return $this
     */
    public function setMachine(string $machine): self
    {
        $this->machine = $machine;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getConnectedAt(): \DateTime
    {
        return $this->connectedAt;
    }

    /**
     * @param \DateTime $connectedAt
     * @return $this
     */
    public function setConnectedAt(\DateTime $connectedAt): self
    {
        $this->connectedAt = $connectedAt;
        return $this;
    }
}