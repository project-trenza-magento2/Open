<?php

/**
 * Apptha
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.apptha.com/LICENSE.txt
 *
 * ==============================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * ==============================================================
 * This package designed for Magento COMMUNITY edition
 * Apptha does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Apptha does not provide extension support in case of
 * incorrect edition usage.
 * ==============================================================
 *
 * @category     Apptha
 * @package      Apptha_Sociallogin
 * @version      1.2
 * @author      Apptha Team <developers@contus.in>
 * @copyright   Copyright (c) 2017 Apptha. (http://www.apptha.com)
 * @license     http://www.apptha.com/LICENSE.txt
 *
 * */
require_once "Google_FileCache.php";
require_once "Google_MemcacheCache.php";

/**
 * Abstract storage class
 *
 * @author Chris Chabot <chabotc@google.com>
 */
abstract class Google_Cache {

    /**
     * Retrieves the data for the given key, or false if they
     * key is unknown or expired
     *
     * @param String $key
     *            The key who's data to retrieve
     * @param boolean|int $expiration
     *            Expiration time in seconds
     *
     */
    abstract function get($key, $expiration = false);

    /**
     * Store the key => $value set.
     * The $value is serialized
     * by this function so can be of any type
     *
     * @param string $key
     *            Key of the data
     * @param string $value
     *            data
     */
    abstract function set($key, $value);

    /**
     * Removes the key/data pair for the given $key
     *
     * @param String $key
     */
    abstract function delete($key);
}


