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
class Google_P12Signer extends Google_Signer {
    // OpenSSL private key resource
    private $privateKey;

    // Creates a new signer from a .p12 file.
    function __construct($p12, $password) {
        if (! function_exists ( 'openssl_x509_read' )) {
            throw new Exception ( 'The Google PHP API library needs the openssl PHP extension' );
        }

        // This throws on error
        $certs = array ();
        if (! openssl_pkcs12_read ( $p12, $certs, $password )) {
            throw new Google_AuthException ( "Unable to parse the p12 file.  " . "Is this a .p12 file?  Is the password correct?  OpenSSL error: " . openssl_error_string () );
        }
        // TODO(beaton): is this part of the contract for the openssl_pkcs12_read
        // method? What happens if there are multiple private keys? Do we care?
        if (! array_key_exists ( "pkey", $certs ) || ! $certs ["pkey"]) {
            throw new Google_AuthException ( "No private key found in p12 file." );
        }
        $this->privateKey = openssl_pkey_get_private ( $certs ["pkey"] );
        if (! $this->privateKey) {
            throw new Google_AuthException ( "Unable to load private key in " );
        }
    }
    function __destruct() {
        if ($this->privateKey) {
            openssl_pkey_free ( $this->privateKey );
        }
    }
    function sign($data) {
        if (version_compare ( PHP_VERSION, '5.3.0' ) < 0) {
            throw new Google_AuthException ( "PHP 5.3.0 or higher is required to use service accounts." );
        }
        if (! openssl_sign ( $data, $signature, $this->privateKey, "sha256" )) {
            throw new Google_AuthException ( "Unable to sign data" );
        }
        return $signature;
    }
}
