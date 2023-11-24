<?php
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    require_once("db.php");

    $name_lab = $_REQUEST['name_lab'];
    $date_reserva = $_REQUEST['date_reserva'];

    // Consulta para obtener el ID del laboratorio por su nombre
    $query1 = "SELECT id_lab FROM laboratorios WHERE name_lab = '$name_lab'";
    $result1 = $mysql->query($query1);

    if ($result1) {
        if ($result1->num_rows > 0) {
            $row = $result1->fetch_assoc();
            $id_lab = $row['id_lab'];

            // Consulta para eliminar la reserva en la base de datos
            $query2 = "DELETE FROM reservas WHERE id_lab = '$id_lab' AND date_reserva = '$date_reserva'";
            $result2 = $mysql->query($query2);

            if ($result2 === true) {
                echo "Reserva eliminada exitosamente.";
            } else {
                echo "Error al eliminar la reserva: " . $mysql->error;
            }
        } else {
            echo "Laboratorio no encontrado";
        }
    } else {
        echo "Error en la consulta para obtener el ID del laboratorio: " . $mysql->error;
    }

    $mysql->close();
} else {
    // Si la solicitud no es DELETE, devolver un mensaje de error
    echo "Método no permitido. Se espera una solicitud DELETE.";
}
?>
