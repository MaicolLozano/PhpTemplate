<!DOCTYPE html>
<html lang="es" class="h-100">

 <head>
     <?php require views('includes/head.php') ?>
     <link rel="stylesheet" href="/css/admin-dashboard.css">
 </head>

<body class="h-100">
    <div class="h-100 d-flex flex-column">
        <?php require views('includes/nav.php') ?>

        <div class="container-fluid flex-grow-1 py-4">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                                <h1 class="h3 font-weight-semibold text-dark mb-3 mb-md-0"><?= $heading ?></h1>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="<?= Url('/admin/create') ?>" class="btn btn-primary action-btn">
                                        <svg class="mr-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Nuevo Admin
                                    </a>
                                    <a href="<?= Url('/params/admin') ?>" class="btn btn-success action-btn">
                                        <svg class="mr-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                        </svg>
                                        Base de Datos
                                    </a>
                                    <a href="<?= Url('/usabilidad') ?>" class="btn btn-info action-btn" style="background-color: #17a2b8;">
                                        <svg class="mr-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Usabilidad
                                    </a>
                                </div>
                            </div>

                            <!-- Estadísticas del Dashboard -->
                            <div class="dashboard-section">
                                <h2 class="h5 mb-3">Estadísticas Generales</h2>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div class="stat-card">
                                            <h3><?= $totalUsuarios ?></h3>
                                            <p>Total de Usuarios</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="stat-card">
                                            <h3><?= $usuariosActivos ?></h3>
                                            <p>Usuarios Activos</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="stat-card">
                                            <h3><?= $totalAdministradores ?></h3>
                                            <p>Administradores</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="stat-card">
                                            <h3><?= $sesionesActivas ?></h3>
                                            <p>Sesiones Activas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Acciones Rápidas -->
                            <div class="dashboard-section quick-actions">
                                <h2 class="h5 mb-3">Acciones Rápidas</h2>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <svg class="mx-auto mb-3" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                                </svg>
                                                <h5 class="card-title">Gestión de Usuarios</h5>
                                                <p class="card-text">Administrar usuarios del sistema.</p>
                                                <a href="<?= Url('/usuarios') ?>" class="btn btn-outline-primary">Ir a Usuarios</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <svg class="mx-auto mb-3" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                                <h5 class="card-title">Análisis de Usabilidad</h5>
                                                <p class="card-text">Revisar métricas de usabilidad.</p>
                                                <a href="<?= Url('/usabilidad') ?>" class="btn btn-outline-info">Ver Análisis</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <svg class="mx-auto mb-3" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                                <h5 class="card-title">Sesiones Activas</h5>
                                                <p class="card-text">Monitorear sesiones de usuario.</p>
                                                <a href="<?= Url('/sessions') ?>" class="btn btn-outline-warning">Ver Sesiones</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gestión de Administradores -->
                            <div class="dashboard-section">
                                <h2 class="h5 mb-3">Gestión de Administradores</h2>

                                <!-- Barra de búsqueda -->
                                <div class="mb-4">
                                    <form method="GET" class="search-form d-flex">
                                        <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Buscar por email..." class="form-control">
                                        <button type="submit" class="btn btn-primary">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                <?php if (empty($administradores)) : ?>
                                    <div class="empty-state text-center">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        <h3 class="h5 mt-3 text-muted">No hay administradores</h3>
                                        <p class="text-muted">Comienza creando un nuevo administrador.</p>
                                        <div class="mt-4">
                                            <a href="<?= Url('/admin/create') ?>" class="btn btn-primary">Crear Administrador</a>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="row">
                                        <?php foreach ($administradores as $admin) : ?>
                                            <div class="col-md-6 col-lg-4 mb-4">
                                                <div class="card admin-card h-100">
                                                    <div class="card-body d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h5 class="card-title h6">ID: <?= $admin['id'] ?></h5>
                                                            <p class="card-text text-muted small"><?= $admin['usuario'] ?? $admin['email'] ?></p>
                                                        </div>
                                                        <div class="d-flex flex-column flex-sm-row gap-2">
                                                            <a href="<?= Url('/admin/edit?id=' . $admin['id']) ?>" class="btn btn-warning btn-sm action-btn">
                                                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mr-1">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                                </svg>
                                                                Editar
                                                            </a>
                                                            <form action="<?= Url('/admin/delete') ?>" method="POST" onsubmit="return confirm('¿Eliminar este administrador?')" class="d-inline">
                                                                <input type="hidden" name="id" value="<?= $admin['id'] ?>">
                                                                <button type="submit" class="btn btn-danger btn-sm action-btn">
                                                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mr-1">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                    </svg>
                                                                    Eliminar
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require views('includes/footer.php') ?>
    </div>
</body>

</html>