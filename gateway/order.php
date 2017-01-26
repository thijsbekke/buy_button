<?php
//The "Public key" or "Api key" can be retrieved in the webshop.
//This should be the same as the header 'x-public'.
$publicKey = 'your_public_key';

//The "Secret key" or "Api secret" can be retrieved in the webshop.
$secretKey = 'ssst_this_is_a_secret';

//The address of your webshop
$domain = 'https://team-thijs.securearea.eu';

//Set the time zone to utc
date_default_timezone_set('UTC');
$timeStamp = date('c');

//First collect a set of products,

//The request URI minus the domain name
$uri = '/api/rest/v1/products';

//Creating the hash
$hash = hash_hmac('sha512', "$publicKey|GET|$uri||$timeStamp", $secretKey);

$rCurlHandler = curl_init();
curl_setopt($rCurlHandler, CURLOPT_URL, $domain.$uri);
curl_setopt($rCurlHandler, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($rCurlHandler, CURLOPT_HTTPHEADER,
  array(
      "x-date: ". $timeStamp,
      "x-hash: ". $hash,
      "x-public: ". $publicKey
  )
);

$sOutput = curl_exec($rCurlHandler);
curl_close($rCurlHandler);

//Response : a list with objects of products
$response = json_decode($sOutput);


//Random select one.
if(!isset($response->items)) {
    header("HTTP/1.0 204 No products found");
}

$random = rand(0, (count($response->items)-1));

$orderRow = new stdClass();
$orderRow->product_id = $response->items[$random]->id;
$orderRow->count = 1;

$order = new stdClass();
$order->customer = new stdClass();
//Your own user id
$order->user_id = 4740289;
$order->orderrows = array(
    $orderRow
);


//HTTP method in upppercase (ie: GET, POST, PATCH, DELETE)
$method = 'POST';

//The request URI minus the domain name
$uri = '/api/rest/v1/orders';

//Datafields to Json
$data = json_encode($order);

$hashString = "$publicKey|$method|$uri|$data|$timeStamp";
$hash = hash_hmac('sha512', $hashString, $secretKey);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $domain . $uri);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER,
    array(
        "x-date: " . $timeStamp,
        "x-hash: " . $hash,
        "x-public: " . $publicKey
    )
);

curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

$sOutput = curl_exec($ch);
//Response : a product object
$response = json_decode($sOutput);
print_r(curl_error($ch));
curl_close($ch);
