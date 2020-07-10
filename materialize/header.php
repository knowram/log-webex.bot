<?php
echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="">
    <title>u1Logic - '.$tab_title.'</title>
    <link href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="materialize/css/jqvmap.css" rel="stylesheet">
    <link href="materialize/css/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <!-- Fullcalendar-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.min.css" rel="stylesheet">
    <!-- Materialize-->
    <link href="materialize/css/admin-materialize.min.css" rel="stylesheet">
    <!-- Material Icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
      i.icon-red {
        color: red;
      }
      i.icon-green {
        color: green;
      }
      i.icon-black {
        color: black;
      }
    </style>
  </head>
  <body>
    <header>
      <div class="navbar-fixed">
        <nav class="navbar white">
          <div class="nav-wrapper"><a href="#!" class="brand-logo grey-text text-darken-4">'.$page_title.'</a>
            <ul id="nav-mobile" class="right">
              <!-- <li class="hide-on-med-and-down"><a href="">Support!</a></li> -->
              <li class="hide-on-med-and-down"><a href="#!" data-target="dropdown1" class="dropdown-trigger waves-effect"><i class="material-icons ';
              if(isset($messages)){echo 'icon-green';}
              if(isset($errors)){echo 'icon-red';}
              echo '">notifications</i></a></li>
              <!--<li><a href="#!" data-target="chat-dropdown" class="dropdown-trigger waves-effect"><i class="material-icons">settings</i></a></li>-->
            </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
          </div>
        </nav>
      </div>
      <ul id="sidenav-left" class="sidenav orange">
        <li><a href="" class="logo-container">'.$me->displayName.'<i class="material-icons left">spa</i></a></li>
        <li class="no-padding">
          <ul class="collapsible collapsible-accordion">

            '.$menu.'

          </ul>
        </li>
      </ul>
      <div id="dropdown1" class="dropdown-content notifications">
        <div class="notifications-title">notifications</div>
      </div>
    </header>';
?>
