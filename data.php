<?php
// Конфигурация подключения к базе данных
$host = 'mysql-ru-br1.joinserver.xyz';
$port = 3306;
$dbname = 's356629_players';
$username = 'u356629_6QiTqb5NvH';
$password = 'Ut@OMxu5jtooXhKvIlMAMec+';

// Разрешаем CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

try {
    // Подключение к базе данных
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    // Запрос для получения данных игроков
    $stmt = $pdo->query("SELECT name, faction, class, balance, kills, deaths FROM players");
    
    // Получаем данные
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Возвращаем данные в формате JSON
    echo json_encode($players, JSON_UNESCAPED_UNICODE);
    
} catch (PDOException $e) {
    // Логируем ошибку
    error_log("Database error: " . $e->getMessage());
    
    // Возвращаем ошибку в JSON
    http_response_code(500);
    echo json_encode([
        'error' => 'Database connection failed',
        'message' => $e->getMessage()
    ]);
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}