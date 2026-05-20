<?php

if (!function_exists('encryptId')) {

    function encryptId($id)
    {
        $encrypter = \Config\Services::encrypter();

        return bin2hex(
            $encrypter->encrypt($id)
        );
    }
}

if (!function_exists('encryptIds')) {

    function encryptIds($data)
    {
        foreach ($data as &$obj) {

            if (isset($obj['id'])) {

                $obj['id'] = encryptId($obj['id']);
            }
        }

        return $data;
    }
}
if (!function_exists('decryptId')) {

    function decryptId($encryptedId)
    {
        $encrypter = \Config\Services::encrypter();

        return $encrypter->decrypt(
            hex2bin($encryptedId)
        );
    }
}