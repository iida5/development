<?php
ini_set("display_erros", 1);

try {
    $dbh = new PDO(
        "sqlsrv:server=mssql,1433;ConnectionPooling=0;Encrypt=no", 
        "sa", 
        "Password#1", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $dbh->query("drop database if exists TEST");

    $dbh->query("create database TEST");

    $dbh->query("use TEST");

    $dbh->query("create table test (id int, name varchar(255))");

    $dbh->query("insert into test (id, name) values (1, 'sqlsrv日本語テスト')");

    $stmt = $dbh->query("select * from test");

    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    print_r($e->getMessage());
}
