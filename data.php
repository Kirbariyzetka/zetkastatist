<?php
// Конфигурация подключения к базе данных
$host = 'mysql-ru-br1.joinserver.xyz';
$port = 3306;
$dbname = 's356629_players';
$username = 'u356629_6QiTqb5NvH';
$password = 'Ut@OMxu5jtooXhKvIlMAMec+';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    // Подключение к базе данных
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Запрос для получения данных игроков
    $stmt = $pdo->query("SELECT uuid, name, faction, class, stats, balance, kills, deaths FROM players");
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Возвращаем данные в формате JSON
    echo json_encode($players);
} catch (PDOException $e) {
    // В случае ошибки возвращаем сообщение об ошибке
    http_response_code(500);
    echo json_encode([
        'error' => 'Ошибка подключения к базе данных',
        'message' => $e->getMessage()
    ]);
}
?>