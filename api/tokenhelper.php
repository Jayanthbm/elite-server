<?php

require './vendor/autoload.php';
use \Firebase\JWT\JWT;

function encode_jwt($storeId,$secretKey){
    $payload = array(
        "id" => $storeId,
    );
    $jwt = JWT::encode($payload, $secretKey);
    return $jwt;
}

function decode_jwt($jwt, $secretKey)
{
    $decoded = JWT::decode($jwt, $secretKey, array('HS256'));
    $id = $decoded->id;
    return $id;

}