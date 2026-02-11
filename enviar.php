<?php
// Configuración
$destinatario = "contacto@jerswebsolutions.digital";
$asunto_base = "🚀 Nuevo Lead Web: Jers Web Solutions";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Limpieza y Validación
    $nombre = strip_tags(trim($_POST["nombre"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $servicio = strip_tags(trim($_POST["servicio"]));
    $mensaje = trim($_POST["mensaje"]);

    if (empty($nombre) || empty($mensaje) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contacto?error=true");
        exit;
    }

    // Construcción del Mensaje (HTML para que se vea bonito en tu Gmail)
    $contenido = "
    <html>
    <head>
        <title>$asunto_base</title>
    </head>
    <body style='font-family: Arial, sans-serif; color: #333;'>
        <div style='background: #f4f4f4; padding: 20px; border-radius: 10px;'>
            <h2 style='color: #d4af37;'>Nuevo Mensaje de Contacto</h2>
            <p><strong>👤 Nombre:</strong> $nombre</p>
            <p><strong>📧 Email:</strong> $email</p>
            <p><strong>💼 Interés:</strong> $servicio</p>
            <hr style='border: 1px solid #ddd;'>
            <p><strong>📝 Mensaje:</strong><br>$mensaje</p>
            <br>
            <p style='font-size: 12px; color: #999;'>Enviado desde jerswebsolutions.digital</p>
        </div>
    </body>
    </html>
    ";

    // Cabeceras PRO (UTF-8 + Formato HTML)
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; // ¡Esto arregla los acentos!
    $headers .= "From: Web Notificaciones <noreply@jerswebsolutions.digital>" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";

    // Enviar
    if (mail($destinatario, $asunto_base, $contenido, $headers)) {
        header("Location: enviado");
    } else {
        header("Location: contacto?error=server");
    }

} else {
    header("Location: /");
}
?>