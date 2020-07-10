<?php

/*
{
  "id": "Y2lzY29zcGFyazovL3VzL1dFQkhPT0svZGUyNDcxNGYtZGZiYy00NThiLWFmNjktZTMyMTA2MzgxMGFj",
  "name": "log_Webhook_Messages",
  "targetUrl": "https://bots.wxteams.com/log/WH_NewMessage.php",
  "resource": "messages",
  "event": "created",
  "orgId": "Y2lzY29zcGFyazovL3VzL09SR0FOSVpBVElPTi9jb25zdW1lcg",
  "createdBy": "Y2lzY29zcGFyazovL3VzL1BFT1BMRS8yZjNmYjVkYy0zZjhiLTRiYTMtODcwOS03MmE2NGE2Nzg0OWQ",
  "appId": "Y2lzY29zcGFyazovL3VzL0FQUExJQ0FUSU9OL0MzMmM4MDc3NDBjNmU3ZGYxMWRhZjE2ZjIyOGRmNjI4YmJjYTQ5YmE1MmZlY2JiMmM3ZDUxNWNiNGEwY2M5MWFh",
  "ownedBy": "creator",
  "status": "active",
  "created": "2020-07-07T12:18:33.622Z"
}
*/
require_once "Fn_botInfo.php";
require_once "Fn_webex.php";

$rawDataFromWebHook = json_decode(file_get_contents('php://input'), true);
$rawDataFromWebHooktest = file_get_contents('php://input');

//Get Data from webhook oci_fetch_object
$messageId = $rawDataFromWebHook['data']['id'];
$parentId = $rawDataFromWebHook['data']['parentId'];
$roomId = $rawDataFromWebHook['data']['roomId'];
$personEmail = $rawDataFromWebHook['data']['personEmail'];
$personId = $rawDataFromWebHook['data']['personId'];
$roomType = $rawDataFromWebHook['data']['roomType'];
$mentioned = $rawDataFromWebHook['data']['mentionedPeople'];
$joinedRoom = $rawDataFromWebHook['name'];
$WebHookCreatedBy = $rawDataFromWebHook['createdBy'];
if(isset($rawDataFromWebHook['data']['files'])){
  $files = json_encode($rawDataFromWebHook['data']['files']);
}
if($personId != $bogId){
  $GetMessageInfo = GetMessageInfo($authId, $messageId);
  if(substr( $GetMessageInfo->text, 0, 9 ) === "Log /help" || substr( $GetMessageInfo->text, 0, 8 ) === "Log help" || substr( $GetMessageInfo->text, 0, 8 ) === "Log/help"){
    $json_array = array(
                'roomId'=> $roomId,
                'parentId' => $parentId,
                'markdown'=> 'Hello,

You have items to track that might need responces or answers I can help.

@mention me [@Log] followed by a message you want to be tracked.

Then respond to the thread with the following / commands to add to the log entry

- /r  - to add a reply or responce
- /a  - to add an answer
- /close  - to close the log entry
- /delete - to delete the log entry

You can also interact with log entries outside the thread by including the log ID after ths / comand.

> Example: @Log /r 5 [responce message]'
            );

    PostMessage($authId,$json_array);

  }elseif(substr( $GetMessageInfo->text, 0, 6 ) === "Log /r" || substr( $GetMessageInfo->text, 0, 5 ) === "Log/r"){
    /**********************
      Respond to a Log Entry
    ***********************/

    if(isset($parentId)){
      // responding in thread
      //Seperate log entry number from message
      $message = substr($GetMessageInfo->text, 7);

      $sql = "SELECT `id` FROM `log_DB` WHERE `messageId` = '$parentId' ";
      if(!$Log_R = $db->query($sql)){
          die('There was an error running the query [' . $db->error . ']');
      }else{
        $Log = $Log_R->fetch_assoc();
        $sql = "INSERT INTO  `logReply` (
            `logM_id`,
            `messageId`,
            `files_URL`,
            `postUser`,
            `message`
            )
            values(
            '$Log[id]',
            '$messageId',
            '$files',
            '$personEmail',
            '$message'
            )";

        if ($db->query($sql) === TRUE) {
          $json_array = array(
                      'roomId'=> $roomId,
                      'parentId' => $parentId,
                      'markdown'=> '👍'
                  );

          PostMessage($authId,$json_array);

            $logID = $db->insert_id;
        } else {
          $json_array = array(
              'toPersonEmail'=> 'jacob.munson@gdt.com',
              'markdown'=> "Respond to Error: " . $sql . "<br>" . json_encode($db->error)
          );
          PostMessage($authId,$json_array);
        }
      }
    }else{
      // responding outside the thread
      //Seperate log entry number from message
      $message = substr($GetMessageInfo->text, 7);
      $message = substr(strstr($message," "), 1);
      $ret_ = explode(' ', $GetMessageInfo->text);

      // Verify the log entry exists
      $sql = "SELECT `postTime` FROM `log_DB` WHERE `id` = '$ret_[2]' ";
      if(!$Log_R = $db->query($sql)){
          die('There was an error running the query [' . $db->error . ']');
      }else{
        $Log = $Log_R->fetch_assoc();
        if(!empty($Log['postTime'])){
          // log entry found add reply to database
          $sql = "INSERT INTO  `logReply` (
              `logM_id`,
              `messageId`,
              `files_URL`,
              `postUser`,
              `message`
              )
              values(
              '$ret_[2]',
              '$messageId',
              '$files',
              '$personEmail',
              '$message'
              )";

          if ($db->query($sql) === TRUE) {
            $json_array = array(
                        'roomId'=> $roomId,
                        'parentId' => $parentId,
                        'markdown'=> '👍'
                    );

            PostMessage($authId,$json_array);

              $logID = $db->insert_id;
          } else {
            $json_array = array(
                'toPersonEmail'=> 'jacob.munson@gdt.com',
                'markdown'=> "Respond to Error: " . $sql . "<br>" . json_encode($db->error)
            );
            PostMessage($authId,$json_array);
          }
        }else{
          if(is_numeric($ret_[2])){
            // Log entry not found save to temp database and ask what to do.
            /*
            $sql = "INSERT INTO  `logTemp` (
                    `postUser`,
                    `message`
                    )
                    values(
                    '$personEmail',
                    '$message'
                    )";

            if ($db->query($sql) === TRUE) {
                $json_array = array(
                            'toPersonEmail'=> 'jacob.munson@gdt.com',
                            'markdown'=> 'New log entry:

                            '.$rawDataFromWebHooktest
                        );
                $logID = $db->insert_id;
            } else {
              $json_array = array(
                          'toPersonEmail'=> 'jacob.munson@gdt.com',
                          'markdown'=> "Error: " . $sql . "<br>" . json_encode($db->error)
                      );
            }
            */
            // send message to user asking what to do.
            $json_array = array(
                'toPersonEmail'=> $personEmail,
                'markdown'=> 'I didn\'t find an existing log entry with the id of '.$ret_[2].'please try again.'
            );
            PostMessage($authId,$json_array);
          }else{
            // responded without log ID
            $json_array = array(
                'toPersonEmail'=> $personEmail,
                'markdown'=> 'It looks like you just tried to respond to a log message without replying to the thread. Please delete your message and reply in the thread.'
            );
            PostMessage($authId,$json_array);
          }
        }
      }
    }
  }elseif(substr( $GetMessageInfo->text, 0, 6 ) === "Log /a" || substr( $GetMessageInfo->text, 0, 5 ) === "Log/a"){
    /**********************
      Answer a Log Entry
    ***********************/

    if(isset($parentId)){
      // responding in thread
      //Seperate log entry number from message
      $message = substr($GetMessageInfo->text, 7);

      $sql = "SELECT `id` FROM `log_DB` WHERE `messageId` = '$parentId' ";
      if(!$Log_R = $db->query($sql)){
          die('There was an error running the query [' . $db->error . ']');
      }else{
        $Log = $Log_R->fetch_assoc();

        $sql = "INSERT INTO  `logAnswer` (
            `logM_id`,
            `messageId`,
            `files_URL`,
            `postUser`,
            `message`
            )
            values(
            '$Log[id]',
            '$messageId',
            '$files',
            '$personEmail',
            '$message'
            )";

        if ($db->query($sql) === TRUE) {

            $sql = "UPDATE `log_DB` SET
          							`status`		=	'Answered'
          							WHERE
          							`messageId` = '$parentId';";

            $db->query($sql);

            $logID = $db->insert_id;
            $answered = 1;
        } else {
          $json_array = array(
              'toPersonEmail'=> 'jacob.munson@gdt.com',
              'markdown'=> "Answer Error: " . $sql . "<br>" . json_encode($db->error)
          );
          PostMessage($authId,$json_array);
        }
      }
    }else{
      //responding outside the thread
      //Seperate log entry number from message
      $message = substr($GetMessageInfo->text, 7);
      $message = substr(strstr($message," "), 1);
      $ret_ = explode(' ', $GetMessageInfo->text);

      // Verify the log entry exists
      $sql = "SELECT `messageId` FROM `log_DB` WHERE `id` = '$ret_[2]' ";
      if(!$Log_R = $db->query($sql)){
          die('There was an error running the query [' . $db->error . ']');
      }else{
        $Log = $Log_R->fetch_assoc();
        if(!empty($Log['messageId'])){
          // log entry found add reply to database
          $parentId = $messageId;

          $sql = "INSERT INTO  `logAnswer` (
              `logM_id`,
              `messageId`,
              `files_URL`,
              `postUser`,
              `message`
              )
              values(
              '$ret_[2]',
              '$messageId',
              '$files',
              '$personEmail',
              '$message'
              )";

          if ($db->query($sql) === TRUE) {

              $sql = "UPDATE `log_DB` SET
            							`status`		=	'Answered'
            							WHERE
            							`id` = '$ret_[2]';";

              $db->query($sql);
              $logID = $db->insert_id;
              $answered = 1;
          } else {
            $json_array = array(
                'toPersonEmail'=> 'jacob.munson@gdt.com',
                'markdown'=> "Error: " . $sql . "<br>" . json_encode($db->error)
            );
            PostMessage($authId,$json_array);
          }
        }else{
          // Log entry not found save to temp database and ask what to do.
          /*
          $sql = "INSERT INTO  `logTemp` (
                  `postUser`,
                  `message`
                  )
                  values(
                  '$personEmail',
                  '$message'
                  )";

          if ($db->query($sql) === TRUE) {
              $json_array = array(
                          'toPersonEmail'=> 'jacob.munson@gdt.com',
                          'markdown'=> 'New log entry:

                          '.$rawDataFromWebHooktest
                      );
              $logID = $db->insert_id;
          } else {
            $json_array = array(
                        'toPersonEmail'=> 'jacob.munson@gdt.com',
                        'markdown'=> "Error: " . $sql . "<br>" . json_encode($db->error)
                    );
          }
          */
          // send message to user asking what to do.
          $json_array = array(
              'toPersonEmail'=> $personEmail,
              'markdown'=> 'I didn\'t find an existing log entry with the id of '.$ret_[2].' please try again.'
          );
          PostMessage($authId,$json_array);
        }
      }
    }
    if(isset($answered)){
      // Post conformation message
      $json_array = array(
                  'roomId'=> $roomId,
                  'parentId' => $parentId,
                  'markdown'=> '**Answered** : Reply to thread with @log /close to close this log entry'
              );

      PostMessage($authId,$json_array);
    }
  }elseif(strpos($GetMessageInfo->text, '/close') === false){
    /**********************
      New Log Entry
    ***********************/
    $message = substr(strstr($GetMessageInfo->text," "), 1);
    $sql = "INSERT INTO  `log_DB` (
            `spaceId`,
            `messageId`,
            `files_URL`,
            `postUser`,
            `message`
            )
            values(
            '$roomId',
            '$messageId',
            '$files',
            '$personEmail',
            '$message'
            )";

    if ($db->query($sql) === TRUE) {
      $logID = $db->insert_id;
      // Post conformation message
      $json_array = array(
                  'roomId'=> $roomId,
                  'parentId' => $messageId,
                  'markdown'=> 'New log entry [id:'.$logID.'] was created [Click here for details](https://bots.wxteams.com/log/Log_index.php?spaceId='.$roomId.').
  Reply to the thread with : @log /r [your response] or @log /a [your answer].'
              );

      PostMessage($authId,$json_array);

    } else {
      $json_array = array(
          'toPersonEmail'=> 'jacob.munson@gdt.com',
          'markdown'=> "Close Error: " . $sql . "<br>" . json_encode($db->error)
      );
      PostMessage($authId,$json_array);
    }
  }

  /**********************
    Look for close log string
  ***********************/

  if(strpos($GetMessageInfo->text, '/close') !== false){

    if(isset($parentId)){
      // responding to thread
      $sql = "UPDATE `log_DB` SET
    							`status`		=	'Closed'
    							WHERE
    							`messageId` = '$parentId';";

      $db->query($sql);

      $json_array = array(
                  'roomId'=> $roomId,
                  'parentId' => $parentId,
                  'markdown'=> 'This log entry has been marked as closed.'
              );

      PostMessage($authId,$json_array);
    }else{
      //responding outside the thread
      //Seperate log entry number from message
      $ret_ = explode(' ', $GetMessageInfo->text);
      $sql = "UPDATE `log_DB` SET
    							`status`		=	'Closed'
    							WHERE
    							`id` = '$ret_[2]';";

      $db->query($sql);

      $json_array = array(
                  'roomId'=> $roomId,
                  'parentId' => $messageId,
                  'markdown'=> 'Log entry '.$ret_[2].' has been marked as closed.'
              );

      PostMessage($authId,$json_array);
    }

    if($GetMessageInfo->text == 'Log /close' || $GetMessageInfo->text == 'Log/close'){

      if(isset($parentId)){
        // responding in thread
        //Seperate log entry number from message
        $message = substr($GetMessageInfo->text, 3);

        $sql = "SELECT `id` FROM `log_DB` WHERE `messageId` = '$parentId' ";
        if(!$Log_R = $db->query($sql)){
            die('There was an error running the query [' . $db->error . ']');
        }else{
          $Log = $Log_R->fetch_assoc();

          $sql = "INSERT INTO  `logAnswer` (
              `logM_id`,
              `messageId`,
              `files_URL`,
              `postUser`,
              `message`
              )
              values(
              '$Log[id]',
              '$messageId',
              '',
              '$personEmail',
              '$message'
              )";

          if ($db->query($sql) === TRUE) {

          } else {
            $json_array = array(
                'toPersonEmail'=> 'jacob.munson@gdt.com',
                'markdown'=> "Answer Error: " . $sql . "<br>" . json_encode($db->error)
            );
            PostMessage($authId,$json_array);
          }
        }
      }else{
        $ret_ = explode(' ', $GetMessageInfo->text);
        $message = substr($GetMessageInfo->text, 3);
        $sql = "INSERT INTO  `logAnswer` (
            `logM_id`,
            `messageId`,
            `files_URL`,
            `postUser`,
            `message`
            )
            values(
            '$ret_[2]',
            '$messageId',
            '',
            '$personEmail',
            '$message'
            )";

        $db->query($sql);
      }

    }
  }

  $sql = "SELECT `id` FROM `LogMemberships` WHERE `personId` = '$personId' AND `spaceId` = '$roomId'";
  if(!$Membership_R = $db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
  }else{
    $Membership = $Membership_R->fetch_assoc();

    if(!isset($Membership['id'])){
      $sql = "INSERT INTO  `LogMemberships` (
          `personId`,
          `spaceId`
          )
          values(
          '$personId',
          '$roomId'
          )";

      $db->query($sql);
    }
  }

}
?>
