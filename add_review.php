<?php
session_start();
if (!isset($_SESSION['currentUser'])) {
    echo json_encode(['success' => false, 'message' => 'Требуется вход']);
    exit;
}

$filePath = __DIR__ . '/data/reviews.dat';

// Функции load/save те же...
$text = trim($_POST['text'] ?? '');
$userLogin = $_SESSION['currentUser']['login'];

if (!$text) {
    echo json_encode(['success' => false, 'message' => 'Пустой отзыв']);
    exit;
}

$reviews = loadData($filePath);

$reviews[] = [
    'id' => time(),
    'author' => $userLogin,
    'text' => htmlspecialchars($text),
    'date' => date('d.m.Y H:i')
];

saveData($filePath, $reviews);
echo json_encode(['success' => true]);
?>