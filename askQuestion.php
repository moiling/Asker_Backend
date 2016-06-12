<?php
include 'dbConnection.php';
include 'token.php';
include 'student.php';

$token = $_POST['token'];
$userId = checkToken($pdo, $token, $returnData);
if ($userId == -1) {
    echo json_encode($returnData);
    return;
}
$authorId = getStudentId($pdo, $userId, $returnData);
if ($authorId == -1) {
    echo json_encode($returnData);
    return;
}

$title   = $_POST['title'];
$content = $_POST['content'];
$type    = $_POST['type'];

$info = array(
    'state' => 400,
    'info' => '出了点小问题',
    'data' => null,
);

//$pdo->query('START TRANSACTION');

$insertContent = "INSERT INTO questionContent(content) VALUES ('{$content}')";

if ($pdo->query($insertContent)) {
    $contentId = $pdo->lastInsertId();
    $insertQuestion = "INSERT INTO question(authorId, contentId, title, type, recent, answerCount, starCount)
                       VALUES ({$authorId}, {$contentId}, '{$title}', '{$type}', now(), 0, 0)";
    if ($pdo->query($insertQuestion)) {
        //$pdo->query('COMMIT');
        $info = array(
            'state' => 200,
            'info' => 'success',
            'data' => '提问成功',
        );
    } else {
       // $pdo->query('ROLLBACK');
    }
} else {
   // $pdo->query('ROLLBACK');
}

//$pdo->query('END');

echo json_encode($info);
