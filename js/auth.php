<?php
// Устанавливаем заголовок для ответа в формате JSON
header('Content-Type: application/json; charset=utf-8');
session_start();

// Путь к защищенному файлу
$filePath = __DIR__ . '/data/users.dat';

// Функция для загрузки всех пользователей из файла
function loadUsers($path) {
    if (!file_exists($path)) return [];
    
    $json = file_get_contents($path);
    return json_decode($json, true) ?: [];
}

// Функция для сохранения массива пользователей в файл
function saveUsers($path, $users) {
    file_put_contents($path, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Получаем данные из POST-запроса
$login = trim($_POST['login'] ?? '');
$pass = $_POST['pass'] ?? '';
$action = $_POST['action'] ?? 'login'; // login или register

if (!$login || !$pass) {
    echo json_encode(['success' => false, 'message' => 'Заполните поля']);
    exit;
}

$users = loadUsers($filePath);

if ($action === 'register') {
    /* ========= РЕГИСТРАЦИЯ ========= */
    // Проверяем, занят ли логин
    foreach ($users as $user) {
        if ($user['login'] === $login) {
            echo json_encode(['success' => false, 'message' => 'Логин уже занят']);
            exit;
        }
    }
    
    // Создаем хеш пароля (самый важный этап)
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    
    // Сохраняем пользователя
    $users[] = [
        'login' => $login,
        'email' => '', 
        'password_hash' => $hash
    ];
    
    saveUsers($filePath, $users);
    echo json_encode(['success' => true]);

} elseif ($action === 'login') {
    /* ========= АВТОРИЗАЦИЯ ========= */
    foreach ($users as $user) {
        if ($user['login'] === $login) {
            // Сравниваем введенный пароль с хешем из файла
            if (password_verify($pass, $user['password_hash'])) {
                // Пароль верный
                $_SESSION['currentUser'] = ['login' => $login];
                echo json_encode(['success' => true]);
                exit;
            }
        }
    }
    
    // Если цикл закончился, а входа нет
    echo json_encode(['success' => false, 'message' => 'Неверный логин или пароль']);
}
?>