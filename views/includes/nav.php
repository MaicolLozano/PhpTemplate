<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= Url('/') ?>">
            <i class="fas fa-globe-americas me-2"></i>
            Michael <3
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= urlIs('/') ? 'active' : '' ?>" href="<?= Url('/') ?>">
                        <i class="fas fa-home me-1"></i>
                        Inicio
                    </a>
                </li>
                
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= urlIs('/app') ? 'active' : '' ?>" href="<?= Url('/app') ?>">
                            <i class="fas fa-desktop me-1"></i>
                            Aplicativos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= urlIs('/eframe') ? 'active' : '' ?>" href="<?= Url('/eframe') ?>">
                            <i class="fas fa-code me-1"></i>
                            eFrame
                        </a>
                    </li>
                    
                    <?php if (isset($_SESSION['user']['nivel_acceso']) && ($_SESSION['user']['nivel_acceso'] === 'admin' || $_SESSION['user']['nivel_acceso'] === 'superadmin')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cog me-1"></i>
                                Administración
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= Url('/params/admin') ?>">
                                    <i class="fas fa-list"></i>
                                    Parámetros
                                </a></li>
                                <li><a class="dropdown-item" href="<?= Url('/usabilidad') ?>">
                                    <i class="fas fa-chart-line"></i>
                                    Usabilidad
                                </a></li>
                                <?php if ($_SESSION['user']['nivel_acceso'] === 'superadmin'): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= Url('/admin') ?>">
                                        <i class="fas fa-users-cog"></i>
                                        Gestión de Usuarios
                                    </a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item dropdown user-menu">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar me-2">
                                <?= strtoupper(substr($_SESSION['user']['nombre'], 0, 1)) ?>
                            </div>
                            <span class="d-none d-md-inline">
                                <?= $_SESSION['user']['nombre'] ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <div class="dropdown-item-text">
                                    <div class="fw-bold"><?= $_SESSION['user']['nombre'] . ' ' . $_SESSION['user']['apellido'] ?></div>
                                    <small class="text-muted"><?= $_SESSION['user']['email'] ?></small>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= Url('/profile') ?>">
                                <i class="fas fa-user"></i>
                                Mi Perfil
                            </a></li>
                            <li><a class="dropdown-item" href="<?= Url('/settings') ?>">
                                <i class="fas fa-cog"></i>
                                Configuración
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="<?php echo Url("/logout") ?>" method="post">
                                <button class="dropdown-item" type="sudmit"  >Cerrar Sesion</button>
                            </form>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url('/login') ?>">
                            <i class="fas fa-sign-in-alt me-1"></i>
                            Iniciar Sesión
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
