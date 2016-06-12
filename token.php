<?php

function checkToken(PDO $pdo, $token, &$returnData)
{
    $query = "SELECT userId FROM token WHERE token = '" . $token . "'";

    $result = $pdo->query($query);
    if ($row = $result->fetch()) {
        return $row["userId"];
    } else {
        header("http/1.1 401 Unauthorized");
        $returnData = array(
            'state' => 401,
            'info'  => 'token:" . $token . " 无效',
            'data'  => null,
        );
        return -1;
    }
}

function create_unique(PDO $pdo, $id)
{
    $data = $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time().rand();
    $data = sha1($data);
    $pdo->query("DELETE FROM token WHERE userId = " . $id);
    $pdo->query("INSERT INTO token(token, userId) VALUES ('".$data."','".$id."')");
    return $data;
}