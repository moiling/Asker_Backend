<?php

function getStudentId(PDO $pdo, $userId, &$returnData)
{
    $query = "SELECT id FROM student WHERE userId = $userId";

    $result = $pdo->query($query);
    if ($row = $result->fetch()) {
        return $row["id"];
    } else {
        header("http/1.1 401 Unauthorized");
        $returnData = array(
            'state' => 401,
            'info'  => '无效的UserId',
            'data'  => null,
        );
        return -1;
    }
}