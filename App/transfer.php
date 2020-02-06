<?php

    include './includes/header.php';
    if (!$user->isLoggedIn()) {
        header('Location: index.php');
    }

    use Input\Input;
    use Token\Token;

    ?>

<section class = "main-content">
    <div class = "row jumbotron w-100 m-0 pt-5">
        <div class = "col-lg-12 p-0">
            <h1 class = "title text-center">Transfer</h1>
            <form action = "" class = "row justify-content-center flex-wrap w-75 m-auto" method = "POST" >
                <div class = "col-lg-6 mt-3">
                    <label for = "dropdownMenuPayments" class = "m-0 mt-3 mb-1">Payment methods</label>
                    <div class="dropdown m-0">
                        <button class="dropdown-toggle size" id="dropdownMenuPayments" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Select payment method
                        </button>
                        <div id = "payments" class="dropdown-menu w-100" aria-labelledby="dropdownMenuPayments">
                            <a class="dropdown-item" value = "SwishPayment">Swish</a>
                            <a class="dropdown-item" value = "AccountPayment">Bank account</a>
                        </div>
                    </div>
                    <label for = "phone-number" class = "phone-number m-0 mt-3 mb-1">Phone number</label>
                    <input id = "phone-number" class="form-control mr-sm-2 disabled" name = "phone-number">
                </div>
                <div class = "col-lg-6  mt-3">
                    <label class = "m-0 mt-3 mb-1">Receiver</label>
                    <div class="dropdown m-0">
                        <button class="dropdown-toggle size" id="dropdownMenuReceivers" type="submit" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Select receiver
                        </button>
                        <div id = "receivers" class="dropdown-menu w-100" aria-labelledby="dropdownMenuReceivers">
                        </div>
                    </div>
                    <div id = "phone-container" class = "hidden">
                        <label for = "receiver-phone" class = "phone-number m-0 mt-3 mb-1">Receiver phone number</label>
                        <input id = "receiver-phone" class="form-control mr-sm-2 disabled" name = "receiver-phone" placeholder = "Receiver phone number">
                    </div>
                    <label for = "amount" class = "m-0 mt-3 mb-1">Amount</label>
                    <input id = "amount"class="form-control mr-sm-2" type="number" name = "amount" placeholder="Enter amount" value = "<?php echo Input::get('amount'); ?>">
                </div>
                <input id = "paymentsHidden" type = "hidden" name = "payment_method">
                <input id = "receiverHidden" type = "hidden" name = "receiver">
                <input type = "hidden" name = "token" value = "<?php echo Token::generate(); ?>">
                <div id = "message" class = "pl-2 mt-3 w-100"></div>
                <button id = "transfer-btn" class="submit mt-4 mr-3 ml-3" type="submit">Transfer</button>
            </form> 
        </div>
    </div>
</section>
<script src = "./scripts/transfer.js"></script>