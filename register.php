<?php
include 'dbConnection.php';

$accountId = $_POST['accountId'];
$password  = $_POST['password'];
$type      = $_POST['type'];

if (!($type == 'student' || $type == 'teacher') || $type == null) {
    $type = 'student';
}

if ($accountId == '' || $password == '') {
    header("http/1.1 400 Bad Request");
    $info = array(
        'state' => 400,
        'info'  => '账号/密码不能为空',
        'data'  => null,
    );
} else {
    $query = "SELECT id FROM user WHERE accountId = '$accountId'";
    $user = $pdo->query($query);
    if ($row = $user->fetch()) {
        header("http/1.1 400 Bad Request");
        $info = array(
            'state' => 400,
            'info'  => $accountId.'已经被注册',
            'data'  => null,
        );
    } else {
        $query = "INSERT INTO user(accountId, password, type) VALUE ('$accountId', '$password', '$type')";
        if ($pdo->query($query)) {
            $info = array(
                'state' => 200,
                'info'  => 'success',
                'data'  => '注册成功',
            );
        } else {
            header("http/1.1 400 Bad Request");
            $info = array(
                'state' => 400,
                'info'  => $pdo->errorInfo(),
                'data'  => null,
            );
        }
    }
}
echo json_encode($info);