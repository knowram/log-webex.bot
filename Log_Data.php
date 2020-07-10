<?php
require_once "Fn_botInfo.php";
require_once "Fn_webex.php";
//$_POST['spaceId'] = 'Y2lzY29zcGFyazovL3VzL1JPT00vMDU1ODIyMDAtMmM4My0xMWU4LWI3MTEtNzFlZjYwZjI2NmI3';
//$_POST['term'] = 'Add';
if(isset($_POST['spaceId'])){



    $sql = "SELECT * FROM `log_DB` WHERE `spaceId` = '$_POST[spaceId]' ";
    if(!$Log_R = $db->query($sql)){
        die('There was an error running the query [' . $db->error . ']');
    }else{
      while($Log = $Log_R->fetch_assoc()){

        $message = GetMessageInfo($_COOKIE['SparkapiAccess_token'],$Log['messageId']);
        if(isset($message->text)){
          $messageText = substr(strstr($message->text," "), 1);
          $logEntries[] = array($Log['id'],$Log['postTime'],$messageText,$Log['postUser'],$Log['status'] ,'<a href="Log_Detail.php?log_id='.$Log['id'].'" class="waves-effect"><i class="material-icons">more_horiz</i></a>');
        }
      }
    }
  }else{

  }


/*
  $sql = "SELECT * FROM `log_DB` WHERE `spaceId` = '$_POST[spaceId]' ";

  if(isset($_POST['term']) && $_POST['term'] != ""){
    $term = '%'.$_POST['term'].'%';
    $sql .= "AND LOWER(message) like LOWER('$term') ";
  }

  if(isset($_POST['start_date']) && $_POST['start_date'] != ""){
    $start = date('Y-m-d', strtotime($_POST['start_date']));
    $sql .= " AND CAST(postTime AS Character(32)) >= '$start'";
  }
  if(isset($_POST['end_date']) && $_POST['end_date'] != ""){
    $end = date('Y-m-d', strtotime($_POST['end_date']));
    $sql .= " AND CAST(postTime AS Character(32)) <= '$end'";
  }

//echo $sql.'<br><br>';
  if(!$Log_R = $db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
  }else{
    while($Log = $Log_R->fetch_assoc()){
      $logEntries[] = array($Log['id'],$Log['postTime'],$Log['message'],$Log['postUser'],$Log['status'] ,'<a href="Log_Detail.php?log_id='.$Log['id'].'" class="waves-effect"><i class="material-icons">more_horiz</i></a>');
    }
  }
}else{

}

*/

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
