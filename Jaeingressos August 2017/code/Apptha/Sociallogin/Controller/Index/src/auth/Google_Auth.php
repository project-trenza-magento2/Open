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
require_once "Google_AuthNone.php";
require_once "Google_OAuth2.php";

/**
 * Abstract class for the Authentication in the API client
 *
 * @author Chris Chabot <chabotc@google.com>
 *
 */
abstract class Google_Auth {
    abstract public function authenticate($service);
    abstract public function sign(Google_HttpRequest $request);
    abstract public function createAuthUrl($scope);
    abstract public function getAccessToken();
    abstract public function setAccessToken($accessToken);
    abstract public function setDeveloperKey($developerKey);
    abstract public function refreshToken($refreshToken);
    abstract public function revokeToken();
}
