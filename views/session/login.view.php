 <?php $heading = "Iniciar Sesión"; ?>

 <!-- <?php require views('includes/nav.php') ?> -->

 <?php require views('includes/head.php') ?>



 <body class="bg-light">
    <div class="container mt-5" style="padding-top: 50px;">
    <div class="row">
        <div class="col-md-6">
            <div class="p-5 mb-4 rounded-3" style="margin-top: 50px;">
                <div class="card-header">
                    <h5 class="card-title fw-bold display-4">Iniciar sesión</h5>
                </div>
                <div class="card-body">
                    <form action="<?= Url('/login') ?>" method="post">
                        <?php csrfToken(); ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">¿Olvidaste tu contraseña?</small> <a href="<?= Url('/session/forgot') ?>">Recuperar contraseña</a>
                        </div>
                        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                    </form>
                </div>
            </div>
            
        </div>
        <div class="col-md-6">
            <img class="img-fluid rounded-3" src="<?= Url('/public\img\image.png') ?>" alt="" style="width: 100%; height: 100%;">
        </div>
    </div>
 </div>

</body>
