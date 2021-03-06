<?php

namespace Ginfo\Parsers;

use Ginfo\Common;

class Mdadm implements ParserInterface
{
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function work(): ?array
    {
        /*
Personalities : [raid1]
md0 : active raid1 sdb[0]
      1046528 blocks super 1.2 [2/1] [U_]
         */
        $mdadmContents = Common::getContents('/proc/mdstat');
        if (null === $mdadmContents) {
            return null;
        }

        if (false === \preg_match_all('/(\S+)\s*:\s*(\w+)\s*raid(\d+)\s*([\w+\[\d+\] (\(\w\))?]+)\n\s+(\d+) blocks[^[]+\[(\d\/\d)\] \[([U\_]+)\]/mi', (string) $mdadmContents, $match, \PREG_SET_ORDER)) {
            return null;
        }

        $mdadmArrays = [];
        foreach ($match as $array) {
            $drives = [];
            foreach (\explode(' ', $array[4]) as $drive) {
                if (1 === \preg_match('/([\w\d]+)\[\d+\](\(\w\))?/', $drive, $matchDrive)) {
                    // Determine a status other than normal, like if it failed or is a spare
                    if (\array_key_exists(2, $matchDrive)) {
                        switch ($matchDrive[2]) {
                            case '(S)':
                                $driveState = 'spare';
                                break;
                            case '(F)':
                                $driveState = 'failed';
                                break;
                            case null:
                                $driveState = 'normal';
                                break;

                            // I'm not sure if there are status codes other than the above
                            default:
                                $driveState = null;
                                break;
                        }
                    } else {
                        $driveState = 'normal';
                    }

                    $drives[] = [
                        'path' => '/dev/'.$matchDrive[1],
                        'state' => $driveState,
                    ];
                }
            }

            [$countTotal, $countActive] = \explode('/', $array[6], 2);

            $mdadmArrays[] = [
                'device' => '/dev/'.$array[1],
                'status' => $array[2],
                'level' => $array[3],
                'drives' => $drives,
                'size' => $array[5] * 1024,
                'count' => [
                    'active' => $countActive,
                    'total' => $countTotal,
                ],
                'chart' => $array[7],
            ];
        }

        return $mdadmArrays;
    }
}
