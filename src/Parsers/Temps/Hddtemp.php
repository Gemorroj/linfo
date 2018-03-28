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

namespace Linfo\Parsers\Temps;

use Linfo\Parsers\Parser;

class Hddtemp implements Parser
{
    final private function __construct()
    {
    }

    final private function __clone()
    {
    }


    /**
     * Connect to host/port and get info
     *
     * @param string $host
     * @param int $port
     * @param int $timeout
     * @return null|string
     */
    private function getData($host, $port, $timeout)
    {
        $sock = @\fsockopen($host, $port, $errno, $errstr, $timeout);
        if (!$sock) {
            return null;
        }

        $data = '';
        while ($mid = \fgets($sock)) {
            $data .= $mid;
        }
        \fclose($sock);

        return $data;
    }

    /**
     * Parse and return info from daemon socket
     *
     * @param string $data
     * @return array
     */
    private function parseSockData($data)
    {
        // Kill surounding ||'s and split it by pipes
        $drives = \explode('||', \trim($data, '|'));

        $return = [];
        foreach ($drives as $drive) {
            list($path, $name, $temp, $unit) = \explode('|', \trim($drive));

            // Ignore garbled output from SSDs that hddtemp cant parse
            if (\mb_strpos($temp, 'UNK') !== false) {
                continue;
            }

            // Ignore no longer existant devices?
            if (!\file_exists($path) && \is_readable('/dev')) {
                continue;
            }

            $return[] = [
                'path' => $path,
                'name' => $name,
                'temp' => $temp,
                'unit' => \mb_strtoupper($unit),
            ];
        }

        return $return;
    }

    /**
     * @param string $host
     * @param int $port
     * @param int $timeout
     * @return array|null
     */
    public static function work($host = 'localhost', $port = 7634, $timeout = 1)
    {
        $obj = new self();
        $data = $obj->getData($host, $port, $timeout);
        if (null === $data) {
            return null;
        }

        return $obj->parseSockData($data);
    }
}