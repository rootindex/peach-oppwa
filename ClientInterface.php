<?php
/**
 * Copyright (c) 2016. Francois Raubenheimer
 */

namespace Peach\Oppwa;

/**
 * Interface ClientInterface
 * @package Peach\Oppwa
 */
interface ClientInterface
{
    /**
     * Make GET request
     *
     * @return array
     */
    public function process();

    /**
     * Build Url to call in api
     *
     * @return string
     */
    public function buildUrl();

}