<?php
    include_once './includes/autoloader.php';
    spl_autoload_register('myAutoLoader');

?>


<?php include './includes/header.php'; ?>
<section class = "main-content">
    <div class = "row jumbotron w-100 m-0 mt-3">
    
    <?php
    if ($user->isLoggedIn()) {
        echo '
            <div class = "col-lg-12 p-0 d-flex flex-column align-items-center">
                <h1 class = "title text-center">History</h1>
                <h4 class = "mt-5 w-75">Latest transaction</h4>
                <table id = "history" class = "w-75">
                    <tbody id = "history-tbody">
                    </tbody>
                </table>
            </div>
            ';
    } else {
        header('Location: index.php');
    }  ?>
    </div>
</section>
<script src = "./scripts/history.js"></script>