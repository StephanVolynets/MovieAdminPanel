<?php

// initialize and open database
require_once "includes/db.php";
$db = init_sqlite_db("db/site.sqlite", "db/init.sql");
