<?php
    $id_usuario = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : null;

    if ($id_usuario === null) {
        throw new Exception("El parámetro 'id_usuario' es requerido.");
    }

    require_once("db.php");

    // Consulta preparada
    $query = "SELECT id_lab, date_reserva FROM reservas WHERE id_usuario = ?";
    $stmt = $mysql->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $id_usuario); // "s" indica que $id_usuario es una cadena

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            $response = "";

            while ($row = $result->fetch_assoc()) {
                $id_lab = $row['id_lab'];
                $date_reserva = $row['date_reserva'];

                // Consulta para obtener el nombre del laboratorio
                $query_lab = "SELECT name_lab FROM laboratorios WHERE id_lab = ?";
                $stmt_lab = $mysql->prepare($query_lab);

                if ($stmt_lab) {
                    $stmt_lab->bind_param("s", $id_lab);

                    if ($stmt_lab->execute()) {
                        $result_lab = $stmt_lab->get_result();
                        $row_lab = $result_lab->fetch_assoc();
                        $name_lab = $row_lab['name_lab'];

                        // Agregar el par clave-valor al resultado
                        $response .= "lab=" . $name_lab . "&date_reserva=" . $date_reserva . "&";
                    }

                    $stmt_lab->close();
                }
            }

            // Eliminar el último "&" del resultado
            $response = rtrim($response, "&");

            echo $response;
        } else {
            throw new Exception("Error en la ejecución de la consulta principal.");
        }

        $stmt->close();
    } else {
        throw new Exception("Error en la preparación de la consulta principal.");
    }

    $mysql->close();
?>
