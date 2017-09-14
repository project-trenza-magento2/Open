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
class Google_BatchRequest {
    /** @var string Multipart Boundary. */
    private $boundary;

    /** @var array service requests to be executed. */
    private $requests = array ();
    public function __construct($boundary = false) {
        $boundary = (false == $boundary) ? mt_rand () : $boundary;
        $this->boundary = str_replace ( '"', '', $boundary );
    }
    public function add(Google_HttpRequest $request, $key = false) {
        if (false == $key) {
            $key = mt_rand ();
        }

        $this->requests [$key] = $request;
    }
    public function execute() {
        $body = '';

        /** @var Google_HttpRequest $req */
        foreach ( $this->requests as $key => $req ) {
            $body .= "--{$this->boundary}\n";
            $body .= $req->toBatchString ( $key ) . "\n";
        }

        $body = rtrim ( $body );
        $body .= "\n--{$this->boundary}--";

        global $apiConfig;
        $url = $apiConfig ['basePath'] . '/batch';
        $httpRequest = new Google_HttpRequest ( $url, 'POST' );
        $httpRequest->setRequestHeaders ( array (
                'Content-Type' => 'multipart/mixed; boundary=' . $this->boundary
        ) );

        $httpRequest->setPostBody ( $body );
        $response = Google_Client::$io->makeRequest ( $httpRequest );

        $response = $this->parseResponse ( $response );
        return $response;
    }
    public function parseResponse(Google_HttpRequest $response) {
        $contentType = $response->getResponseHeader ( 'content-type' );
        $contentType = explode ( ';', $contentType );
        $boundary = false;
        foreach ( $contentType as $part ) {
            $part = (explode ( '=', $part, 2 ));
            if (isset ( $part [0] ) && 'boundary' == trim ( $part [0] )) {
                $boundary = $part [1];
            }
        }

        $body = $response->getResponseBody ();
        if ($body) {
            $body = str_replace ( "--$boundary--", "--$boundary", $body );
            $parts = explode ( "--$boundary", $body );
            $responses = array ();

            foreach ( $parts as $part ) {
                $part = trim ( $part );
                if (! empty ( $part )) {
                    list ( $metaHeaders, $part ) = explode ( "\r\n\r\n", $part, 2 );
                    $metaHeaders = Google_CurlIO::parseResponseHeaders ( $metaHeaders );

                    $status = substr ( $part, 0, strpos ( $part, "\n" ) );
                    $status = explode ( " ", $status );
                    $status = $status [1];

                    list ( $partHeaders, $partBody ) = Google_CurlIO::parseHttpResponse ( $part, false );
                    $response = new Google_HttpRequest ( "" );
                    $response->setResponseHttpCode ( $status );
                    $response->setResponseHeaders ( $partHeaders );
                    $response->setResponseBody ( $partBody );
                    $response = Google_REST::decodeHttpResponse ( $response );

                    // Need content id.
                    $responses [$metaHeaders ['content-id']] = $response;
                }
            }

            return $responses;
        }

        return null;
    }
}