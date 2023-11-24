<?php
    $name_lab = isset($_POST['name_lab']) ? $_POST['name_lab'] : null;

    if ($name_lab === null) {
        throw new Exception("El campo 'name_lab' es requerido.");
    }

    require_once("db.php");

    // Consulta preparada para obtener el id_lab correspondiente al name_lab
    $query = "SELECT id_lab FROM laboratorios WHERE name_lab = ?";
    $stmt = $mysql->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $name_lab); // "s" indica que $name_lab es una cadena

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            // Verificar si se encontró un laboratorio con el nombre proporcionado
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id_lab = $row['id_lab'];

                // Consulta para obtener solo el nombre del material correspondiente al id_lab
                $query_material = "SELECT material_name FROM inventories WHERE id_lab = ?";
                $stmt_material = $mysql->prepare($query_material);

                if ($stmt_material) {
                    $stmt_material->bind_param("s", $id_lab);

                    if ($stmt_material->execute()) {
                        $result_material = $stmt_material->get_result();

                        // Construir la respuesta como una lista de nombres de materiales
                        $response = "";

                        while ($row_material = $result_material->fetch_assoc()) {
                            $material_name = $row_material['material_name'];
                            $response .= $material_name . "\n";
                        }

                        echo $response;
                    } else {
                        throw new Exception("Error en la ejecución de la consulta de materiales.");
                    }

                    $stmt_material->close();
                } else {
                    throw new Exception("Error en la preparación de la consulta de materiales.");
                }
            } else {
                throw new Exception("No se encontró un laboratorio con el nombre proporcionado.");
            }
        } else {
            throw new Exception("Error en la ejecución de la consulta principal.");
        }

        $stmt->close();
    } else {
        throw new Exception("Error en la preparación de la consulta principal.");
    }

    $mysql->close();
?>
