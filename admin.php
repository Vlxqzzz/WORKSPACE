<?php
require_once 'config/auth.php';
require_once 'config/db.php';
requireAdmin();

$msg = '';
$msgTipo = '';
a
// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        // Establecer puntos exactos
        if ($_POST['accion'] === 'set_puntos') {
            $user_id = (int)$_POST['user_id'];
            $puntos = (int)$_POST['puntos'];
            
            $stmt = $pdo->prepare("UPDATE usuarios SET puntos = ? WHERE id = ?");
            if ($stmt->execute([$puntos, $user_id])) {
                $msg = 'Puntos actualizados correctamente';
                $msgTipo = 'success';
            }
        }
        
        // Agregar puntos
        if ($_POST['accion'] === 'agregar_puntos') {
            $user_id = (int)$_POST['user_id'];
            $puntos = (int)$_POST['puntos'];
            
            $stmt = $pdo->prepare("UPDATE usuarios SET puntos = puntos + ? WHERE id = ?");
            if ($stmt->execute([$puntos, $user_id])) {
                $msg = 'Puntos agregados correctamente';
                $msgTipo = 'success';
            }
        }
        
        // Restar puntos
        if ($_POST['accion'] === 'restar_puntos') {
            $user_id = (int)$_POST['user_id'];
            $puntos = (int)$_POST['puntos'];
            
            $stmt = $pdo->prepare("UPDATE usuarios SET puntos = GREATEST(0, puntos - ?) WHERE id = ?");
            if ($stmt->execute([$puntos, $user_id])) {
                $msg = 'Puntos restados correctamente';
                $msgTipo = 'success';
            }
        }
        
        // Eliminar usuario
        if ($_POST['accion'] === 'eliminar_usuario') {
            $user_id = (int)$_POST['user_id'];
            if ($user_id != $_SESSION['usuario_id']) {
                $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
                if ($stmt->execute([$user_id])) {
                    $msg = 'Usuario eliminado correctamente';
                    $msgTipo = 'success';
                }
            } else {
                $msg = 'No puedes eliminar tu propia cuenta';
                $msgTipo = 'error';
            }
        }
        
        // Editar material
        if ($_POST['accion'] === 'editar_material') {
            $material_id = (int)$_POST['material_id'];
            $nombre = sanitize($_POST['nombre']);
            $precio = (int)$_POST['precio'];
            $icon = sanitize($_POST['icon']);
            
            $stmt = $pdo->prepare("UPDATE materiales SET nombre = ?, precio_kg = ?, icon = ? WHERE id = ?");
            if ($stmt->execute([$nombre, $precio, $icon, $material_id])) {
                $msg = 'Material actualizado correctamente';
                $msgTipo = 'success';
            }
        }
        
        // Agregar material
        if ($_POST['accion'] === 'agregar_material') {
            $nombre = sanitize($_POST['nombre']);
            $precio = (int)$_POST['precio'];
            $icon = sanitize($_POST['icon']);
            
            $stmt = $pdo->prepare("INSERT INTO materiales (nombre, precio_kg, icon) VALUES (?, ?, ?)");
            if ($stmt->execute([$nombre, $precio, $icon])) {
                $msg = 'Material agregado correctamente';
                $msgTipo = 'success';
            }
        }
        
        // Eliminar material
        if ($_POST['accion'] === 'eliminar_material') {
            $material_id = (int)$_POST['material_id'];
            $stmt = $pdo->prepare("DELETE FROM materiales WHERE id = ?");
            if ($stmt->execute([$material_id])) {
                $msg = 'Material eliminado correctamente';
                $msgTipo = 'success';
            }
        }
    }
}

// Obtener datos actualizados
$stmt = $pdo->query("SELECT * FROM usuarios ORDER BY puntos DESC");
$usuarios = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM materiales ORDER BY id");
$materiales = $stmt->fetchAll();

$stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'usuario'");
$total_usuarios = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT SUM(puntos) as total FROM usuarios WHERE rol = 'usuario'");
$puntos_totales = $stmt->fetch()['total'] ?: 0;

$stmt = $pdo->query("SELECT COUNT(*) as total FROM recolecciones");
$total_recolecciones = $stmt->fetch()['total'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Admin - Recicla Y Gana</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <header class="admin-header">
        <div class="header-left">
            <span class="logo">🛠️ Panel de Admin</span>
        </div>
        <nav class="admin-nav">
            <a href="#general" class="nav-link active">⚙️ General</a>
        </nav>
        <div class="header-right">
            <span class="admin-name">Admin: <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
            <a href="dashboard.php" class="btn btn-secondary">Ver Mi Dashboard</a>
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </header>

    <div class="admin-container">
        <?php if ($msg): ?>
            <div class="alert alert-<?php echo $msgTipo; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>

        <!-- Estadísticas -->
        <section id="general" class="admin-section">
            <h2 class="section-title">📊 Estadísticas Generales</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-icon">👥</span>
                    <span class="stat-value"><?php echo $total_usuarios; ?></span>
                    <span class="stat-label">Usuarios Registrados</span>
                </div>
                <div class="stat-card">
                    <span class="stat-icon">🎯</span>
                    <span class="stat-value"><?php echo number_format($puntos_totales); ?></span>
                    <span class="stat-label">Puntos en Sistema</span>
                </div>
                <div class="stat-card">
                    <span class="stat-icon">♻️</span>
                    <span class="stat-value"><?php echo $total_recolecciones; ?></span>
                    <span class="stat-label">Recolecciones Totales</span>
                </div>
            </div>
        </section>

        <!-- Gestión de Usuarios -->
        <section id="general" class="admin-section">
            <h2 class="section-title">👥 Gestión de Usuarios - Puntos</h2>
            <div class="table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Puntos Actuales</th>
                            <th>Establecer</th>
                            <th>Agregar</th>
                            <th>Restar</th>
                            <th>Rol</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?php echo $u['id']; ?></td>
                            <td><?php echo htmlspecialchars($u['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td><span class="puntos-display"><?php echo number_format($u['puntos']); ?></span></td>
                            <td>
                                <form method="POST" class="puntos-form">
                                    <input type="hidden" name="accion" value="set_puntos">
                                    <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                                    <input type="number" name="puntos" value="<?php echo $u['puntos']; ?>" min="0">
                                    <button type="submit" class="btn-small btn-primary">✓</button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" class="puntos-form">
                                    <input type="hidden" name="accion" value="agregar_puntos">
                                    <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                                    <input type="number" name="puntos" min="1" placeholder="+">
                                    <button type="submit" class="btn-small btn-success">+</button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" class="puntos-form">
                                    <input type="hidden" name="accion" value="restar_puntos">
                                    <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                                    <input type="number" name="puntos" min="1" placeholder="-">
                                    <button type="submit" class="btn-small btn-warning">-</button>
                                </form>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo $u['rol']; ?>"><?php echo $u['rol']; ?></span>
                            </td>
                            <td>
                                <?php if ($u['id'] != $_SESSION['usuario_id']): ?>
                                <form method="POST" onsubmit="return confirm('¿Eliminar usuario <?php echo htmlspecialchars($u['nombre']); ?>?');">
                                    <input type="hidden" name="accion" value="eliminar_usuario">
                                    <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                                    <button type="submit" class="btn-small btn-danger">🗑️</button>
                                </form>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>