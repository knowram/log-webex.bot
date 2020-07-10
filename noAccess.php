<?php

  $tab_title = 'WxT Log';
  $page_title = 'Webex Teams Log Bot';

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


  include_once "materialize/header.php"; ?>

<main>
  <div class="container">

    <h1>Sorry you don't have access to this space</h1>
  </div>
</main>

<?php
  include_once "materialize/footer.php";
?>
