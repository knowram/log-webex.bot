<?php
/*
{
  "id": "Y2lzY29zcGFyazovL3VzL1dFQkhPT0svMzE5MGFhY2ItNTAxNS00NmQ0LTlmNTQtMTk5ODFjNGNiZDYy",
  "name": "AddedToSpace",
  "targetUrl": "https://bots.wxteams.com/log/WH_AddedToSpace.php",
  "resource": "memberships",
  "event": "created",
  "orgId": "Y2lzY29zcGFyazovL3VzL09SR0FOSVpBVElPTi9jb25zdW1lcg",
  "createdBy": "Y2lzY29zcGFyazovL3VzL1BFT1BMRS8yZjNmYjVkYy0zZjhiLTRiYTMtODcwOS03MmE2NGE2Nzg0OWQ",
  "appId": "Y2lzY29zcGFyazovL3VzL0FQUExJQ0FUSU9OL0MzMmM4MDc3NDBjNmU3ZGYxMWRhZjE2ZjIyOGRmNjI4YmJjYTQ5YmE1MmZlY2JiMmM3ZDUxNWNiNGEwY2M5MWFh",
  "ownedBy": "creator",
  "status": "active",
  "created": "2020-07-07T17:14:17.138Z"
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
$files = $rawDataFromWebHook['data']['files'];

$json_array = array(
    'toPersonEmail'=> 'jacob.munson@gdt.com',
    'markdown'=> 'Jon entry:

    '.$rawDataFromWebHooktest
);
PostMessage($authId,$json_array);

if($personId == $bogId && $roomType == "group"){
  $json_array = array(
              'roomId'=> $roomId,
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
}

?>
