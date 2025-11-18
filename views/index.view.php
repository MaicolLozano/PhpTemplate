<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
 
    <?php require views('/includes/head.php') ?>
</head>

<body class="h-full">
    <?php require views('/includes/nav.php') ?>

    <main class="container">
        <!-- Interfaz completa -->
         <div class="p-5 mb-4 rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Custom jumbotron</h1>
                <p class="col-md-8 fs-4">
                    Using a series of utilities, you can create this jumbotron, just
                    like the one in previous versions of Bootstrap. Check out the
                    examples below for how you can remix and restyle it to your liking.
                </p>
                <button class="btn btn-primary btn-lg" type="button">
                    Example button
                </button>

                <!-- <?php foreach ($usuarios as $usuario) : ?>
                    <p><?php echo $usuario['nombre']; ?></p>
                <?php endforeach; ?> -->
            </div>
         </div> 
    </main>

    <?php require views('/includes/footer.php') ?>
</body>

</html>