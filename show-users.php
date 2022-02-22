<?php

    include "lib/navigation.php";
    $username = se($_GET, "name", "", false);
    $stmt = $db->prepare("SELECT username FROM users WHERE username LIKE :name LIMIT 10");

    try {

        $stmt->execute([":name" => "%" . $username . "%"]);
        $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);


    } catch (PDOException $e){

        echo var_export($e);

    }

    foreach ($allUsers as $users){

        echo se($users, "username", "", false) . "<br>";

    }

?>