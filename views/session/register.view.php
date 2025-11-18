<?php 
require views('includes/head.php');?>
<body class="h-full">
    <div class="min-h-full">
        <?php require views('includes/nav.php') ?>
        <main class="container">
            <div class="p-5 mb-4 rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Registrarse</h1>
                    <p class="col-md-8 fs-4">
                        Llenar los siguientes campos para crear una cuenta en el sistema.
                    </p>
                    <form method="POST" action="<?= Url('/store') ?>">
                        <?php csrfToken(); ?>
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <button type="submit" class="btn btn-primary mt-3">Registrarse</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <?php require views('includes/footer.php') ?>
</body>

</html>
