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

$page     = $_POST['page'];
$count    = $_POST['count'];

$data = null;

$query = "SELECT question.id             AS id,
                 question.contentId      AS contentId,
                 question.title          AS title,
                 question.date           AS date,
                 question.recent         AS recent,
                 question.type           AS type,
                 question.answerCount    AS answerCount,
                 question.bestAnswerId   AS bestAnswerId,
                 question.starCount      AS starCount,
                 user.nickName           AS authorName,
                 questionContent.content AS content
          FROM user, student, question, questionContent
          WHERE questionContent.id = question.contentId
            AND student.userId     = user.id
            AND question.authorId  = student.id
            AND user.id            = $userId
          ORDER BY IFNULL (recent, question.date)
          DESC LIMIT ".($page * $count).",".$count;

$result = $pdo->query($query);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $row['stared'] = false;
    if ($userId != null) {
        if ($stared = $pdo->query("SELECT id FROM starQuestion WHERE userId = $userId AND questionId = ".(int)$row['id'])->fetch()) {
            $row['stared'] = true;
        }
    }
    $data[] = array(
        'id'           => (int)$row['id'],
        'contentId'    => (int)$row['contentId'],
        'title'        => $row['title'],
        'date'         => $row['date'],
        'recent'       => $row['recent'],
        'type'         => $row['type'],
        'answerCount'  => (int)$row['answerCount'],
        'bestAnswerId' => (int)$row['bestAnswerId'],
        'starCount'    => (int)$row['starCount'],
        'authorName'   => $row['authorName'],
        'content'      => $row['content'],
        'stared'       => $row['stared'],
    );
}

$totalCount = $pdo->query("SELECT COUNT(*) AS count FROM question WHERE authorId = $authorId")->fetch();

$info = array(
    'state'       => 200,
    'info'        => 'success',
    'totalCount'  => (int)$totalCount['count'],
    'totalPage'   => (int)($totalCount['count'] / $count) + 1,
    'currentPage' => (int)$page,
    'data'        => $data,
);

echo json_encode($info);