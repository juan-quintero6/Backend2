<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once("db.php");

    $name_lab = $_POST['name_lab'];
    $material_name = $_POST['material_name'];
    $amount = $_POST['amount'];

    // Consultar el id_lab asociado al name_lab
    $getIdLabQuery = "SELECT id_lab FROM laboratorios WHERE name_lab = '$name_lab'";
    $idLabResult = $mysql->query($getIdLabQuery);

    if ($idLabResult->num_rows > 0) {
        // Obtener el id_lab
        $row = $idLabResult->fetch_assoc();
        $id_lab = $row['id_lab'];

        // Verificar si el material ya existe en inventories
        $checkQuery = "SELECT * FROM inventories WHERE material_name = '$material_name'";
        $checkResult = $mysql->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            echo "El material ya se encuentra registrado";
        } else {
            // El material no existe, proceder con el registro
            $insertQuery = "INSERT INTO inventories (id_lab, material_name, amount) VALUES ('$id_lab', '$material_name', '$amount')";
            $insertResult = $mysql->query($insertQuery);

            if ($insertResult === true) {
                echo "Material creado exitosamente";
            } else {
                echo "Error en el registro: " . $mysql->error;
            }
        }
    } else {
        echo "No se encontró el laboratorio con el nombre proporcionado.";
    }

    $mysql->close();
}
?>
