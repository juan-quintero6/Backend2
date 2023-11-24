<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once("db.php");

    $user = $_POST['user'];
    $password = $_POST['password'];

    // Validación y limpieza de datos de entrada (implementar)

    $query = "SELECT id, user_type FROM users WHERE user = ? AND password = ?";
    $stmt = $mysql->prepare($query);
    $stmt->bind_param("ss", $user, $password);
    $stmt->execute();
    $stmt->bind_result($userId, $userType);
    $stmt->fetch();

    if (!empty($userId)) {
        // Las credenciales son válidas.
        if ($userType == 'Estudiante') {
            echo $userId;
        } elseif ($userType == 'Administrador') {
            echo "Administrador.";
        }
    } else {
        // Las credenciales son incorrectas.
        echo "Credenciales incorrectas";
    }

    $stmt->close();
    $mysql->close();
}
?>
