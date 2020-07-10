<?php

define("DB_HOST", "localhost");
define("DB_NAME", "db");
define("DB_USER", "user");
define("DB_PASS", 'pass');
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$authId = "OWI4ZDBlYWEtNzM3MS00M2M1LWI....NmNTItZDQ3_PF84_consumer";
$bogId = "Y2lzY29zcGFyazovL3Vz....zZjhiLTRiYTMtODcwOS03MmE2NGE2Nzg0OWQ";


$client_id = 'Ccf1789f7bc9b9eda238d8....3008057945b89a4aedff76ba27789a';
$Client_Secret = '9255855c73022b76ed8e31.....20e5b14bd0c1f19692f3';
$redirect_uri = urlencode('https://[your server]/log/Fn_oAuth.php');
?>
