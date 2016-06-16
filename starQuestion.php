<?php
include 'dbConnection.php';
include 'token.php';

$token = $_POST['token'];

$userId = checkToken($pdo, $token, $returnData);
if ($userId == -1) {
    echo json_encode($returnData);
    return;
}

$questionId = $_POST['questionId'];

$info = array(
    'state' => 400,
    'info' => '出了点小问题',
    'data' => null,
);

$selectStar = "SELECT id FROM starQuestion WHERE userId = $userId AND questionId = $questionId";
$star = $pdo->query($selectStar);
if ($row = $star->fetch()) {
    // 取消点赞
    $deleteStar = "DELETE FROM starQuestion WHERE id = ".(int)$row['id'];
    if ($pdo->query($deleteStar)) {
        $info = array(
            'state' => 200,
            'info' => 'success',
            'data' => array(
                'type'  => 'unStar',
                'count' => 0,
            ),
        );
    } else {
        $info['info'] = $pdo->errorInfo();
        echo json_encode($info);
        return;
    }
} else {
    // 点赞
    $insertStar = "INSERT INTO starQuestion(userId, questionId) VALUE ($userId, $questionId)";
    if ($pdo->query($insertStar)) {
        $info = array(
            'state' => 200,
            'info' => 'success',
            'data' => array(
                'type'  => 'star',
                'count' => 0,
            ),
        );
    } else {
        $info['info'] = $pdo->errorInfo();
        echo json_encode($info);
        return;
    }
}

$starContent = $pdo->query("SELECT COUNT(*) AS count FROM starQuestion WHERE questionId = $questionId")->fetch();
$pdo->query("UPDATE question SET starCount = ".$starContent['count']." WHERE id = $questionId");
$info['data']['count'] = (int)$starContent['count'];

echo json_encode($info);