<?php

// initialize and open database
require_once "includes/db.php";
$db = init_sqlite_db("db/site.sqlite", "db/init.sql");


// check login/logout params
require_once "includes/sessions.php";
$session_messages = array();
process_session_params($db, $session_messages);
