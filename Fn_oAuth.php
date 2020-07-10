<?php

require_once "Fn_botInfo.php";
require_once "Fn_webex.php";

if (!isset($_COOKIE['SparkapiAccess_token'])){
  if (!isset($_REQUEST['code'])){

    setcookie('Return2Page', $_SERVER['SCRIPT_NAME'], 0, '/');

    $url = 'https://api.ciscospark.com/v1/authorize'
    . '?response_type=code'
    . '&client_id='.$client_id
    . '&scope='.urlencode('spark:messages_read spark:people_read spark:rooms_read spark:messages_write')
    . '&redirect_uri='.$redirect_uri;

    header("Location: ".$url,TRUE,307); /* Redirect browser */
    exit;

  }elseif(isset($_REQUEST['code'])){

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.ciscospark.com/v1/access_token",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "redirect_uri=".$redirect_uri."&code=".$_REQUEST['code']."&client_id=".$client_id."&client_secret=".$Client_Secret."&grant_type=authorization_code",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/x-www-form-urlencoded",
        "postman-token: f01be3d1-e910-8772-9879-2cd7363a476d"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $access = json_decode($response);
      setcookie('SparkapiAccess_token', $access->access_token, 0, '/');
      if(isset($_COOKIE['Return2Page'])){
        setcookie('Return2Page', $baseURL, time() - 3600, '/');
        header("Location: $baseURL.".$_COOKIE['Return2Page'],TRUE,307); /* Redirect browser */
      }else{
        header("Location: ".$baseURL."/log/",TRUE,307); /* Redirect browser */
      }
      exit;
    }
  }
}elseif(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'out'){
  setcookie('SparkapiAccess_token', $baseURL, time() - 3600, '/');
  header("Location: ".$baseURL."/log/",TRUE,307); /* Redirect browser */
  exit;
}
?>
