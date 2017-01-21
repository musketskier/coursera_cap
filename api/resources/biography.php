<?php
$auth = array('GET'=>'all','POST'=>'admin',"PUT"=>"admin");

function GET($schema,$body,$predicate,$jwt) {
    
    $dbquery = "SELECT * FROM $schema.biography ";
    $dbquery .= $predicate.";";
    
    //echo 'dbquery: '.$dbquery;
    $qur = mysql_query($dbquery);
    
    $result = array();
    while($r=mysql_fetch_array($qur)){
        extract($r);
        $result[]=array("biography"=>$biography);
    }
    
    $response['code'] = '200';
    $response['msg']=$result;
    return($response);
}


?>