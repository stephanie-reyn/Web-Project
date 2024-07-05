<?php
if ($_SERVER['HTTP_HOST'] == 'users.multimediatechnology.at') {
    $DB_NAME = "fhs50557_wp";
    $DB_USER = "fhs50557";
    $DB_PASS = "baasQoPBVBTd";  // fill in password here!!
    $DSN = "pgsql:dbname=$DB_NAME;host=localhost";
} else {
    $DB_NAME = "report";
    $DB_USER = "postgres"; // fill in your local db-username here!!
    $DB_PASS = "pyrquj-Xovtyc-6xevva"; // fill in password here!!
    $DSN = "pgsql:dbname=$DB_NAME;host=localhost";
}
?>