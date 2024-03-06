{{-- resources/views/emails/resetEmailPassword.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <title>Confirmación de Restablecimiento de Contraseña</title>

</head>
<body>
    <p>Hola {{ $user->name }},</p>

    <p>Tu contraseña ha sido restablecida con éxito.</p>

    <p>Si no realizaste esta acción, por favor contacta con nosotros de inmediato.</p>

    <p>Gracias por utilizar nuestro servicio.</p>

    <p>Saludos,<br>
    Tu aplicación</p>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
