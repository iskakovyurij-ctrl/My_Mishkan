<?php
session_start();
if (!isset($_SESSION['currentUser'])) {
    echo json_encode(['success' => false, 'message' => 'Требуется вход']);
    exit;
}

$filePath = __DIR__ . '/data/items.dat';

function loadItems($path) { ... } // Ваша функция чтения
function saveItems($path, $items) { ... } // Ваша функция записи

$title = trim($_POST['title'] ?? '');
$price = intval($_POST['price'] ?? 0);
$userLogin = $_SESSION['currentUser']['login'];

if (!$title || !$price) {
    echo json_encode(['success' => false, 'message' => 'Введите данные']);
    exit;
}

$items = loadItems($filePath);

$items[] = [
    'id' => time(),
    'title' => $title,
    'price' => $price,
    'seller_login' => $userLogin, // ВАЖНО: Привязка к пользователю
    'date' => date('d.m.Y')
];

saveItems($filePath, $items);
echo json_encode(['success' => true]);
?>