<?php
include 'dbConnection.php';
include 'token.php';

$accountId = $_POST['accountId'];
$password  = $_POST['password'];

$query = "SELECT * FROM user WHERE accountId = '{$accountId}'";
$result = $pdo->query($query);

if ($row = $result->fetch()) {
    if ($row['password'] == $password) {
        $row['token'] = create_unique($pdo, $row['id']);
        $info = array(
            'state' => 200,
            'info' => 'success',
            'data' => array(
                'id'       => (int)$row['id'],
                'type'     => $row['type'],
                'nickName' => $row['nickName'],
                'date'     => $row['date'],
                'sex'      => $row['sex'],
                'tel'      => $row['tel'],
                'email'    => $row['email'],
                'token'    => $row['token'],
            ),
        );
        if ($row['type'] == 'teacher') {
            if(!$pdo->query("SELECT id FROM teacher WHERE userId = ".(int)$row['id'])->fetch()) {
                $pdo->query("INSERT INTO teacher(userId) VALUES(".(int)$row['id'].")");
            }
        } else {
            if(!$pdo->query("SELECT id FROM student WHERE userId = ".(int)$row['id'])->fetch()) {
                $pdo->query("INSERT INTO student(userId) VALUES(".(int)$row['id'].")");
            }
        }
    } else {
        $info = array(
            'state' => 400,
            'info'  => 'wrongPassword',
            'data'  => null,
        );
    }
} else {
    $info = array(
        'state' => 400,
        'info'  => 'unRegister',
        'data'  => null,
    );
}

echo json_encode($info);
