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
            
            <form class="row g-3" action="<?= Url('/admin/edit?id=' . $usuario['id']) ?>" method="POST">
                <input type="hidden" name="_method" value="PATCH">
                
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input 
                        type="text" 
                        id="nombre" 
                        name="nombre" 
                        class="form-control" 
                        required
                        placeholder="Ingrese el nombre"
                        value="<?= $_POST['nombre'] ?? $usuario['nombre'] ?>"
                    >
                    <?php if (isset($errors['nombre'])) : ?>
                        <div class="invalid-feedback d-block"><?= $errors['nombre'] ?></div>
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
                        value="<?= $_POST['apellido'] ?? $usuario['apellido'] ?>"
                    >
                    <?php if (isset($errors['apellido'])) : ?>
                        <div class="invalid-feedback d-block"><?= $errors['apellido'] ?></div>
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
                        value="<?= $_POST['email'] ?? $usuario['email'] ?>"
                    >
                    <?php if (isset($errors['email'])) : ?>
                        <div class="invalid-feedback d-block"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Nueva Contraseña (opcional):</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        placeholder="Dejar vacío para mantener la actual"
                        minlength="6"
                    >
                    <?php if (isset($errors['password'])) : ?>
                        <div class="invalid-feedback d-block"><?= $errors['password'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña:</label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        class="form-control" 
                        placeholder="Repita la nueva contraseña"
                        minlength="6"
                    >
                    <?php if (isset($errors['confirm_password'])) : ?>
                        <div class="invalid-feedback d-block"><?= $errors['confirm_password'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="nivel_acceso" class="form-label">Nivel de Acceso:</label>
                    <select id="nivel_acceso" name="nivel_acceso" class="form-control" required>
                        <option value="usuario" <?= ($_POST['nivel_acceso'] ?? $usuario['nivel_acceso']) === 'usuario' ? 'selected' : '' ?>>Usuario</option>
                        <option value="admin" <?= ($_POST['nivel_acceso'] ?? $usuario['nivel_acceso']) === 'admin' ? 'selected' : '' ?>>Administrador</option>
                        <option value="superadmin" <?= ($_POST['nivel_acceso'] ?? $usuario['nivel_acceso']) === 'superadmin' ? 'selected' : '' ?>>Super Administrador</option>
                    </select>
                    <?php if (isset($errors['nivel_acceso'])) : ?>
                        <div class="invalid-feedback d-block"><?= $errors['nivel_acceso'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="activo" 
                            value="1" 
                            <?= ($_POST['activo'] ?? $usuario['activo']) ? 'checked' : '' ?>
                        >
                        <label class="form-check-label">
                            Usuario Activo
                        </label>
                    </div>
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                    <a href="<?= Url('/admin') ?>" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <?php views('includes/footer.php') ?>
</body>

</html>