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
require_once 'io/Google_HttpRequest.php';
require_once 'io/Google_CurlIO.php';
require_once 'io/Google_REST.php';

/**
 * Abstract IO class
 *
 * @author Chris Chabot <chabotc@google.com>
 */
interface Google_IO {
    /**
     * An utility function that first calls $this->auth->sign($request) and then executes makeRequest()
     * on that signed request.
     * Used for when a request should be authenticated
     *
     * @param Google_HttpRequest $request
     * @return Google_HttpRequest $request
     */
    public function authenticatedRequest(Google_HttpRequest $request);

    /**
     * Executes a apIHttpRequest and returns the resulting populated httpRequest
     *
     * @param Google_HttpRequest $request
     * @return Google_HttpRequest $request
     */
    public function makeRequest(Google_HttpRequest $request);

    /**
     * Set options that update the transport implementation's behavior.
     *
     * @param
     *            $options
     */
    public function setOptions($options);
}
