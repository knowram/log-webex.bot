<?php
require_once "Fn_botInfo.php";
require_once "Fn_webex.php";

if(isset($_POST['log_id'])){

  $sql = "SELECT * FROM `log_DB` WHERE `id` = '$_POST[log_id]' ";
  if(!$Log_R = $db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
  }else{
    while($Log = $Log_R->fetch_assoc()){
      $message = GetMessageInfo($_COOKIE['SparkapiAccess_token'],$Log['messageId']);
      if(isset($message->text)){

        $messageText = str_replace("Log","",$message->text);
        unset($files);
        if($Log['files_URL'] != ""){
          $filesAttached = json_decode($Log['files_URL']);
          $files = '';
          foreach ($filesAttached as $value) {
            $fileName = GET_FILE_NAME($value,$_COOKIE['SparkapiAccess_token']);
            $flieLink = '<a href="GET_File.php?Name='.$fileName.'&URL='.$value.'" class="waves-effect"><i class="material-icons">attach_file</i>'.$fileName.'</a>';
            $files .= $flieLink.'<br>';
          }
        }
        if(isset($files)){
          $logEntries[] = array($Log['postTime'],$messageText,$files,'Reply',$Log['postUser']);
        }else{
          $logEntries[] = array($Log['postTime'],$messageText,'','Reply',$Log['postUser']);
        }
      }
    }
  }

  $sql = "SELECT * FROM `logReply` WHERE `logM_id` = '$_POST[log_id]' ";
  if(!$Log_R = $db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
  }else{
    while($Log = $Log_R->fetch_assoc()){
      $message = GetMessageInfo($_COOKIE['SparkapiAccess_token'],$Log['messageId']);
      if(isset($message->text)){
        //$messageText = substr($message->text, 7);
        $messageText = str_replace("Log /r","",$message->text);
        $messageText = str_replace("Log/r","",$messageText);
        unset($files);
        if($Log['files_URL'] != "" && !is_null($Log['files_URL'])){
          $filesAttached = json_decode($Log['files_URL']);
          $files = '';
          foreach ($filesAttached as $value) {
            $fileName = GET_FILE_NAME($value,$_COOKIE['SparkapiAccess_token']);
            $flieLink = '<a href="GET_File.php?Name='.$fileName.'&URL='.$value.'" class="waves-effect"><i class="material-icons">attach_file</i>'.$fileName.'</a>';
            $files .= $flieLink.'<br>';
          }
        }
        if(isset($files)){
          $logEntries[] = array($Log['postTime'],$messageText,$files,'Reply',$Log['postUser']);
        }else{
          $logEntries[] = array($Log['postTime'],$messageText,'','Reply',$Log['postUser']);
        }

      }
    }
  }

  $sql = "SELECT * FROM `logAnswer` WHERE `logM_id` = '$_POST[log_id]' ";
  if(!$Log_R = $db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
  }else{
    while($Log = $Log_R->fetch_assoc()){
      $message = GetMessageInfo($_COOKIE['SparkapiAccess_token'],$Log['messageId']);
      if(isset($message->text)){
        $messageText = str_replace("Log /a","",$message->text);
        $messageText = str_replace("Log/a","",$messageText);
        unset($files);
        if($Log['files_URL'] != ""){
          $filesAttached = json_decode($Log['files_URL']);
          $files = '';
          foreach ($filesAttached as $value) {
            $fileName = GET_FILE_NAME($value,$_COOKIE['SparkapiAccess_token']);
            $flieLink = '<a href="GET_File.php?Name='.$fileName.'&URL='.$value.'" class="waves-effect"><i class="material-icons">attach_file</i>'.$fileName.'</a>';
            $files .= $flieLink.'<br>';
          }
        }
        if(strpos($messageText, '/close') !== false){
          $type = 'Closed';
        } else{
          $type = 'Answer';
        }
        if(isset($files)){
          $logEntries[] = array($Log['postTime'],$messageText,$files,$type,$Log['postUser']);
        }else{
          $logEntries[] = array($Log['postTime'],$messageText,'',$type,$Log['postUser']);
        }
      }
    }
  }
}



// print data for table
if(isset($logEntries)){
  echo '{
    "data":';
  echo json_encode($logEntries);
  echo '}';
  }else{
  echo '{
    "sEcho": 1,
    "iTotalRecords": "0",
    "iTotalDisplayRecords": "0",
    "aaData": []
  }';
}
?>
