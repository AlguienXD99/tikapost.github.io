<?php
// login.php

// Conectar a la base de datos
$conn = new mysqli('localhost', 'username', 'password', 'database');

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Preparar la consulta para buscar el usuario
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Comprobar si el usuario existe
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Verificar la contraseña
    if (password_verify($password, $user['password'])) {
        echo json_encode(['status' => 'success', 'message' => 'Inicio de sesión exitoso.']);
        // Aquí puedes redirigir al usuario a otra página, como su perfil
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Contraseña incorrecta.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'El nombre de usuario no existe.']);
}

$stmt->close();
$conn->close();
?>
