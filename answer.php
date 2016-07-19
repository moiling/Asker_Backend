<?php
include 'dbConnection.php';
include 'token.php';

$token = $_POST['token'];
$authorId = checkToken($pdo, $token, $returnData);
if ($authorId == -1) {
    echo json_encode($returnData);
    return;
}

$questionId = $_POST['questionId'];
$content    = $_POST['content'];

$info = array(
    'state' => 400,
    'info' => '出了点小问题',
    'data' => null,
);

$pdo->query('START TRANSACTION');

$insertContent = "INSERT INTO answerContent(content)
                                    VALUES ('$content')";

if ($pdo->query($insertContent)) {
    $contentId = $pdo->lastInsertId();
    $insertAnswer = "INSERT INTO answer(authorId, contentId, questionId, date)
                                VALUES ($authorId, $contentId, $questionId, now())";
    if ($pdo->query($insertAnswer)) {
        $updateAnswerCount = "UPDATE question
                              SET answerCount = answerCount + 1, recent = now()
                              WHERE id = $questionId";
        $pdo->query($updateAnswerCount);
        $pdo->query('COMMIT');
        $info = array(
            'state' => 200,
            'info' => 'success',
            'data' => '回答成功',
        );
    } else {
        $pdo->query('ROLLBACK');
    }
} else {
    $pdo->query('ROLLBACK');
}
$pdo->query('END');

echo json_encode($info);