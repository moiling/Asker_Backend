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
// user
$nickName = $_POST['nickName'];
$sex      = $_POST['sex'];
$tel      = $_POST['tel'];
$email    = $_POST['email'];
$type     = $_POST['type'];
// student & teacher
$college  = $_POST['college'];
$academy  = $_POST['academy'];
// student
$year     = $_POST['year'];
$major    = $_POST['major'];
// teacher
$realName = $_POST['realName'];
// $authentication = $_POST['authentication']; 验证应该我们自己来……不能给他们机会

$info = array(
    'state' => 400,
    'info'  => '出了点小问题',
    'data'  => null,
);
if ($sex != 'female') {
    $sex = 'male';
}

$updateUser = "UPDATE user SET nickName = '$nickName', sex = '$sex', tel = '$tel', email = '$email' WHERE id = $userId";

if ($pdo->query($updateUser)) {

    if ($type == 'student') {
        $studentId = getStudentId($pdo, $userId, $returnData);
        if ($studentId == -1) {
            echo json_encode($returnData);
            return;
        }
        $update = "UPDATE student SET college = '$college', academy = '$academy', year = $year, major = '$major' WHERE id = $studentId";

    } else if ($type == 'teacher') {
        $teacherId = getTeacherId($pdo, $userId, $returnData);
        if ($teacherId == -1) {
            echo json_encode($returnData);
            return;
        }
        $update = "UPDATE teacher SET college = '$college', academy = '$academy', realName = '$realName' WHERE id = $teacherId";

    } else {
        $info['info'] = '你这账号的类型不对呀, 非法账号吧!';
        echo json_encode($info);
        return;
    }

    if ($pdo->query($update)) {
        $info = array(
            'state' => 200,
            'info'  => 'Success',
            'data'  => '资料更新成功',
        );
    } else {
        $info['info'] = $pdo->errorInfo();
    }
} else {
    $info['info'] = $pdo->errorInfo();
}

echo json_encode($info);