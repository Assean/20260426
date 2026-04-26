<?php
$dsn="mysql:host=localhost;charset=utf8;dbname=20260426";
//建立PDO物件
$pdo=new PDO($dsn,'admin','1234');

$geturl = $_GET["do"];
switch ($geturl){
    case 'getusers':
        $users = $pdo->query("select * from users")->fetchAll();
        // print_r($users);
        echo json_encode($users);
        break;
    case "edituser":
        $user = $pdo->query("
        update users set username='{$_POST['username']}',password='{$_POST['password']}',role='{$_POST['role']}'
        where id = {$_POST['id']}
        ");
        
        break;
}