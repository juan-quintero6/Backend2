<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once("db.php");

    $name_lab = $_POST['name_lab'];
    $id_usuario = $_POST['id_usuario'];
    $date_reserva = $_POST['date_reserva'];

    // Consulta para obtener el ID del laboratorio por su nombre
    $query1 = "SELECT id_lab FROM laboratorios WHERE name_lab = '$name_lab'";
    $result1 = $mysql->query($query1);

    if ($result1) {
        if ($result1->num_rows > 0) {
            $row = $result1->fetch_assoc();
            $id_lab = $row['id_lab'];

            // Consulta para verificar si ya existe una reserva con el mismo id_lab y date_reserva
            $query3 = "SELECT * FROM reservas WHERE id_lab = '$id_lab' AND date_reserva = '$date_reserva'";
            $result3 = $mysql->query($query3);

            if ($result3->num_rows > 0) {
                echo "Ya existe la reserva";
            } else {
                // Consulta para insertar la reserva en la base de datos
                $query2 = "INSERT INTO reservas (id_usuario, id_lab, date_reserva) VALUES ('$id_usuario', '$id_lab', '$date_reserva')";
                $result2 = $mysql->query($query2);

                if ($result2 === true) {
                    echo "La reserva se creó exitosamente.";
                } else {
                    echo "Error al crear la reserva: " . $mysql->error;
                }
            }
        } else {
            echo "Laboratorio no encontrado";
        }
    } else {
        echo "Error en la consulta para obtener el ID del laboratorio: " . $mysql->error;
    }

    $mysql->close();
}
?>

