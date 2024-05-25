<?php

// Configuración de la base de datos
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'ntmax';

// Nombre del archivo de respaldo
$backupFileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';

// Comando para hacer la copia de seguridad
$command = "mysqldump --host=$host --user=$username --password=$password $database > $backupFileName";

// Ejecutar el comando y capturar la salida
$output = shell_exec($command);

// Verificar si la copia de seguridad se realizó correctamente
if ($output === null) {
    // Establecer las cabeceras para la descarga del archivo
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $backupFileName . '"');
    
    // Leer el archivo de respaldo y enviarlo al cliente
    readfile($backupFileName);
    
    // Eliminar el archivo de respaldo después de la descarga
    unlink($backupFileName);
    
    exit;
} else {
    // Si hubo un error al hacer la copia de seguridad, mostrar un mensaje de error
    http_response_code(500);
    echo 'Error al hacer la copia de seguridad';
}
