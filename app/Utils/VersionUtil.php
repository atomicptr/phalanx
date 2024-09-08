<?php

namespace App\Utils;

class VersionUtil
{
    public static function isValid(string $version): bool
    {
        $res = preg_match("/^([1-9]+[0-9]*)\.([1-9]+[0-9]*)\.([1-9]+[0-9]*)$/", $version);

        return $res !== false && $res > 0;
    }

    public static function parse(string $version): array
    {
        assert(static::isValid($version));

        [$major, $minor, $patch] = explode('.', $version);

        return [intval($major), intval($minor), intval($patch)];
    }

    public static function compare(string $version1, string $version2): int
    {
        [$v1Major, $v1Minor, $v1Patch] = static::parse($version1);
        [$v2Major, $v2Minor, $v2Patch] = static::parse($version2);

        if ($res = ($v1Major <=> $v2Major) !== 0) {
            return $res;
        }

        if ($res = ($v1Minor <=> $v2Minor) !== 0) {
            return $res;
        }

        return $v1Patch <=> $v2Patch;
    }
}
