<?php

// ----- get all headers readiness (PHP version qwirk ------
if (!function_exists('getallheaders')) { 
    function getallheaders() {
        $headers = ''; 
        foreach ($_SERVER as $name => $value) { 
            if (substr($name, 0, 5) == 'HTTP_') { 
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
                } 
            } 
        return $headers; 
        } 
    }

// ---------------------------------
// ------- SQL query preps ---------
// ---------------------------------

function prepQuery($query) {
    $string = '';
    if(isset($query)){
        foreach ($query as $name => $value) { 
            $string .= "`".mysql_real_escape_string($name)."` = '".mysql_real_escape_string($value)."' AND ";
            }
        // $string = rtrim($string,' AND ');
        }
    return $string;
    }


function prepFilters($filter) {
    if(isset($filter)) {
        $val = filter($filter);
        return $val;
        } 
    }
function filter($filter){
    $filters = Array(' Eq '=>'=',' Ne '=>'!=',' Gt '=>'>',' Ge '=>'>=',' Lt '=>'<',' Le '=>'<=',' Add '=>'+',' Sub '=>'-',' Mul '=>'*',' Div '=>'/',' Mod '=>'%');
    $keys = Array_keys($filters);
    
    $pos1 = Strpos($filter,' ');           
    $pos2 = Strpos($filter,' ',$pos1+1);   
    
    $val = "`".Substr($filter,0,$pos1)."` ".Substr($filter,$pos1+1,$pos2-$pos1)." '".Substr($filter,$pos2+1)."'";
    
    $val=Str_replace($keys,$filters,$val);
    
    return $val;
}

function prepOrderby($orderby) {
    $val = " ORDER BY '".$orderby."' ";
    return $val;
}


function prepTop($top) {
    $val = ' LIMIT '.$top.' ';
    return $val;
}
    
function prepSkip($skip) {
    $val = ' offset '.$skip.' ';
    return $val;
}
    
// -----------  auth functions ------------------------    

function checkAuthN($jwt) {}

?>