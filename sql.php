<?php
// OK
$dsn="mysql:host=localhost;charset=utf8;dbname=20260426";
//建立PDO物件
$pdo=new PDO($dsn,'admin','1234');

$geturl = $_GET["do"] ?? '';

switch ($geturl){
    case 'getusers':
        $users = $pdo->query("select * from users")->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
        break;

    case "edituser":
        
        $sql = "UPDATE users SET username = :username, password = :password, role = :role WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $_POST['username'],
            ':password' => $_POST['password'],
            ':role'     => $_POST['role'],
            ':id'       => $_POST['id']
        ]);
        echo true;
        break;

    case "adduser":
        
        $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $_POST['username'],
            ':password' => $_POST['password'],
            ':role'     => $_POST['role']
        ]);
        echo true;
        break;

    case "deluser":
        if(isset($_GET["id"])){
            
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $_GET['id']]);
            echo true;
        }
        break;
}

// $dsn="mysql:host=localhost;charset=utf8;dbname=20260426";
// //建立PDO物件
// $pdo=new PDO($dsn,'admin','1234');

// $geturl = $_GET["do"];
// switch ($geturl){
//     case 'getusers':
//         $users = $pdo->query("select * from users")->fetchAll();
//         // print_r($users);
//         echo json_encode($users);
//         break;
//     case "edituser":
//         $user = $pdo->query("
//         update users set username='{$_POST['username']}',password='{$_POST['password']}',role='{$_POST['role']}'
//         where id = {$_POST['id']}
//         ");
//         echo true;
//         break;
//     case "adduser":
//         $user = $pdo->query("
//         insert into users set username='{$_POST['username']}',password='{$_POST['password']}',role='{$_POST['role']}'
//         where id = {$_POST['id']}
//         ");
//         echo true;
//         break;
//     case "deluser":
//         $user_id = $_GET["id"];
//         $pdo->query("DELETE FROM users WHERE id = $user_id");
//         echo true;
//         break;
// }