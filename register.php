<!-- backend/register.php -->
<?php
require 'db.php'; // Asegúrate de que este archivo se conecte a tu base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash para seguridad

    // Verificar si el usuario ya existe
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'El usuario ya existe en TiKaPost']);
        exit;
    }

    // Insertar el nuevo usuario
    $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    if ($stmt->execute([$username, $password])) {
        echo json_encode(['success' => true, 'message' => 'Usuario registrado con éxito en TiKaPost']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar usuario en TiKaPost']);
    }
}
?>
