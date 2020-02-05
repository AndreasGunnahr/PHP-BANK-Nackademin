<?php
    include_once './includes/autoloader.php';
    spl_autoload_register('myAutoLoader');

    use Session\Session;

    ?>


<?php include './includes/header.php'; ?>
<section class = "main-content">
    <div class = "row jumbotron w-100 m-0 mt-3">
    <?php

    if ($user->isLoggedIn()) {
        header('Location: myaccount.php');
    } else {
        echo '
            <div class = "container d-flex flex-column justify-content-center align-items-center">
                <h1 class = "slogan">Lose Your Bank & Let’s Go!</h1>
                <span class = "text mb-3"><b>Easy transfer, easy life ~ <i>Andreas Gunnahr</b></i></span>
                <a href = "register.php" class = "btn create-account">Start now </a>
            </div>
        ';
    }
    if (Session::exists('success')) {
        $message = Session::flashMessage('success');
        echo "<h6 class = 'text-success'>{$message}</h6>";
    }
    ?>
    </div>
</section>