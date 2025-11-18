<!DOCTYPE html>
<html lang="es">

 <head>
    <?php $heading = "Error 403"; ?>
     <?php require views('/includes/head.php') ?>
 </head>

<body>
    <?php require views('/includes/nav.php') ?>
    <div class="error-page">
        <div class="error-container">
            <div class="error-title">403</div>
            <div class="error-subtitle">Acceso Denegado</div>
            <div class="error-message">
                No tienes los permisos necesarios para acceder a esta página.
            </div>
            
            <div class="error-actions">
                <a href="<?= Url('/') ?>" class="btn-error-primary">
                    <i class="fas fa-home"></i>
                    Volver al inicio
                </a>
                <a href="javascript:history.back()" class="btn-error-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Página anterior
                </a>
            </div>
        </div>
    </div>
</body>

</html>