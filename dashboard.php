<?php
require_once 'config/auth.php';
require_once 'config/db.php';
requireLogin();

$usuario_id = getUserId();

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch();

$stmt = $pdo->prepare("
    SELECT r.*, m.nombre as material_nombre, m.icon 
    FROM recolecciones r 
    JOIN materiales m ON r.material_id = m.id 
    WHERE r.usuario_id = ? 
    ORDER BY r.created_at DESC 
    LIMIT 10
");
$stmt->execute([$usuario_id]);
$recolecciones = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM materiales WHERE activo = TRUE");
$materiales = $stmt->fetchAll();

$total_recolectado = 0;
foreach ($recolecciones as $r) {
    if ($r['estado'] === 'completada') {
        $total_recolectado += $r['peso'];
    }
}

$stmt = $pdo->query("SELECT * FROM usuarios WHERE rol = 'usuario' ORDER BY puntos DESC LIMIT 10");
$ranking = $stmt->fetchAll();

$mis_puntos = $usuario['puntos'];
$ranking_posicion = 1;
if (!empty($ranking)) {
    foreach ($ranking as $r) {
        if ($r['id'] == $usuario_id) break;
        $ranking_posicion++;
    }
}

$premios = [
    ['nombre' => 'Bolsas Ecológicas', 'puntos' => 500, 'icon' => '🛍️'],
    ['nombre' => 'Botella Reutilizable', 'puntos' => 800, 'icon' => '🍶'],
    ['nombre' => 'Cuaderno Reciclado', 'puntos' => 300, 'icon' => '📓'],
    ['nombre' => 'Lápiz Ecológico', 'puntos' => 150, 'icon' => '✏️'],
    ['nombre' => 'Camiseta Eco', 'puntos' => 2000, 'icon' => '👕'],
    ['nombre' => 'Termo Social', 'puntos' => 1500, 'icon' => '☕'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Dashboard - Recicla Y Gana</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <header class="dashboard-header">
        <div class="logo-container">
            <span class="logo-emoji">♻️</span>
        </div>
        <nav class="dashboard-nav">
            <a href="#inicio" class="nav-link active">🏠 Inicio</a>
            <a href="#tienda" class="nav-link">🏪 Tienda</a>
            <a href="#ranking" class="nav-link">🏆 Ranking</a>
            <a href="#historial" class="nav-link">📋 Historial</a>
        </nav>
        <div class="user-info">
            <span class="user-greeting">Hola, <strong><?php echo htmlspecialchars($usuario['nombre']); ?></strong></span>
            <span class="user-puntos">🎯 <?php echo number_format($usuario['puntos']); ?> puntos</span>
            <?php if (isAdmin()): ?>
            <a href="admin.php" class="btn-admin">⚙️ Admin</a>
            <?php endif; ?>
            <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
        </div>
    </header>
    
    <div class="dashboard-container">
        <div class="welcome-section" id="inicio">
            <h1>¡Hola, <?php echo htmlspecialchars($usuario['nombre']); ?>! 👋</h1>
            <p>Gracias por cuidar el medio ambiente. Cada kilogramo cuenta.</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🎯</div>
                <div class="stat-value"><?php echo number_format($usuario['puntos']); ?></div>
                <div class="stat-label">Puntos Acumulados</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">♻️</div>
                <div class="stat-value"><?php echo number_format($total_recolectado, 1); ?> kg</div>
                <div class="stat-label">Material Recolectado</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🏆</div>
                <div class="stat-value">#<?php echo $ranking_posicion; ?></div>
                <div class="stat-label">Posición Ranking</div>
            </div>
        </div>

        <section class="dashboard-section" id="tienda">
            <h2 class="section-title">🏪 Tienda de Canjeo</h2>
            <p class="section-subtitle">Canjea tus puntos por premios increíbles</p>
            <div class="premios-grid">
                <?php foreach ($premios as $premio): ?>
                <div class="premio-card">
                    <div class="premio-icon"><?php echo $premio['icon']; ?></div>
                    <div class="premio-nombre"><?php echo $premio['nombre']; ?></div>
                    <div class="premio-puntos"><?php echo $premio['puntos']; ?> puntos</div>
                    <button class="btn-canje" <?php echo ($mis_puntos < $premio['puntos']) ? 'disabled' : ''; ?>>
                        <?php echo ($mis_puntos >= $premio['puntos']) ? 'Canjear' : 'No alcanza'; ?>
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="dashboard-section" id="ranking">
            <h2 class="section-title">🏆 Tabla de Clasificación</h2>
            <p class="section-subtitle">Los recicladores más activos del mes</p>
            <div class="ranking-container">
                <?php if (count($ranking) > 0): ?>
                <table class="ranking-table">
                    <thead>
                        <tr>
                            <th>Posición</th>
                            <th>Usuario</th>
                            <th>Puntos</th>
                            <th>kg Recyclados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $pos = 1;
                        foreach ($ranking as $r): 
                            $kg = $r['puntos'] / 100;
                        ?>
                        <tr class="<?php echo ($r['id'] == $usuario_id) ? 'mi-posicion' : ''; ?>">
                            <td>
                                <?php if($pos == 1): ?>🥇
                                <?php elseif($pos == 2): ?>🥈
                                <?php elseif($pos == 3): ?>🥉
                                <?php else: echo $pos; endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($r['nombre']); ?></td>
                            <td><?php echo number_format($r['puntos']); ?></td>
                            <td><?php echo number_format($kg, 1); ?> kg</td>
                        </tr>
                        <?php $pos++; endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="empty-message">No hay usuarios en el ranking aún. ¡Sé el primero!</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="dashboard-section" id="historial">
            <h2 class="section-title">📋 Mis Recolecciones</h2>
            <div class="historial-container">
                <?php if (count($recolecciones) > 0): ?>
                    <table class="historial-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Material</th>
                                <th>Peso</th>
                                <th>Puntos</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recolecciones as $r): ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($r['created_at'])); ?></td>
                                <td><?php echo $r['icon'] . ' ' . $r['material_nombre']; ?></td>
                                <td><?php echo number_format($r['peso'], 1); ?> kg</td>
                                <td>+<?php echo $r['puntos_ganados']; ?></td>
                                <td><span class="status status-<?php echo $r['estado']; ?>"><?php echo ucfirst($r['estado']); ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="empty-message">No tienes recolecciones aún. ¡Comienza a reciclar!</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="dashboard-section">
            <h2 class="section-title">♻️ Materiales que Aceptamos</h2>
            <div class="materiales-aceptados">
                <?php foreach ($materiales as $m): ?>
                <div class="material-item">
                    <span class="material-icon"><?php echo $m['icon']; ?></span>
                    <span class="material-nombre"><?php echo $m['nombre']; ?></span>
                    <span class="material-puntos"><?php echo $m['precio_kg']; ?> puntos/kg</span>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</body>
</html>