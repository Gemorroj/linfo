<?php

/**
 * This file is part of Linfo (c) 2014 Joseph Gillotti.
 *
 * Linfo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Linfo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.    See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Linfo.    If not, see <http://www.gnu.org/licenses/>.
 */

namespace Linfo;

class Common
{
    /**
     * Certain files, specifcally the pci/usb ids files, vary in location from
     * linux distro to linux distro. This function, when passed an array of
     * possible file location, picks the first it finds and returns it. When
     * none are found, it returns false
     * @param string[] $paths
     * @return null|string
     */
    public static function locateActualPath(array $paths)
    {
        foreach ($paths as $path) {
            if (\file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Convert bytes to stuff like KB MB GB TB etc
     * @param int $size
     * @param int $precision
     * @return string
     */
    public static function byteConvert($size, $precision = 2)
    {
        // Sanity check
        if (!is_numeric($size)) {
            return '?';
        }

        // Get the notation
        $notation = 1024;

        // Fixes large disk size overflow issue
        // Found at http://www.php.net/manual/en/function.disk-free-space.php#81207
        $types = array('B', 'KB', 'MB', 'GB', 'TB');
        $types_i = array('B', 'KiB', 'MiB', 'GiB', 'TiB');
        for ($i = 0; $size >= $notation && $i < (count($types) - 1); $size /= $notation, $i++);

        return (round($size, $precision) . ' ' . ($notation == 1000 ? $types[$i] : $types_i[$i]));
    }

    /**
     * Like above, but for seconds
     * @param int $uptime
     * @return string
     * @deprecated
     */
    public static function secondsConvert($uptime)
    {
        // Method here heavily based on freebsd's uptime source
        $uptime += $uptime > 60 ? 30 : 0;
        $years = floor($uptime / 31556926);
        $uptime %= 31556926;
        $days = floor($uptime / 86400);
        $uptime %= 86400;
        $hours = floor($uptime / 3600);
        $uptime %= 3600;
        $minutes = floor($uptime / 60);
        $seconds = floor($uptime % 60);

        // Send out formatted string
        $return = array();

        if ($years > 0) {
            $return[] = $years . ' ' . ($years > 1 ? 'years' : \mb_substr('years', 0, \mb_strlen('years') - 1));
        }

        if ($days > 0) {
            $return[] = $days . ' ' . 'days';
        }

        if ($hours > 0) {
            $return[] = $hours . ' ' . 'hours';
        }

        if ($minutes > 0) {
            $return[] = $minutes . ' ' . 'minutes';
        }

        if ($seconds > 0) {
            $return[] = $seconds . (date('m/d') == '06/03' ? ' sex' : ' ' . 'seconds');
        }

        return implode(', ', $return);
    }

    /**
     * Get a file's contents, or default to second param
     *
     * @param string $file
     * @param mixed $default
     * @return string
     */
    public static function getContents($file, $default = null)
    {
        if (\file_exists($file) && \is_readable($file)) {
            return \trim(\file_get_contents($file));
        }
        return $default;
    }

    /**
     * Like above, but in lines instead of a big string
     * @param string $file
     * @param mixed $default
     * @return array|null
     */
    public static function getLines($file, $default = null)
    {
        if (\file_exists($file) && \is_readable($file)) {
            return \file($file, \FILE_SKIP_EMPTY_LINES);
        }
        return $default;
    }


    /**
     * Prevent silly conditionals like if (in_array() || in_array() || in_array())
     * Poor man's python's any() on a list comprehension kinda
     * @param array $needles
     * @param array $haystack
     * @return bool
     */
    public static function anyInArray(array $needles, array $haystack)
    {
        return \count(\array_intersect($needles, $haystack)) > 0;
    }
}
