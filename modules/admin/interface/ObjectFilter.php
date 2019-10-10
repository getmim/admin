<?php
/**
 * ObjectFilter
 * @package admin
 * @version 0.0.1
 */

namespace Admin\Iface;

interface ObjectFilter
{

    static function filter(array $cond): ?array;

    static function lastError(): ?string;
}