<?php
include 'dbConnection.php';
include 'token.php';

$token = $_POST['token'];
$userId = checkToken($pdo, $token, $returnData);
if ($userId == -1) {
    echo json_encode($returnData);
    return;
}

$answerId = $_POST['answerId'];
$type = $_POST['type'];

$info = array(
    'state' => 400,
    'info' => 'error',
    'data' => null,
);
if (!($type == 'like' || $type == 'dislike') || $type == null) {
    $info['info'] = "类型错误";
    echo json_encode($info);
    return;
}

// TODO 妈蛋,没时间解释了,不做异常处理了

$pdo->query("DELETE FROM likeAnswer WHERE userId = $userId AND answerId = $answerId");
$pdo->query("DELETE FROM dislikeAnswer WHERE userId = $userId AND answerId = $answerId");

if ($type == 'like') {
    $pdo->query("INSERT INTO likeAnswer(userId, answerId) VALUE ($userId, $answerId)");
} else {
    $pdo->query("INSERT INTO dislikeAnswer(userId, answerId) VALUE ($userId, $answerId)");
}

$likeCount = $pdo->query("SELECT COUNT(*) AS count FROM likeAnswer WHERE answerId = $answerId")->fetch();
$dislikeCount = $pdo->query("SELECT COUNT(*) AS count FROM dislikeAnswer WHERE answerId = $answerId")->fetch();

$pdo->query("UPDATE answer SET likeNumber = ".$likeCount['count']." WHERE id = $answerId");
$pdo->query("UPDATE answer SET dislikeNumber = ".$dislikeCount['count']." WHERE id = $answerId");

$count = $likeCount['count'] - $dislikeCount['count'];

$info = array(
    'state' => 200,
    'info' => 'success',
    'data' => (int)$count,
);

echo json_encode($info);