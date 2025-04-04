<?php

function conexion($servidor, $usuario, $contraseña, $bd)
{
    return mysqli_connect($servidor, $usuario, $contraseña, $bd);
}

$conexion = conexion("localhost", "root", "", "odontologia");
$sql = "SELECT * FROM Citas ";

$sql2 = "SELECT * FROM v_citas;";
$sql3 = "SELECT * FROM v_citas_avanzadas;";
$sql4 = "SELECT * FROM v_usuarios_roles;";
$sql5 = "SELECT * FROM v_cantidad_usuarios_por_rol;";
$sql6 = "SELECT * FROM v_usuarios_activos;";
$sql7 = "SELECT * FROM v_insumos_bajo_stock;";
$sql8 = "SELECT * FROM v_proveedores_insumos;";
$sql9 = "SELECT * FROM v_insumos_vencimiento;";
$sql10 = "SELECT * FROM v_cantidad_estado_citas;";
$sql11 = "SELECT * FROM v_estado_citas_pacientes;";
$sql12 = "SELECT * FROM v_paciente_historia_receta;";
$sql13 = "SELECT * FROM v_gestion_insumos;";

$resultado = mysqli_query($conexion, $sql3);
$datos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

header('Content-Type: application/json');

if (!empty($datos)) {
    echo json_encode($datos);
} else {
    echo json_encode(["error" => "No se encontraron datos."]);
}

?>