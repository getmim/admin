<?php
/**
 * TimezoneFilter
 * @package admin
 * @version 0.0.1
 */

namespace Admin\Library;

class TimezoneFilter
    implements 
        \Admin\Iface\ObjectFilter
{

    static $last_error;

    static function filter(array $cond): ?array {
        $what       = $cond['what']    ?? 'ALL';
        $country    = $cond['country'] ?? null;
        $query      = $cond['q']       ?? null;
        if($country)
            $what = 'PER_COUNTRY';

        $what = strtoupper($what);

        if(!defined('DateTimeZone::'.$what))
            return [];
        $what = constant('DateTimeZone::'.$what);

        $timezones = timezone_identifiers_list($what, $country);

        if($query)
            $query = strtoupper($query);

        $result = [];
        foreach($timezones as $timezone){
            if($query && false === strstr(strtoupper($timezone), $query))
                continue;

            $continent = explode('/', $timezone);
            $result[] = [
                'id'    => $timezone,
                'label' => $timezone,
                'info'  => $continent[0],
                'icon'  => '<i class="fas fa-stream"></i>',
                // 'thumb' => null
            ];
        }

        return $result;
    }

    static function lastError(): ?string {
        return self::$last_error;
    }
}