<?php

  require_once "Fn_oAuth.php";

  $tab_title = 'WxT Log';
  $page_title = 'Webex Teams Log Bot';

  if (isset($_COOKIE['SparkapiAccess_token'])){
    $me = GetMe($_COOKIE['SparkapiAccess_token']);
  }

  $sql = "SELECT `spaceId`, `messageId` FROM `log_DB` WHERE `id` = '$_GET[log_id]' ";
  if(!$Log_R = $db->query($sql)){
      die('There was an error running the query [' . $db->error . ']');
  }else{
    $Log = $Log_R->fetch_assoc();
  }

  $menu = '
  <li class="bold waves-effect active"><a class="collapsible-header">Pages<i class="material-icons chevron">chevron_left</i></a>
    <div class="collapsible-body">
      <ul>
        <li><a href="index.php" class="waves-effect active">Dashboard<i class="material-icons">web</i></a></li>
      </ul>
    </div>
  </li>

  <li class="bold waves-effect"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
    <div class="collapsible-body">
      <ul>
        <li><a href="Fn_oAuth.php?logout=out" class="waves-effect">Log out<i class="material-icons">person</i></a></li>
  <!--      <li><a href="settings.html" class="waves-effect">Settings<i class="material-icons">settings</i></a></li> -->
      </ul>
    </div>
  </li>';

/*******************************************************************************
		Save and Send responce to WxTeams
*******************************************************************************/

if(isset($_POST['submit'])){
  if(isset($_POST['type']) && $_POST['type'] == "answer"){
    $message = '<@personEmail:log@webex.bot|Log> /a '.$_POST['message'];
  }elseif(isset($_POST['type']) && $_POST['type'] == "closed"){
    $message = '<@personEmail:log@webex.bot|Log> /a '.$_POST['message'].' /close';
  }else{
    $message = '<@personEmail:log@webex.bot|Log> /r '.$_POST['message'];
  }


  if(!empty($_POST['fileName'])){
    $target_file = 'tempFiles/' . basename($_FILES["attachement"]["name"]);
    if (move_uploaded_file($_FILES["attachement"]["tmp_name"], $target_file)) {
      $json_array = array(
                  'roomId'=> $_POST['spaceId'],
                  'parentId' => $_POST['messageId'],
                  'files' => str_replace(" ","+",'https://bots.wxteams.com/log/tempFiles/'.$_POST['fileName']),
                  'markdown'=> $message
              );

      $testing = PostMessage($_COOKIE['SparkapiAccess_token'],$json_array);

      unlink($target_file);
    }
  }else{
    $json_array = array(
                'roomId'=> $_POST['spaceId'],
                'parentId' => $_POST['messageId'],
                'markdown'=> $message
            );

    $testing = PostMessage($_COOKIE['SparkapiAccess_token'],$json_array);
  }

  /*
  echo '<pre>';
  print_r($json_array);
  print_r($testing);
  print_r($_POST);
  echo '</pre>';
  */
}
/*******************************************************************************
		Start Page UI
*******************************************************************************/


  include_once "../materialize/header.php";

  ?>

<main>
  <div class="container">

<!-- Search -->
<div class="row">
  <div class="col s6">
    <a  href="Log_index.php?spaceId=<?php echo $Log['spaceId']; ?>" class="waves-effect waves-light btn"><i class="material-icons left">arrow_back</i>Back</a><br><br>
  </div>
</div>

<!-- Table -->
    <div class="row">
      <div class="col s12">
        <h3 class="section-title">Log Details</h3>
        <div class="card">
          <table id="example" class="row-border" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th width="15%">Post Time</th>
                <th width="40%">Message</th>
                <th width="20%">files</th>
                <th width="10%">Type</th>
                <th width="15%">Posted by</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Input -->
    <div class="row">
      <h3 class="section-title"> Respond to Log</h3>
      <form class="col s12" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="spaceId" value="<?php echo $Log['spaceId']; ?>">
        <input type="hidden" name="messageId" value="<?php echo $Log['messageId']; ?>">
        <div class="col s12 white z-depth-1">
          <form class="col s12" method="POST">
              <div class="input-field col s6"><br><br>
                <input name="message" id="message" type="text">
                <label for="message">Your Message</label>
              </div>
              <div class="input-field col s2">
                <p>
                  <label>
                    <input type="radio" name="type" value="answer"/>
                    <span>Mark as Answer</span>
                  </label>
                </p>
                <p>
                  <label>
                    <input type="radio" name="type" value="closed"/>
                    <span>Mark as Closed</span>
                  </label>
                </p>
              </div>
              <div class="input-field col s3">
                <div class="file-field input-field"><br>
                  <div class="btn">
                    <span>File</span>
                    <input type="file" name="attachement">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" name="fileName" type="text">
                  </div>
                </div>
              </div>
              <div class="col s1"><br><br>
                <button class="btn waves-effect waves-light" type="submit" name="submit" value="Post">Post
                  <i class="material-icons right">check</i>
                </button>
              </div>
          </form>
        </div>
      </form>
    </div>



  </div>
</main>

<?php
  include_once "../materialize/footer.php";
?>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

<script type="text/javascript" class="init">
var data = <?php echo json_encode($_GET) ?>;


$(document).ready(function() {
    var dataTable = $('#example').DataTable( {
      'ajax': {
        'url': 'Log_Detail_Data.php',
        'type': 'POST',
        'data': data
      },
      'language': {
          'search': '',
          'searchPlaceholder': 'Refine search',
          "emptyTable": "Your account doesn't have access to these messages",
          "loadingRecords": "Decoding Messages with your token..."
        },
        'order': [0, 'desc'],
        'dom': 'ft<"footer-wrapper"l<"paging-info"ip>>',
        'pagingType': 'full',
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );

    $("#search").keyup(function() {
        dataTable.search(this.value).draw();
    });

    $(".dataTables_filter").hide();
});




</script>
