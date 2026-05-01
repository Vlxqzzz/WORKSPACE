<?php
require_once 'config/db.php';
require_once 'config/auth.php';

$error = '';
$success = '';

if (isLoggedIn()) {
    redirect('dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = sanitize($_POST['nombre'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $telefono = sanitize($_POST['telefono'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($nombre) || empty($email) || empty($password)) {
        $error = 'Por favor completa todos los campos obligatorios';
    } elseif ($password !== $confirm_password) {
        $error = 'Las contraseñas no coinciden';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $error = 'El email ya está registrado';
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, telefono) VALUES (?, ?, ?, ?)");
            
            if ($stmt->execute([$nombre, $email, $passwordHash, $telefono])) {
                $success = '¡Registro exitoso! Ahora puedes iniciar sesión.';
            } else {
                $error = 'Error al registrar. Intenta de nuevo.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Recicla Y Gana</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700" rel="stylesheet">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <div class="auth-container">
        <a href="index.php" class="back-link">← Volver al inicio</a>
        <div class="auth-logo">
            <span>♻️</span>
            <h1>Recicla Y Gana</h1>
        </div>
        <h2 class="auth-title">Crear Cuenta</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="nombre">Nombre Completo <span class="required">*</span></label>
                <input type="text" id="nombre" name="nombre" placeholder="Tu nombre completo" required>
            </div>
            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" placeholder="tu@email.com" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono (opcional)</label>
                <input type="tel" id="telefono" name="telefono" placeholder="Tu número de teléfono">
            </div>
            <div class="form-group">
                <label for="password">Contraseña <span class="required">*</span></label>
                <input type="password" id="password" name="password" placeholder="Mínimo 6 caracteres" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmar Contraseña <span class="required">*</span></label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Repite tu contraseña" required>
            </div>
            <button type="submit" class="btn-auth">Crear Cuenta</button>
        </form>
        
        <div class="auth-footer">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
        </div>
    </div>
</body>
</html>