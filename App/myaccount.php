
<?php include './includes/header.php'; ?>
<section class = "main-content">
    <div class = "row jumbotron w-100 m-0 mt-3">
    <?php
    if ($user->isLoggedIn()) {
        echo '
        <div class = "col-lg-12 p-0 d-flex flex-column align-items-center">
            <h1 class = "title text-center">My account</h1>
            <div class = "container w-50 m-0 p-0">
                <h4 class = "mt-5">Quick balance</h4>
                <hr />
                <div class = "account-info d-flex justify-content-between mb-3">
                    <span class ="">Left on your account </span>
                </div>
                <h4 class = "mt-5">Accounts</h4>
                <hr />
                <span class = ""><i>Transaction account</i></span>
                <div class = "account-info d-flex justify-content-between mb-3">
                    <span class ="">1234-1, 12345678-9</span>
                </div>
            </div>
        </div>
        ';
    } else {
        header('Location: index.php');
    }  ?>
    </div>
</section>
<script src = "./scripts/myaccount.js"></script>
