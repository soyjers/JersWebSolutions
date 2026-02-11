<?php
// enviar.php - El motor de correo de Jers Web Solutions

// 1. Configuración
$destinatario = "contacto@jerswebsolutions.digital"; // TU CORREO REAL
$asunto = "🚀 Nuevo Lead Web: Jers Web Solutions";

// 2. Validación de seguridad
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Limpieza de datos (Evita hackeos básicos)
    $nombre = strip_tags(trim($_POST["nombre"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $servicio = strip_tags(trim($_POST["servicio"]));
    $mensaje = trim($_POST["mensaje"]);

    // Verificar campos vacíos
    if (empty($nombre) || empty($mensaje) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contacto?error=campos"); // Redirige si hay error
        exit;
    }

    // 3. Construir el Mensaje
    $contenido = "Has recibido un nuevo contacto:\n\n";
    $contenido .= "👤 Nombre: $nombre\n";
    $contenido .= "📧 Email: $email\n";
    $contenido .= "💼 Servicio: $servicio\n";
    $contenido .= "📝 Mensaje:\n$mensaje\n\n";
    $contenido .= "--- Fin del mensaje ---";

    // 4. Cabeceras
    $headers = "From: Web Jers <noreply@jerswebsolutions.digital>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // 5. Enviar y Redirigir
    if (mail($destinatario, $asunto, $contenido, $headers)) {
        header("Location: enviado"); // ÉXITO: Va a enviado.html (sin extensión)
    } else {
        echo "Error del servidor al enviar correo.";
    }

} else {
    header("Location: /"); // Si intentan entrar directo, mandar al inicio
}
?>