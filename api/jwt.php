<?php

class JWT {   // thanks to Neuman Vong<neuman@twilio.com> and Anant Narayanan <anant@php.net> for class inspiration

    function JWT(){   // initialise, fetch secret
        //require '../auth/refs.php';
        $this->key = 'aklnadHNBljablED44slnagDFaa93q98yt398ytog8';
    }

    public static function decode($jwt,$verify=true) {  // $key is from initialisation class
        $tokens = explode('.',$jwt);
        if(count($tokens)!=3) {
            throw new UnexpectedValueException('incorrect nr of elements');}

        list ($headb64,$payloadb64,$signb64) = $tokens;

        If(null === ($header = JWT::jsonDecode(JWT::urlsafeB64Decode($headerb64)))) {
            throw new UnexpectedValueException('incorrect header encoding');}

        If(null === ($payload = JWT::jsonDecode(JWT::urlsafeB64Decode($payloadb64)))) {
            throw new UnexpectedValueException('incorrect payload encoding');}

        $sig = JWT::urlsafeB64Decode($signb64);

        if($verify) {
            if(empty($header->alg) || $header->alg=='null') throw new UnexpectedValueException('Empty algorythm');
            if($sig!=JWT::sign("$headb64.$bodyb64",$this->key,$header->alg)) {
                throw new UnexpectedValueException('Signature Verification Failed');}
        }
        return $payload;
    }

    public static function encode($payload,$key,$alg='HS256') {
        $header = array('typ'=>'JWT','alg'=>$alg);
        $segments = array();
        $segments[0]=JWT::urlsafeB64Encode(JWT::jsonEncode($header));
        $segments[1]=JWT::urlsafeB64Encode(JWT::jsonEncode($payload));
        $signature = JWT::sign(implode('.',$segments),$key,$alg);
        $segments[2]=JWT::urlsafeB64Encode($signature);
        return (implode('.',$segments));
    }

    public static function sign($msg,$key,$method='HS256'){
        $methods = array('HS256'=>'sha256','HS384'=>'sha384','HS512'=>'sha512');
        if(empty($methods[$method])) throw new UnexpectedValueException('Algorithm not supported');
        return (hash_hmac($methods[$method],$msg,$key,true));
    }

    public static function jsonDecode($input) {
        $obj=json_decode($input);
        if(!function_exists('json_last_error') && $errno = json_last_error()) {
            JWT::_handleJsonError($errno);}
        elseif ($obj === null && $input !== 'null') {
            throw new UnexpectedValueException('no input, no result');}
        return $obj;
    }

    public static function jsonEncode($input){
        (is_array($input)) ? $json=json_encode($input) : $json=$input;
        if(!function_exists('json_last_error') && $errno = json_last_error()) {echo 'json_last_error';
            JWT::handleJsonError($errno);}
        elseif ($json === null && $input !== 'null') { echo 'input';
            throw new UnexpectedValueException('no result from empty input');}
        return $json;
    }

    public static function urlsafeB64Encode($input) {

        return str_replace('=','',strtr(base64_encode($input), '+/','-_'));
    }

    public static function urlsafeB64Decode($input) {

        return base64_decode($input);
    }

    private static function _handleJsonError($errno) {
        $messages = array(  JSON_ERROR_DEPTH     => 'Max stack depth exceeded',
                            JSON_ERROR_CTRL_CHAR => 'unexpected ctrl char found',
                            JSON_ERROR_SYNTAX => 'JSON syntax error');
        throw new DomainException (
                (isset($messages[$errno])) ? $messages[$errno] : 'unknown JSON error: '.$errno
                );
        print_r($messages);
    }




/*
    public  $header;      // variable to hold the meta info (
                             // alg (algorythm) , typ (type), iss (issuer), aud (audience), jti (jwt claim ID
                             // sub (subject of token), iat(issued at time), exp (expiry), nbf (not before), ...
    public  $payload;     // content of the message (user name, role, company
    private $signature;   // validation element
    private $key;         // secret

    function jwt() {     // initialise, fetch secret
        require './ref.php';
        $this->key = $key;
    }


    function header() {
        $header= array('alg' => 'HS256','typ'=>'JWT','iss'=>'adelewagstaff.co.uk','iat'=> time(),'exp'=>time()+5000 );
        return json_encode($header);
    }

    function signing($header,$payload){ // calculate signature
        $sign = $header.".".$payload;
        $sign = hash_hmac("sha256", $sign, $this->key);
        return $sign;
    }

    function create($header,$payload){  // creating a JWT
        $this->header = base64_encode($header);
        $this->payload = base64_encode($payload);
        $this->signature = $this->signing($this->header,$this->payload);
        return $this->header.".".$this->payload.".".base64_encode($this->signature);
    }

    function validate($val) {       // validating the signature value from provided JWT, does it match? tampered with?
        $list=explode(".",$val);
        $signature = $this->signing($list[0],$list[1]);
        if( $list[2] == $signature ) return true; else return false;
    }
   */
}

?>
