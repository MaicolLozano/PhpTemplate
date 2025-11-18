<!DOCTYPE html>
<html lang="es" class="h-full bg-white">

<head>
    <?php views('includes/head.php') ?>
</head>

<body>
    <?php views('includes/nav.php') ?>

    <div class="container mx-auto px-4 py-8">
        <div class="form-container">
            <h1 class="text-2xl font-bold"><?= $heading ?></h1>
            
            <?php if (isset($errors['general'])) : ?>
                <div class="alert alert-danger mb-4" role="alert" style="background-color: var(--bs-red); color: white; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem;">
                    <?= $errors['general'] ?>
                </div>
            <?php endif; ?>
            
            <form class="row g-3" action="<?= Url('/admin/create') ?>" method="POST">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input 
                        type="text" 
                        id="nombre" 
                        name="nombre" 
                        class="form-control" 
                        required
                        placeholder="Ingrese el nombre"
                        value="<?= $_POST['nombre'] ?? '' ?>"
                    >
                    <?php if (isset($errors['nombre'])) : ?>
                        <p class="error-message"><?= $errors['nombre'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="apellido" class="form-label">Apellido:</label>
                    <input 
                        type="text" 
                        id="apellido" 
                        name="apellido" 
                        class="form-control" 
                        required
                        placeholder="Ingrese el apellido"
                        value="<?= $_POST['apellido'] ?? '' ?>"
                    >
                    <?php if (isset($errors['apellido'])) : ?>
                        <p class="error-message"><?= $errors['apellido'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email:</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control" 
                        required
                        placeholder="usuario@ejemplo.com"
                        value="<?= $_POST['email'] ?? '' ?>"
                    >
                    <?php if (isset($errors['email'])) : ?>
                        <p class="error-message"><?= $errors['email'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        required
                        placeholder="Mínimo 6 caracteres"
                        minlength="6"
                    >
                    <?php if (isset($errors['password'])) : ?>
                        <p class="error-message"><?= $errors['password'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Confirmar Contraseña:</label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        class="form-control" 
                        required
                        placeholder="Repita la contraseña"
                        minlength="6"
                    >
                    <?php if (isset($errors['confirm_password'])) : ?>
                        <p class="error-message"><?= $errors['confirm_password'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="nivel_acceso" class="form-label">Nivel de Acceso:</label>
                    <select id="nivel_acceso" name="nivel_acceso" class="form-control" required>
                        <option value="usuario" <?= ($_POST['nivel_acceso'] ?? '') === 'usuario' ? 'selected' : '' ?>>Usuario</option>
                        <option value="admin" <?= ($_POST['nivel_acceso'] ?? '') === 'admin' ? 'selected' : '' ?>>Administrador</option>
                        <option value="superadmin" <?= ($_POST['nivel_acceso'] ?? '') === 'superadmin' ? 'selected' : '' ?>>Super Administrador</option>
                    </select>
                    <?php if (isset($errors['nivel_acceso'])) : ?>
                        <p class="error-message"><?= $errors['nivel_acceso'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="activo" 
                            value="1" 
                            <?= isset($_POST['activo']) ? 'checked' : 'checked' ?>
                        >
                        <label class="form-check-label">
                            Usuario Activo
                        </label>
                    </div>
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                    <a href="<?= Url('/admin') ?>" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <?php views('includes/footer.php') ?>
</body>

</html>
