<?php

$auth = array("GET"=>"user","POST"=>"admin","PUT"=>"admin");


function GET($schema,$body,$predicate,$jwt) {
    
    $dbquery = "SELECT * FROM $schema.Exhibitions ";
    $dbquery .= $predicate.";";
    
    //echo 'dbquery: '.$dbquery;
    $qur = mysql_query($dbquery);
    
    $result = array();
    while($r=mysql_fetch_array($qur)){
        extract($r);
        $result[$type][]= array("id"=>$id,"venueName"=>$venueName, "venueAddress"=>$venueAddress, "from"=>$from,"to"=>$to,"featured"=>$featured,"title"=>$title,"openingHours"=>$openingHours,"show"=>$show,"venueLocation"=>$venueLocation);
    }
    
    $response['code'] = '200';
    $response['msg']=$result;
    return($response);
}


?>