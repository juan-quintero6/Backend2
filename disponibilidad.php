<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Realiza la conexión a la base de datos (ajusta las credenciales)
    require_once("db.php");

    // Recibe la fecha y hora desde la solicitud POST
    $date_reserva = $_POST['date_reserva'];

    // Consulta SQL para verificar la disponibilidad
    $query = "SELECT * FROM reservas WHERE date_reserva = ?";
    $stmt = $mysql->prepare($query);
    $stmt->bind_param("s", $date_reserva);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Hay una reserva para la fecha y hora seleccionadas
        echo "No disponible";
    } else {
        // No hay reserva para la fecha y hora seleccionadas
        echo "Disponible";
    }

    $stmt->close();
    $mysql->close();
}
?>