<?php

//MESSAGE ------------------------------------------------------------------
function PostMessage($authId,$json_array){
  $URL = 'https://api.ciscospark.com/v1/messages';
  $CURLOPT_POSTFIELDS = json_encode($json_array);

  return POST($URL,$CURLOPT_POSTFIELDS,$authId);
}

function DeleteMessage($authId,$id){
  $URL = 'https://api.ciscospark.com/v1/messages/'.$id;
  return DELETE($URL,$authId);
}

function GetMessageInfo($authId,$id){
  $URL = 'https://api.ciscospark.com/v1/messages/'.$id;
  return json_decode(GET($URL,$authId));
}

function ListMessagesTest($authId,$id){
  $URL = 'https://api.ciscospark.com/v1/messages?roomId='.$id.'&max=1';
  return json_decode(GET($URL,$authId));
}

//PEOPLE -----------------------------------------------------------------------

function ListPeopole($authId){
  $URL = 'https://api.ciscospark.com/v1/people';
  return GET($URL,$authId);
}

function GetPerson($authId,$id){
  $URL = 'https://api.ciscospark.com/v1/people/'.$id;
  return json_decode(GET($URL,$authId));
}

function GetMe($authId){
  $URL = 'https://api.ciscospark.com/v1/people/me';
  return json_decode(GET($URL,$authId));
}



//ROOMS ------------------------------------------------------------------------

function GetRooms($authId){
  $URL = 'https://api.ciscospark.com/v1/rooms';
  return json_decode(GET($URL,$authId));
}

function GetRoomsInTeam($authId,$id){
  $URL = 'https://api.ciscospark.com/v1/rooms?teamId='.$id;
  return json_decode(GET($URL,$authId));
}
function PostRoom($authId,$roomName){
  $URL = 'https://api.ciscospark.com/v1/rooms';
  $json_array = array(
              "title" => $roomName
          );
  $CURLOPT_POSTFIELDS = json_encode($json_array);

  return POST($URL,$CURLOPT_POSTFIELDS,$authId);
}

function PostRoom2Team($authId,$roomName,$teamId){
  $URL = 'https://api.ciscospark.com/v1/rooms';
  $json_array = array(
              "title" => $roomName,
              "teamId" => $teamId
          );
  $CURLOPT_POSTFIELDS = json_encode($json_array);

  return POST($URL,$CURLOPT_POSTFIELDS,$authId);
}

function GetRoomsInfo($authId,$id){
  $URL = 'https://api.ciscospark.com/v1/rooms/'.$id;
  return json_decode(GET($URL,$authId));
}

function DeleteRooms($authId,$id){
  $URL = 'https://api.ciscospark.com/v1/rooms/'.$id;
  return DELETE($URL,$authId);
}

//MEMBERSHIPS ------------------------------------------------------------------

function PostMembership($authId,$roomID,$personEmail,$isModerator){
  $URL = 'https://api.ciscospark.com/v1/memberships';
  $json_array = array(
              'roomId'=> $roomID,
              'personEmail'=> $personEmail,
              'isModerator'=> $isModerator
          );
  $CURLOPT_POSTFIELDS = json_encode($json_array);

  return POST($URL,$CURLOPT_POSTFIELDS,$authId);
}

function GetMembership($authId,$roomId,$personEmail){
  $URL = 'https://api.ciscospark.com/v1/memberships?roomId='.$roomId.'&personEmail='.$personEmail;
  return json_decode(GET($URL,$authId));
}

function GetRoomMembership($authId,$roomId){
  $URL = 'https://api.ciscospark.com/v1/memberships?roomId='.$roomId;
  return json_decode(GET($URL,$authId));
}

function DeleteMembership($authId,$id){
  $URL = 'https://api.ciscospark.com/v1/memberships/'.$id;
  return DELETE($URL,$authId);
}

//TEAMS ------------------------------------------------------------------------
function GetTeams($authId){
  $URL = 'https://api.ciscospark.com/v1/teams';
  return json_decode(GET($URL,$authId));
}

function GetTeamInfo($authId,$id){
  $URL = 'https://api.ciscospark.com/v1/teams/'.$id;
  return json_decode(GET($URL,$authId));
}

function PostTeams($authId,$teamName){
  $URL = 'https://api.ciscospark.com/v1/teams';
  $json_array = array(
              "name" => $teamName
          );
  $CURLOPT_POSTFIELDS = json_encode($json_array);

  return POST($URL,$CURLOPT_POSTFIELDS,$authId);
}

function PutTeams($authId,$teamName,$id){
  $URL = 'https://api.ciscospark.com/v1/teams/'.$id;
  $json_array = array(
              "name" => $teamName
          );
  $CURLOPT_POSTFIELDS = json_encode($json_array);

  return POST($URL,$CURLOPT_POSTFIELDS,$authId);
}


//TEAM MEMBERSHIPS -------------------------------------------------------------
function PostTeamMemberships($authId,$teamId,$personEmail,$isModerator){
  $URL = 'https://api.ciscospark.com/v1/team/memberships';
  $json_array = array(
              "teamId" => $teamId,
              "personEmail" => $personEmail,
              "isModerator" => $isModerator
          );
  $CURLOPT_POSTFIELDS = json_encode($json_array);

  return POST($URL,$CURLOPT_POSTFIELDS,$authId);
}

function GetTeamMemberships($authId,$teamId){
  $URL = 'https://api.ciscospark.com/v1/memberships?teamId='.$teamId;
  return json_decode(GET($URL,$authId));
}

function DeleteTeamMemberships($authId,$id){
  $URL = 'https://api.ciscospark.com/v1/team/memberships/'.$id;
  return DELETE($URL,$authId);
}
//WEBHOOKS ---------------------------------------------------------------------
function PostWebhook($authId,$json_array){
  $URL = 'https://api.ciscospark.com/v1/webhooks';

  $CURLOPT_POSTFIELDS = json_encode($json_array);

  return POST($URL,$CURLOPT_POSTFIELDS,$authId);
}

function GetWebhook($authId){
  $URL = 'https://api.ciscospark.com/v1/webhooks';
  return json_decode(GET($URL,$authId));
}
//------------------------------------------------------------------------------
//Base functions

function GET($CURLOPT_URL,$authId){
//  echo '<br><br><br>';
  if(is_array($CURLOPT_URL)){
//    echo '<pre>';
//    print_r($CURLOPT_URL);
//    echo '</pre>';
    $last_body = json_decode($CURLOPT_URL[1], true);
    $CURLOPT_URL = $CURLOPT_URL[0];
  }
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $CURLOPT_URL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_VERBOSE => true,
    CURLOPT_HEADER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer ".$authId,
      "cache-control: no-cache",
      "content-type: application/json"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  $info = curl_getinfo($curl);
  $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
  $header_text = substr($response, 0, $header_size);

  if(isset($last_body)){
    $body = substr($response, $header_size);
    $b_temp = json_decode($body, true);
    $body = json_encode(array_merge_recursive($last_body,$b_temp));
//      echo '<pre>';
//      print_r(json_decode($body));
//      echo '</pre>';

//    echo $body;
  }else{
    $body = substr($response, $header_size);
//      echo '$body<pre>';
  //    print_r(json_decode($body));
  //    echo '</pre>';
  }


  curl_close($curl);

  if ($err) {
    return "cURL Error #:" . $err;
  } else {
    if ($info['http_code'] == "429"){
      sleep(10);
      GET($CURLOPT_URL,$authId);
    }else{
//      echo '<pre>';
//      print_r($header_text);
//      echo '</pre>';
      foreach (explode("\r\n", $header_text) as $i => $line){
        if (!empty($line)){
//          echo $i.' => '.$line.'<br>';

          if ($i === 0){
              $headers['http_code'] = $line;
          }else{

            list ($key, $value) = explode(': ', $line);

            $headers[$key] = $value;

          }
        }
      }
      if (isset($headers['Link'])){
        $link = str_replace('<','',str_replace('>; rel="next"','',$headers['Link']));
//        echo $link;
        return GET(array($link,$body),$authId);
      }else{
//            echo '$body<pre>';
//            print_r($body);
//            echo '</pre>';
//        echo 'Done';
        return $body;
      }
    }
  }
}

function GET_FILE_NAME($CURLOPT_URL,$authId){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $CURLOPT_URL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_HEADER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer ".$authId
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  $info = curl_getinfo($curl);

  curl_close($curl);

  if ($err) {
    return "cURL Error #:" . $err;
  } else {

      $headers = [];
      $output = rtrim($response);
      $data = explode("\n",$output);
      $headers['status'] = $data[0];
      array_shift($data);

      foreach($data as $part){

          //some headers will contain ":" character (Location for example), and the part after ":" will be lost, Thanks to @Emanuele
          $middle = explode(":",$part,2);

          //Supress warning message if $middle[1] does not exist, Thanks to @crayons
          if ( !isset($middle[1]) ) { $middle[1] = null; }

          $headers[trim($middle[0])] = trim($middle[1]);
      }

      $fileName = explode("filename=",$headers['Content-Disposition']);

    return urldecode(trim($fileName[1],'"'));
  }
}


function POST($CURLOPT_URL,$CURLOPT_POSTFIELDS,$authId){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $CURLOPT_URL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer ".$authId,
      "cache-control: no-cache",
      "content-type: application/json"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  $info = curl_getinfo($curl);

  curl_close($curl);

  if ($err) {
    $out = "cURL Error #:" . $err;
  } else {
    if ($info['http_code'] == "429"){
      sleep(10);
      POST($CURLOPT_URL,$CURLOPT_POSTFIELDS,$authId);
    }else{
      $response = json_decode($response);
      $out = $response;
      return $out;
    }
  }
  return $out;
}

function DELETE($CURLOPT_URL,$authId){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $CURLOPT_URL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "DELETE",
    CURLOPT_POSTFIELDS => "",
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer ".$authId,
      "cache-control: no-cache",
      "content-type: application/json"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  $info = curl_getinfo($curl);

  curl_close($curl);

  if ($err) {
    return "cURL Error #:" . $err;
  } else {
    if ($info['http_code'] == "429"){
      sleep(10);
      DELETE($CURLOPT_URL,$authId);
    }else{
      //echo $response;
      return json_decode($response, true);
    }
  }
}

function PUT($CURLOPT_URL,$CURLOPT_POSTFIELDS,$authId){

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $CURLOPT_URL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer ".$authId,
      "cache-control: no-cache",
      "content-type: application/json"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  $info = curl_getinfo($curl);

  curl_close($curl);

  if ($err) {
    return "cURL Error #:" . $err;
  } else {
    if ($info['http_code'] == "429"){
      sleep(10);
      PUT($CURLOPT_URL,$CURLOPT_POSTFIELDS,$authId);
    }else{
      //echo $response;
      return json_decode($response, true);
    }
  }
}
?>
