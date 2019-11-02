<?php
/**
 * CanI
 * @package admin
 * @version 0.2.0
 */

namespace Admin\Service;


class CanI extends \Mim\Service
{
    public function __get($name): bool{
        return true;
    }
}