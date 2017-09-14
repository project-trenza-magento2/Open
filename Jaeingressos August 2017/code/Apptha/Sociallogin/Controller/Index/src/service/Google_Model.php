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
class Google_Model {
    public function __construct( /* polymorphic */ ) {
        if (func_num_args () == 1 && is_array ( func_get_arg ( 0 ) )) {
            // Initialize the model with the array's contents.
            $array = func_get_arg ( 0 );
            $this->mapTypes ( $array );
        }
    }

    /**
     * Initialize this object's properties from an array.
     *
     * @param array $array
     *            Used to seed this object's properties.
     * @return void
     */
    protected function mapTypes($array) {
        foreach ( $array as $key => $val ) {
            $this->$key = $val;

            $keyTypeName = "__$key" . 'Type';
            $keyDataType = "__$key" . 'DataType';
            if ($this->useObjects () && property_exists ( $this, $keyTypeName )) {
                if ($this->isAssociativeArray ( $val )) {
                    if (isset ( $this->$keyDataType ) && 'map' == $this->$keyDataType) {
                        foreach ( $val as $arrayKey => $arrayItem ) {
                            $val [$arrayKey] = $this->createObjectFromName ( $keyTypeName, $arrayItem );
                        }
                        $this->$key = $val;
                    } else {
                        $this->$key = $this->createObjectFromName ( $keyTypeName, $val );
                    }
                } else if (is_array ( $val )) {
                    $arrayObject = array ();
                    foreach ( $val as $arrayIndex => $arrayItem ) {
                        $arrayObject [$arrayIndex] = $this->createObjectFromName ( $keyTypeName, $arrayItem );
                    }
                    $this->$key = $arrayObject;
                }
            }
        }
    }

    /**
     * Returns true only if the array is associative.
     *
     * @param array $array
     * @return bool True if the array is associative.
     */
    protected function isAssociativeArray($array) {
        if (! is_array ( $array )) {
            return false;
        }
        $keys = array_keys ( $array );
        foreach ( $keys as $key ) {
            if (is_string ( $key )) {
                return true;
            }
        }
        return false;
    }

    /**
     * Given a variable name, discover its type.
     *
     * @param
     *            $name
     * @param
     *            $item
     * @return object The object from the item.
     */
    private function createObjectFromName($name, $item) {
        $type = $this->$name;
        return new $type ( $item );
    }
    protected function useObjects() {
        global $apiConfig;
        return (isset ( $apiConfig ['use_objects'] ) && $apiConfig ['use_objects']);
    }

    /**
     * Verify if $obj is an array.
     *
     * @throws Google_Exception Thrown if $obj isn't an array.
     * @param array $obj
     *            Items that should be validated.
     * @param string $type
     *            Array items should be of this type.
     * @param string $method
     *            Method expecting an array as an argument.
     */
    public function assertIsArray($obj, $type, $method) {
        if ($obj && ! is_array ( $obj )) {
            throw new Google_Exception ( "Incorrect parameter type passed to $method(), expected an" . " array containing items of type $type." );
        }
    }
}
