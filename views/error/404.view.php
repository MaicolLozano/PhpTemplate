<!DOCTYPE html>
<html lang="es">

 <head>
    <?php $heading = "Error 404"; ?>
     <?php require views('/includes/head.php') ?>
 </head>

<body>
    <?php require views('/includes/nav.php') ?>
    <div class="error-page">
        <div class="error-container">
            <div class="error-title">404</div>
            <div class="error-subtitle">Página no encontrada</div>
            <div class="error-message">
                Lo sentimos, la página que estás buscando no existe o ha sido movida.
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