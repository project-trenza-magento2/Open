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
class Google_LoginTicket {
    const USER_ATTR = "id";

    // Information from id token envelope.
    private $envelope;

    // Information from id token payload.
    private $payload;

    /**
     * Creates a user based on the supplied token.
     *
     * @param string $envelope
     *            Header from a verified authentication token.
     * @param string $payload
     *            Information from a verified authentication token.
     */
    public function __construct($envelope, $payload) {
        $this->envelope = $envelope;
        $this->payload = $payload;
    }

    /**
     * Returns the numeric identifier for the user.
     *
     * @throws Google_AuthException
     * @return
     *
     */
    public function getUserId() {
        if (array_key_exists ( self::USER_ATTR, $this->payload )) {
            return $this->payload [self::USER_ATTR];
        }
        throw new Google_AuthException ( "No user_id in token" );
    }

    /**
     * Returns attributes from the login ticket.
     * This can contain
     * various information about the user session.
     *
     * @return array
     */
    public function getAttributes() {
        return array (
                "envelope" => $this->envelope,
                "payload" => $this->payload
        );
    }
}
