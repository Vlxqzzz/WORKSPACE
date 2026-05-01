<?php
require_once 'config/datos.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>♻️</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <header class="encabezado">
        <div class="header-container">
            <div class="logo">♻️</div>
            <div class="menu-toggle" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav class="navegacion">
                <a href="#inicio" onclick="closeMenu()">Inicio</a>
                <a href="#materiales" onclick="closeMenu()">Materiales</a>
                <a href="#como-funciona" onclick="closeMenu()">Cómo Funciona</a>
                <a href="#testimonios" onclick="closeMenu()">Testimonios</a>
                <a href="#conocenos" onclick="closeMenu()">Conócenos</a>
                <a href="#contacto" onclick="closeMenu()">Contacto</a>
                <a href="login.php" class="btn-nav">Iniciar Sesión</a>
                <a href="registro.php" class="btn-nav btn-registro">Registrarse</a>
            </nav>
        </div>
    </header>

    <div class="contenedor" style="margin-top: 70px;">

        <section class="hero" id="inicio">
            <div class="figuras">
                <div class="figura figura-1"></div>
                <div class="figura figura-2"></div>
                <div class="figura figura-3"></div>
            </div>
            <div class="hero-contenido">
                <h1 class="hero-titulo"><span>♻️</span> <?php echo $titulo; ?></h1>
                <p class="hero-descripcion"><?php echo $descripcion; ?></p>
                <div class="hero-btn-group">
                    <a href="#como-funciona" class="btn-principal">Comenzar Ahora</a>
                    <a href="#materiales" class="btn-secundario">Ver Materiales</a>
                </div>
            </div>
        </section>

        <section class="seccion-materiales" id="materiales">
            <h2 class="section-title">♻️ Materiales que Aceptamos</h2>
            <p class="section-subtitle">Reciclamos 4 tipos de materiales. ¡Cada uno vale 100 puntos por kilogramo!</p>
            <div class="materiales-grid">
                <div class="material-card">
                    <span class="material-icon">📦</span>
                    <div class="material-name">Cartón</div>
                    <div class="material-price">100 puntos/kg</div>
                </div>
                <div class="material-card">
                    <span class="material-icon">♻️</span>
                    <div class="material-name">Plástico</div>
                    <div class="material-price">100 puntos/kg</div>
                </div>
                <div class="material-card">
                    <span class="material-icon">🥫</span>
                    <div class="material-name">Aluminio</div>
                    <div class="material-price">100 puntos/kg</div>
                </div>
                <div class="material-card">
                    <span class="material-icon">📄</span>
                    <div class="material-name">Papel</div>
                    <div class="material-price">100 puntos/kg</div>
                </div>
            </div>
        </section>

        <section class="seccion-como-funciona" id="como-funciona">
            <h2 class="section-title">🚀 Cómo Funciona</h2>
            <p class="section-subtitle">Es muy fácil comenzar a reciclar y ganar recompensas</p>
            <div class="pasos-container">
                <div class="paso-card">
                    <div class="paso-numero">1</div>
                    <span class="paso-icon">📱</span>
                    <div class=" paso-title">Regístrate</div>
                    <p class=" paso-text">Crea tu cuenta gratuita en menos de 2 minutos y obtén 100 puntos de bienvenida.</p>
                </div>
                <div class="paso-card">
                    <div class="paso-numero">2</div>
                    <span class="paso-icon">🛒</span>
                    <div class=" paso-title">Recolecta</div>
                    <p class=" paso-text">Agrupa tus materiales reciclables: plástico, vidrio, metal, papel o cartón.</p>
                </div>
                <div class="paso-card">
                    <div class="paso-numero">3</div>
                    <span class="paso-icon">⚖️</span>
                    <div class=" paso-title">Pesa y Registra</div>
                    <p class=" paso-text">Pesa tus materiales y regístralos en tu panel de usuario.</p>
                </div>
                <div class="paso-card">
                    <div class="paso-numero">4</div>
                    <span class="paso-icon">🎁</span>
                    <div class=" paso-title">Canjea</div>
                    <p class=" paso-text">Convierte tus puntos en dinero, premios o descuentos en tiendas aliadas.</p>
                </div>
            </div>
        </section>

        <section class="seccion-estadisticas" id="beneficios">
            <div class="estadisticas">
                <div class="estadistica">
                    <span class="estadistica-numero">10,000+</span>
                    <span class="estadistica-texto">Kg Reciclados</span>
                </div>
                <div class="estadistica">
                    <span class="estadistica-numero">5,000+</span>
                    <span class="estadistica-texto">Usuarios Activos</span>
                </div>
                <div class="estadistica">
                    <span class="estadistica-numero">50+</span>
                    <span class="estadistica-texto">Comercios Aliados</span>
                </div>
            </div>
        </section>

        <section class="seccion-testimonios" id="testimonios">
            <h2 class="section-title">💬 Lo que dicen nuestros usuarios</h2>
            <p class="section-subtitle">Miles de personas ya están reciclando y ganando con nosotros</p>
            <div class="testimonios-grid">
                <div class="testimonio-card">
                    <p class="testimonio-texto">"Desde que descubrí Recicla Y Gana, mi familia separada todos los residuos. Ahora puedo canjear puntos por útiles escolares para mis hijos. ¡Excelente iniciativa!"</p>
                    <div class="testimonio-autor">
                        <div class="testimonio-avatar">👱🏻‍♀️</div>
                        <div>
                            <div class="testimonio-nombre">Samantha Correa</div>
                            <div class="testimonio-rol">Madre de familia</div>
                        </div>
                    </div>
                </div>
                <div class="testimonio-card">
                    <p class="testimonio-texto">"Tengo un pequeño negocio y antes tiraba mucho material reciclable. Ahora lo aprovecho y además gano dinero extra cada mes. Muy recomendado."</p>
                    <div class="testimonio-autor">
                        <div class="testimonio-avatar">👨🏽‍🦲</div>
                        <div>
                            <div class="testimonio-nombre">Carlos Guevara</div>
                            <div class="testimonio-rol">Comerciante</div>
                        </div>
                    </div>
                </div>
                <div class="testimonio-card">
                    <p class="testimonio-texto">"Mis hijos aprendieron la importancia de reciclaje gracias a esta app. Ahora toda la familia compite por ver quién recauda más puntos. ¡Muy divertido! Totalmente recomendado."</p>
                    <div class="testimonio-autor">
                        <div class="testimonio-avatar">👨🏿‍🦲</div>
                        <div>
                            <div class="testimonio-nombre">Milver Stiwar</div>
                            <div class="testimonio-rol">Profesor</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="seccion-conocenos" id="conocenos">
            <h2 class="section-title">👥 Conócenos</h2>
            <p class="section-subtitle">Somos 5 estudiantes de la I.E. José Miguel de Restrepo y Puerta comprometidos con el medio ambiente</p>
            <div class="equipo-grid">
                <div class="equipo-card">
                    <div class="equipo-foto">👨‍🎓</div>
                    <div class="equipo-nombre">Stiven Velásquez</div>
                    <div class="equipo-rol">Director de Proyecto</div>
                </div>
                <div class="equipo-card">
                    <div class="equipo-foto">👨‍🎓</div>
                    <div class="equipo-nombre">Steven Macías</div>
                    <div class="equipo-rol">Desarrollador Frontend</div>
                </div>
                <div class="equipo-card">
                    <div class="equipo-foto">👨‍🎓</div>
                    <div class="equipo-nombre">Adrian Mora</div>
                    <div class="equipo-rol">Desarrollador Backend</div>
                </div>
                <div class="equipo-card">
                    <div class="equipo-foto">👨‍🎓</div>
                    <div class="equipo-nombre">Carlos Herrera</div>
                    <div class="equipo-rol">Gestor de Contenido</div>
                </div>
                <div class="equipo-card">
                    <div class="equipo-foto">👨‍🎓</div>
                    <div class="equipo-nombre">Alexander Gómez</div>
                    <div class="equipo-rol">Analista de Datos</div>
                </div>
            </div>
        </section>

        <section class="seccion-cta">
            <div class="cta-section">
                <h2 class="cta-title">🌍 ¡Únete al cambio!</h2>
                <p class="cta-text">Cada kilogramo que reciclás ayuda al planeta y te da recompensas. El medio ambiente y tu bolsillo te lo agradecerán.</p>
                <a href="registro.php" class="btn-principal">Crear Cuenta Gratis</a>
            </div>
        </section>

        <footer class="pie" id="contacto">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>♻️ Recicla Y Gana</h4>
                    <p>Transformamos el reciclaje en una oportunidad para todos. Únete a nuestra comunidad y haz la diferencia.</p>
                </div>
                <div class="footer-section">
                    <h4>Enlaces Rápidos</h4>
                    <a href="#inicio">Inicio</a>
                    <a href="#materiales">Materiales</a>
                    <a href="#como-funciona">Cómo Funciona</a>
                    <a href="login.php">Iniciar Sesión</a>
                    <a href="registro.php">Registrarse</a>
                </div>
                <div class="footer-section">
                    <h4>Contacto</h4>
                    <p>📧 Contacto@reciclaygana.com</p>
                    <p>📞 +57 312 649 9865</p>
                    <p>📍 Copacabana, Antioquia</p>
                </div>
                <div class="footer-section">
                    <h4>Síguenos</h4>
                    <div class="social-links">
                        <span class="social-link">📘</span>
                        <span class="social-link">📸</span>
                        <span class="social-link">🐦</span>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2026 <?php echo $titulo; ?> - Unidos por un futuro más verde 🌍</p>
            </div>
        </footer>
    </div>
    <script>
        function toggleMenu() {
            document.querySelector('.navegacion').classList.toggle('active');
            document.querySelector('.menu-toggle').classList.toggle('active');
        }
        
        function closeMenu() {
            document.querySelector('.navegacion').classList.remove('active');
            document.querySelector('.menu-toggle').classList.remove('active');
        }
    </script>
</body>
</html>