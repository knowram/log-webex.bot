<?php
require_once "Fn_botInfo.php";
require_once "Fn_webex.php";

//$_POST['id'] = 'Y2lzY29zcGFyazovL3VzL1BFT1BMRS8yYzgxM2VjNS05YWQ1LTQyZGItYTk2Zi0zNzdjNGY3MGU0MjM';

$sql = "SELECT * FROM `LogMemberships` WHERE `personId` = '$_POST[id]' ";

//echo $sql.'<br><br>';
if(isset($_POST['id'])){
  if(!$Spaces_R = $db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
  }else{
    while($Spaces = $Spaces_R->fetch_assoc()){
      $room = GetRoomsInfo($_COOKIE['SparkapiAccess_token'],$Spaces['spaceId']);
      $spaceEntries[] = array($room->title,'<a href="Log_index.php?spaceId='.$room->id.'" class="waves-effect"><i class="material-icons">more_horiz</i></a>');
    }
  }
}

// print data for table
if(isset($spaceEntries)){
  echo '{
    "data":';
  echo json_encode($spaceEntries);
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
