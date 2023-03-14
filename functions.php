<?php
  require("./data/db.php");

  function db_connect() {
    global $dbhost;
    global $dbuser;
    global $dbpass;
    global $dbname; 
    return mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  } 

?>