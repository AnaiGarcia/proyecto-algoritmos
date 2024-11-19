<?php

include(__DIR__.'../../config/libs.php');

$dsn = sprintf(
    '%s:host=%s;port=%s;dbname=%s;',
    $_SERVER['DB_DRIVER'],
    $_SERVER['DB_HOST'],
    $_SERVER['DB_PORT'],
    $_SERVER['DB_NAME']
);

try {
    $dbh = new PDO(
        $dsn,
        $_SERVER['DB_USER'],
        $_SERVER['DB_PASS'],
        array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        )
    );
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
