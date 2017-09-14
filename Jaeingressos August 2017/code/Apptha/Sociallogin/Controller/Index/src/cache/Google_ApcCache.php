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
class googleApcCache extends Google_Cache {
    public function __construct() {
        if (! function_exists ( 'apc_add' )) {
            throw new Google_CacheException ( "Apc functions not available" );
        }
    }
    private function isLocked($key) {
        if ((@apc_fetch ( $key . '.lock' )) === false) {
            return false;
        }
        return true;
    }
    private function createLock($key) {
        // the interesting thing is that this could fail if the lock was created in the meantime..
        // but we'll ignore that out of convenience
        @apc_add ( $key . '.lock', '', 5 );
    }
    private function removeLock($key) {
        // suppress all warnings, if some other process removed it that's ok too
        @apc_delete ( $key . '.lock' );
    }
    private function waitForLock($key) {
        // 20 x 250 = 5 seconds
        $tries = 20;
        $cnt = 0;
        do {
            // 250 ms is a long time to sleep, but it does stop the server from burning all resources on polling locks..
            usleep ( 250 );
            $cnt ++;
        } while ( $cnt <= $tries && $this->isLocked ( $key ) );
        if ($this->isLocked ( $key )) {
            // 5 seconds passed, assume the owning process died off and remove it
            $this->removeLock ( $key );
        }
    }

    /**
     * @inheritDoc
     */
    public function get($key, $expiration = false) {
        if (($ret = @apc_fetch ( $key )) === false) {
            return false;
        }
        if (! $expiration || (time () - $ret ['time'] > $expiration)) {
            $this->delete ( $key );
            return false;
        }
        return unserialize ( $ret ['data'] );
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value) {
        if (@apc_store ( $key, array (
                'time' => time (),
                'data' => serialize ( $value )
        ) ) == false) {
            throw new Google_CacheException ( "Couldn't store data" );
        }
    }

    /**
     * @inheritDoc
     *
     * @param String $key
     */
    public function delete($key) {
        @apc_delete ( $key );
    }
}
