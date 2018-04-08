<?php

namespace Linfo\Tests;

use Linfo\Info;
use Linfo\Linfo;

class LinfoTest extends \PHPUnit\Framework\TestCase
{
    /** @var Info */
    private $info;

    public function setUp()
    {
        $linfo = new Linfo();
        $this->info = $linfo->getInfo();
    }


    public function testGeneral()
    {
        $general = $this->info->getGeneral();
        $this->assertInstanceOf(Info\General::class, $general);

        \print_r($general);
    }

    public function testCpu()
    {
        $cpu = $this->info->getCpu();
        $this->assertInstanceOf(Info\Cpu::class, $cpu);

        \print_r($cpu);
    }

    public function testMemory()
    {
        $memory = $this->info->getMemory();
        $this->assertInstanceOf(Info\Memory::class, $memory);

        \print_r($memory);
    }

    public function testProcesses()
    {
        $processes = $this->info->getProcesses();
        $this->assertInternalType('array', $processes);

        \print_r($processes);
    }

    public function testNetwork()
    {
        $network = $this->info->getNetwork();
        $this->assertInternalType('array', $network);

        \print_r($network);
    }

    public function testUsb()
    {
        $usb = $this->info->getUsb();
        $this->assertInternalType('array', $usb);

        \print_r($usb);
    }

    public function testPci()
    {
        $pci = $this->info->getPci();
        $this->assertInternalType('array', $pci);

        \print_r($pci);
    }

    public function testSoundCard()
    {
        $soundCard = $this->info->getSoundCard();
        $this->assertInternalType('array', $soundCard);

        \print_r($soundCard);
    }

    public function testServices()
    {
        $services = $this->info->getServices();
        $this->assertInternalType('array', $services);

        \print_r($services);
    }

    public function testSamba()
    {
        $samba = $this->info->getSamba();
        if (\DIRECTORY_SEPARATOR === '\\') {
            $this->assertNull($samba);
            $this->markTestSkipped('Not implemented for windows');
        } else {
            $this->assertInstanceOf(Info\Samba::class, $samba);
        }

        \print_r($samba);
    }

    public function testUps()
    {
        $ups = $this->info->getUps();
        if (\DIRECTORY_SEPARATOR === '\\') {
            $this->assertNull($ups);
            $this->markTestSkipped('Not implemented for windows');
        } else {
            $this->assertInstanceOf(Info\Ups::class, $ups);
        }

        \print_r($ups);
    }

    public function testSelinux()
    {
        $selinux = $this->info->getSelinux();
        if (\DIRECTORY_SEPARATOR === '\\') {
            $this->assertNull($selinux);
            $this->markTestSkipped('Not implemented for windows');
        } else {
            $this->assertInstanceOf(Info\Selinux::class, $selinux);
        }

        \print_r($selinux);
    }

    public function testBattery()
    {
        $battery = $this->info->getBattery();
        if (\DIRECTORY_SEPARATOR === '\\') {
            $this->assertNull($battery); //todo
            $this->markTestSkipped('Not implemented for windows');
        } else {
            $this->assertInternalType('array', $battery);
        }

        \print_r($battery);
    }

    public function testSensors()
    {
        $sensors = $this->info->getSensors();
        if (\DIRECTORY_SEPARATOR === '\\') {
            $this->assertNull($sensors); //todo
            $this->markTestSkipped('Not implemented for windows');
        } else {
            $this->assertInternalType('array', $sensors);
        }

        \print_r($sensors);
    }

    public function testPrinters()
    {
        $printers = $this->info->getPrinters();
        if (\DIRECTORY_SEPARATOR === '\\') {
            $this->assertNull($printers); //todo
            $this->markTestSkipped('Not implemented for windows');
        } else {
            $this->assertInternalType('array', $printers);
        }

        \print_r($printers);
    }

    public function testDisk()
    {
        $disk = $this->info->getDisk();
        $this->assertInstanceOf(Info\Disk::class, $disk);
        $this->assertInternalType('array', $disk->getDrives());
        $this->assertInternalType('array', $disk->getMounts());

        if (\DIRECTORY_SEPARATOR === '\\') {
            $this->assertNull($disk->getRaids()); //todo
            //$this->markTestSkipped('Not implemented for windows');
        } else {
            $this->assertInternalType('array', $disk->getRaids());
        }

        \print_r($disk);
    }
}
