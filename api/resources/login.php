<?php
$auth = array("POST"=>"all","DELETE"=>"all");

function POST($schema,$body,$predicate,$jwt) {
    
    $dbquery = "SELECT * FROM $schema.Utilisateur ";
    
    if($predicate == '') {$predicate = 'WHERE '; }
    $predicate .= "username = '".mysql_real_escape_string($body['username'])."' ";
    $predicate .= " AND password = '".mysql_real_escape_string($body['password'])."' ";
    
    $dbquery .= $predicate.";";
    
    $qur = mysql_query($dbquery);
    
    $result = array();
    while($r=mysql_fetch_array($qur)){
        extract($r);
        $result[]= array("id"=>$id,"username"=>$username,"firstName"=>$firstName,"role"=>$role);
    }
    
    if(count($result)==1) {    
        $payload = array("rol"=>$result[0]['role'],"exp"=>'2017-01-21');
        require('jwt.php');
        $jwt = new JWT;
    
        $response['respCode'] = '201';
        $response['msg']=array("token"=>$jwt->encode($payload,$jwt->key)) ;
    }
    
    else {
        $response['respCode'] = '403';
        $response['msg']="invalid credentials" ;
    }
    
    return($response);
}


?>