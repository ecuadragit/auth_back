{{-- resources/views/emails/recoveryEmailPassword.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Recuperación de cuenta</title>

    <!-- Add Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <p>Hola {{ $user->name }},</p>

    <p>Recibes este correo porque solicitaste la recuperación de tu cuenta.</p>

    <p>Para restablecer tu contraseña, haz clic en el siguiente enlace:</p>
    <a href="{{ route('resetPasswordView', ['token' => $token]) }}">Restablecer Contraseña</a>

    <p>Si no solicitaste esta recuperación, puedes ignorar este correo electrónico.</p>

    <p>Gracias,<br>
    Tu aplicación</p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

