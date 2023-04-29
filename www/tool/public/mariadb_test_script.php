<?php
ini_set("display_erros", 1);

try {
    $dbh = new PDO(
        "mysql:host=mariadb", 
        "root", 
        "password", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $dbh->query("drop database if exists TEST");

    $dbh->query("create database TEST");

    $dbh->query("use TEST");

    $dbh->query("create table test (id int, name varchar(255))");

    $dbh->query("insert into test (id, name) values (1, 'mysql日本語テスト')");

    $stmt = $dbh->query("select * from test");

    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    print_r($e->getMessage());
}