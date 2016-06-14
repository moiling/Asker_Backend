<?php
include 'dbConnection.php';
include 'token.php';
include 'student.php';
include 'teacher.php';

$token = $_POST['token'];
$userId = checkToken($pdo, $token, $returnData);
if ($userId == -1) {
    echo json_encode($returnData);
    return;
}

$type = $_POST['type'];

$info = array(
    'state' => 400,
    'info' => '出了点小问题',
    'data' => null,
);

switch ($type) {
    case 'student':
        $query = "SELECT student.*, user.type, user.nickName, user.date, user.sex, user.tel, user.email
                  FROM student INNER JOIN user ON student.userId = user.id WHERE user.id = $userId";
        $result = $pdo->query($query);
        if ($row = $result->fetch()) {
            $info = array(
                'state' => 200,
                'info'  => 'Success',
                'data'  => array(
                    'id'        => (int)$row['userId'],
                    'type'      => $row['type'],
                    'nickName'  => $row['nickName'],
                    'date'      => $row['date'],
                    'sex'       => $row['sex'],
                    'tel'       => $row['tel'],
                    'email'     => $row['email'],
                    'token'     => $token,
                    'studentId' => (int)$row['id'],
                    'college'   => $row['college'],
                    'academy'   => $row['academy'],
                    'year'      => (int)$row['year'],
                    'major'     => $row['major'],
                )
            );
        } else {
            $info['info'] = $pdo->errorInfo();
        }
        break;
    case 'teacher':
        $query = "SELECT teacher.*, user.type, user.nickName, user.date, user.sex, user.tel, user.email
                  FROM teacher INNER JOIN user ON teacher.userId = user.id WHERE user.id = $userId";
        $result = $pdo->query($query);
        if ($row = $result->fetch()) {
            $info = array(
                'state' => 200,
                'info'  => 'Success',
                'data'  => array(
                    'id'             => (int)$row['userId'],
                    'type'           => $row['type'],
                    'nickName'       => $row['nickName'],
                    'date'           => $row['date'],
                    'sex'            => $row['sex'],
                    'tel'            => $row['tel'],
                    'email'          => $row['email'],
                    'token'          => $token,
                    'teacherId'      => (int)$row['id'],
                    'college'        => $row['college'],
                    'academy'        => $row['academy'],
                    'realName'       => $row['realName'],
                    'authentication' => $row['authentication'],
                )
            );
        } else {
            $info['info'] = $pdo->errorInfo();
        }
        break;
    default:
        $info['info'] = '你这账号的类型不对呀, 非法账号吧!';
        break;
}

echo json_encode($info);