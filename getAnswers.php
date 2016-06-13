<?php
include 'dbConnection.php';

$page       = $_POST['page'];
$count      = $_POST['count'];
$questionId = $_POST['questionId'];

$data = null;

$query = "SELECT answer.id             AS id,
                 answer.contentId      AS contentId,
                 answer.date           AS date,
                 answer.questionId     AS questionId,
                 answer.likeNumber     AS likeNumber,
                 answer.dislikeNumber  AS dislikeNumber,
                 user.nickName         AS authorName,
                 answerContent.content AS content
          FROM user, answer, answerContent
          WHERE answerContent.id = answer.contentId
            AND answer.authorId  = user.id
            AND answer.questionId = $questionId
          ORDER BY IFNULL (answer.likeNumber - answer.dislikeNumber, answer.date)
          DESC LIMIT ".($page * $count).",".$count;

$result = $pdo->query($query);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = array(
        'id'            => (int)$row['id'],
        'contentId'     => (int)$row['contentId'],
        'date'          => $row['date'],
        'questionId'    => (int)$row['questionId'],
        'likeNumber'    => (int)$row['likeNumber'],
        'dislikeNumber' => (int)$row['dislikeNumber'],
        'authorName'    => $row['authorName'],
        'content'       => $row['content'],
    );
}

$totalCount = $pdo->query("SELECT COUNT(*) AS count FROM answer WHERE questionId = $questionId")->fetch();

$info = array(
    'state'       => 200,
    'info'        => 'success',
    'totalCount'  => (int)$totalCount['count'],
    'totalPage'   => (int)($totalCount['count'] / $count) + 1,
    'currentPage' => (int)$page,
    'data'        => $data,
);

echo json_encode($info);