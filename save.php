<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once("db.php");

    $name = $_POST['name'];
    $user = $_POST['user'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    // Verifica si el usuario ya existe
    $checkQuery = "SELECT * FROM users WHERE user = '$user'";
    $checkResult = $mysql->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "El usuario ya existe";
    } else {
        // El usuario no existe, puedes proceder con el registro
        $insertQuery = "INSERT INTO users (name, user, password, user_type) VALUES ('$name', '$user', '$password', '$user_type')";
        $insertResult = $mysql->query($insertQuery);

        if ($insertResult === true) {
            if ($user_type === "Estudiante") {
                echo "El usuario se ha creado exitosamente como Estudiante";
            } elseif ($user_type === "Administrador") {
                echo "El usuario se ha creado exitosamente como Administrador";
            }
        } else {
            echo "Error en el registro: " . $mysql->error;
        }
    }
    $mysql->close();
}
?>
