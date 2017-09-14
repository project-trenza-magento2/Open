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
class Google_PemVerifier extends Google_Verifier {
    private $publicKey;

    /**
     * Constructs a verifier from the supplied PEM-encoded certificate.
     *
     * $pem: a PEM encoded certificate (not a file).
     *
     * @param
     *            $pem
     * @throws Google_AuthException
     * @throws Google_Exception
     */
    function __construct($pem) {
        if (! function_exists ( 'openssl_x509_read' )) {
            throw new Google_Exception ( 'Google API PHP client needs the openssl PHP extension' );
        }
        $this->publicKey = openssl_x509_read ( $pem );
        if (! $this->publicKey) {
            throw new Google_AuthException ( "Unable to parse PEM: $pem" );
        }
    }
    function __destruct() {
        if ($this->publicKey) {
            openssl_x509_free ( $this->publicKey );
        }
    }

    /**
     * Verifies the signature on data.
     *
     * Returns true if the signature is valid, false otherwise.
     *
     * @param
     *            $data
     * @param
     *            $signature
     * @throws Google_AuthException
     * @return bool
     */
    function verify($data, $signature) {
        $status = openssl_verify ( $data, $signature, $this->publicKey, "sha256" );
        if ($status === - 1) {
            throw new Google_AuthException ( 'Signature verification error: ' . openssl_error_string () );
        }
        return $status === 1;
    }
}
