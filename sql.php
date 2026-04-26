<?php
$dsn="mysql:host=localhost;charset=utf8;dbname=20260426";
//建立PDO物件
$pdo=new PDO($dsn,'admin','1234');

// 修正 3：檢查 GET 參數是否存在，避免出現 Undefined array key 警告
$geturl = $_GET["do"] ?? '';

switch ($geturl){
    case 'getusers':
        $users = $pdo->query("select * from users")->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
        break;

    case "edituser":
        // 修正 2：使用 PDO 預處理語句防止 SQL Injection
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
        // 修正 1 & 2：移除錯誤的 where id 條件，並使用預處理語句安全地新增資料
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
            // 修正 2：刪除也改用預處理語句
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