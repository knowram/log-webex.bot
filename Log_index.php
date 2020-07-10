<?php

  if(!empty($_POST)){
    $data = $_POST;
    $spaceId = $_POST['spaceId'];
  }elseif(isset($_GET['spaceId'])){
    setcookie('logSpaceId_token', $_GET['spaceId'], 0, '/');
    $data = $_GET;
    $spaceId = $_GET['spaceId'];
  }else{
    $data = array('spaceId' => $_COOKIE['logSpaceId_token']);
    $spaceId = $_COOKIE['logSpaceId_token'];
  }

  require_once "Fn_oAuth.php";
  //require_once "Fn_webex.php";

  $tab_title = 'WxT Log';
  $page_title = 'Webex Teams Log Bot';

  if (isset($_COOKIE['SparkapiAccess_token'])){
    $me = GetMe($_COOKIE['SparkapiAccess_token']);
    $room = GetRoomsInfo($_COOKIE['SparkapiAccess_token'],$spaceId);
    if(!isset($room->title)){
      header("Location: https://bots.wxteams.com/log/noAccess.php",TRUE,307); /* Redirect browser */
    }
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
		Start Page UI
*******************************************************************************/


  include_once "materialize/header.php";


?>

<main>
  <div class="container">

<!-- Search -->
    <div class="row">
    <!--  <form class="col s12" method="POST">
        <input type="hidden" name="spaceId" value="<?php echo $spaceId; ?>">-->
        <div class="col s12 white z-depth-1">
          <div class="input-field col s12">
            <i class="material-icons prefix">search</i>
            <input id="search" type="text" name="term" class="validate">
            <label for="search">Enter Space Separated Search </label>
          </div>
          <!--
          <div class="input-field col s2">
            <i class="material-icons prefix">date_range</i>
            <input id="start_date" name="start_date" type="text" class="datepicker">
            <label for="start_date">Start Date:</label><br>
          </div>
          <div class="input-field col s2">
            <i class="material-icons prefix">date_range</i>
            <input id="end_date" name="end_date" type="text" class="datepicker">
            <label for="end_date">End Date:</label>
          </div>
          <div class="input-field col s1" style="padding-top:8px;" >
            <input class="btn" type="submit" value="Search" name="search">
          </div>
          -->
        </div>
      <!-- </form> -->
    </div>


<!-- Table -->
    <div class="row">
      <div class="col s12">
        <?php
          if (!$_POST){
            echo '<h3 class="section-title">Log Entries For: <font color="orange">'.$room->title.'</font> Space</h3>';
          }else{
            echo '<h3 class="section-title">Search Results For: <font color="orange">'.$room->title.'</font> Space</h3></h3>';
          }
        ?>
        <div class="card">
          <table id="example" class="row-border" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th width="5%">ID</th>
                <th width="15%">Post Time</th>
                <th width="50%">Message</th>
                <th width="15%">Posted by</th>
                <th width="10%">Status</th>
                <th width="5%"></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>

      </div>
    </div>

  </div>
</main>

<?php
  include_once "materialize/footer.php";
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
var data = <?php echo json_encode($data) ?>;


$(document).ready(function() {
    var dataTable = $('#example').DataTable( {
      'ajax': {
        'url': 'Log_Data.php',
        'type': 'POST',
        'data': data
      },
      "columnDefs": [
        { "orderable": false, "targets": 5 }
      ],
      'language': {
          'search': '',
          'searchPlaceholder': 'Refine search',
          "emptyTable": "No matching data available",
          "loadingRecords": "Decoding Messages with your token..."
        },
        'order': [1, 'desc'],
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
