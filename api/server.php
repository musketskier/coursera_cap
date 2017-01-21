<?php
include('config.php');
include('functions.php');

// ------ acquiring the info from the request ------
   $headers = getallheaders();  // in functions.php

   $method  = $_SERVER['REQUEST_METHOD'];
   $request = rtrim($_GET['request'],'/');   unset($_GET['request']);
   $filter  = $_GET['$filter'];              unset($_GET['$filter']);
   $orderby = $_GET['$orderby'];             unset($_GET['$orderby']);
   $top     = $_GET['$top'];                 unset($_GET['$top']);
   $skip    = $_GET['$skip'];                unset($_GET['$skip']);
   $query   = $_GET;
   $body    = json_decode(file_get_contents('php://input'),true);
   ($headers[$xaccesstkn]) ? $jwt=$headers[$xaccesstkn] : $jwt=false;
   ($headers['x-awxs']) ? $awxs=true : $awxs=false;
   $accept  = $_SERVER['HTTP_ACCEPT'];       $remIP = $_SERVER['REMOTE_ADDR'];

// ------ forgery? -----------
   if(!$awxs) { $respCode = '403'; require('view.php'); }

// ------- implemented ? ------
   $resource = 'resources/'.explode("/",$request)[0].'.php';
   if(!File_exists($resource)) {$respCode = '501'; require('view.php');}

// ------ method allowed ? ------
   require($resource);
   if(!Function_exists($method)) {$respCode = '503'; require('view.php');}

// ------ authorised -----
   // function call(auth, jwt) { check auth (if all, go, else decode jwt, expiry? auth role in line, ....)}
    $authZ = false;
    if($auth[$method]=='all') {$authZ = true;}
    elseif($jwt){
        echo 'token: '.$jwt;
        require('jwt.php'); 
        $jwt_class = new JWT; 
        $validation = $jwt_class->decode($jwt); 
        if($validation){$authZ = true; } 
    }

    if(!$authZ) {$respCode = '403'; require('view.php'); }

// ----- call method -----
    require('../../../../private/connectMySQL.php');
    $conn = mysql_connect($dbhost,$dbuser,$dbpw);

        $query = prepQuery($query);
        if($filter!='') {$filter = prepFilters($filter);} else {$query=rtrim($query,' AND ');}
        if($orderby !=''){$orderby = prepOrderby($orderby);}
        if($top !=''){$top = prepTop($top);}
        if($skip !=''){$skip = prepSkip($skip);}
        
        
        $predicate .= $query.$filter.$orderby.$top.$skip;
        if($predicate !='') {$predicate = "WHERE ".$predicate;};

        //echo 'pred: '.$predicate;

        $resp = $method($schema,$body,$predicate,$jwt);
        
    @mysql_close($conn);

    $respCode = $resp['respCode'];
    $response = $resp['msg'];
    require('view.php');


// ----- only testing --------
 echo 'call: '.$method.' /'.$request.'<br />';
 //echo 'headers: '; print_r($headers); echo '<br />';
 
 echo 'body: '   ; print_r($body); echo '<br />';
 echo 'query: '  ; print_r($query); echo '<br />';

 echo 'filter: ' ; print_r($filter); echo '<br />';
 echo 'orderby: '; print_r($orderby); echo '<br />';
 echo 'top: '    ; print_r($top); echo '<br />';
 echo 'skip: '   ; print_r($skip); echo '<br />';
 
 echo 'jwt: '.$jwt.'<br />';
 echo 'awxs: '.$awxs.'<br />';
 echo 'from: '.$remIP.'<br />';
 echo 'accept: '.$accept.'<br />';

?>