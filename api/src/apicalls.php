<?php

$accepted_key="";       // Example: MySUP3r5eCRe7KeY

define("endpoint","");  // Example: www.example.com/api/

define("proto","");     // Example: https

//////////////////Do Not Edit Below this Line/////////////////////////////////

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value


function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
/*
    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");
*/
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}


// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value


function CallAPIjson($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
/*
    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");
*/
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
   $headers = array();
   $headers[] = 'Accept: application/json';
   $headers[] = 'Content-Type: application/json';
    curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}


function solari_ask($api,$settings,$text){
$data="key=".$api."&settings=".urlencode($settings)."&text=".urlencode($text);
$results=CallAPI("POST", proto."://".endpoint."ask",$data);
$ar = json_decode($results);
return $ar;
}


function solari_tts($api,$engine,$text){
$data="key=".$api."&engine=".$engine."&text=".urlencode($text);
$results=CallAPI("POST", proto."://".endpoint."tts",$data);
$ar = json_decode($results);
return $ar;
}

