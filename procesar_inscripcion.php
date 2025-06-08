<?php
// Verifica si el archivo se ejecuta correctamente
if (!isset($_POST['nombre'], $_POST['correo'], $_POST['telefono'], $_POST['actividad'])) {
    die("Error: El formulario no se ha enviado correctamente.");
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "1234", "ceartbd");

// Verificación de error en la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Sanitizar y validar datos
$nombre = trim($_POST['nombre']);
$correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
$telefono = trim($_POST['telefono']);
$actividad = trim($_POST['actividad']);

if (!$correo) {
    die("Error: Correo electrónico no válido.");
}

if (empty($nombre) || empty($telefono) || empty($actividad)) {
    die("Error: Todos los campos son obligatorios.");
}

// Insertar datos
$sql = "INSERT INTO inscripcion (nombre, correo, telefono, actividad) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param("ssss", $nombre, $correo, $telefono, $actividad);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error al guardar los datos: " . $stmt->error;
}

// Cerrar conexiones
$stmt->close();
$conexion->close();
?>
