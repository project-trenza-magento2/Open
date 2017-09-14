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
class Google_AuthNone extends Google_Auth {
    public $key = null;
    public function __construct() {
        global $apiConfig;
        if (! empty ( $apiConfig ['developer_key'] )) {
            $this->setDeveloperKey ( $apiConfig ['developer_key'] );
        }
    }
    public function setDeveloperKey($key) {
        $this->key = $key;
    }
    public function authenticate($service) { /* noop */
    }
    public function setAccessToken($accessToken) { /* noop */
    }
    public function getAccessToken() {
        return null;
    }
    public function createAuthUrl($scope) {
        return null;
    }
    public function refreshToken($refreshToken) { /* noop */
    }
    public function revokeToken() { /* noop */
    }
    public function sign(Google_HttpRequest $request) {
        if ($this->key) {
            $request->setUrl ( $request->getUrl () . ((strpos ( $request->getUrl (), '?' ) === false) ? '?' : '&') . 'key=' . urlencode ( $this->key ) );
        }
        return $request;
    }
}
