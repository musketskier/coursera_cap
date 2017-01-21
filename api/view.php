<?php

// allowing for cors (cross-origin resource sharing)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

http_response_code($respCode);            // setting the header response code
header('Content-Type: application/json'); // setting header


exit(Json_encode($response));

?>