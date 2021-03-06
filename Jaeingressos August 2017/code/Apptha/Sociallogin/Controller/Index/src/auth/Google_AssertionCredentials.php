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
class Google_AssertionCredentials {
    const MAX_TOKEN_LIFETIME_SECS = 3600;
    public $serviceAccountName;
    public $scopes;
    public $privateKey;
    public $privateKeyPassword;
    public $assertionType;
    public $prn;

    /**
     *
     * @param
     *            $serviceAccountName
     * @param $scopes array
     *            List of scopes
     * @param
     *            $privateKey
     * @param string $privateKeyPassword
     * @param string $assertionType
     * @param bool|string $prn
     *            The email address of the user for which the
     *            application is requesting delegated access.
     */
    public function __construct($serviceAccountName, $scopes, $privateKey, $privateKeyPassword = 'notasecret', $assertionType = 'http://oauth.net/grant_type/jwt/1.0/bearer', $prn = false) {
        $this->serviceAccountName = $serviceAccountName;
        $this->scopes = is_string ( $scopes ) ? $scopes : implode ( ' ', $scopes );
        $this->privateKey = $privateKey;
        $this->privateKeyPassword = $privateKeyPassword;
        $this->assertionType = $assertionType;
        $this->prn = $prn;
    }
    public function generateAssertion() {
        $now = time ();

        $jwtParams = array (
                'aud' => Google_OAuth2::OAUTH2_TOKEN_URI,
                'scope' => $this->scopes,
                'iat' => $now,
                'exp' => $now + self::MAX_TOKEN_LIFETIME_SECS,
                'iss' => $this->serviceAccountName
        );

        if ($this->prn !== false) {
            $jwtParams ['prn'] = $this->prn;
        }

        return $this->makeSignedJwt ( $jwtParams );
    }

    /**
     * Creates a signed JWT.
     *
     * @param array $payload
     * @return string The signed JWT.
     */
    private function makeSignedJwt($payload) {
        $header = array (
                'typ' => 'JWT',
                'alg' => 'RS256'
        );

        $segments = array (
                Google_Utils::urlSafeB64Encode ( json_encode ( $header ) ),
                Google_Utils::urlSafeB64Encode ( json_encode ( $payload ) )
        );

        $signingInput = implode ( '.', $segments );
        $signer = new Google_P12Signer ( $this->privateKey, $this->privateKeyPassword );
        $signature = $signer->sign ( $signingInput );
        $segments [] = Google_Utils::urlSafeB64Encode ( $signature );

        return implode ( ".", $segments );
    }
}
