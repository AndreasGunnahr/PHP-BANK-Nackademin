<?php
include_once './includes/header.php';

use Input\Input;
use Token\Token;
use Validate\Validate;
use Session\Session;

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validate->check($_POST, array(
            'username' => array(
                'required' => true,
            ),
            'password' => array(
                'required' => true,
            ),
        ));

        if ($validate->passed()) {
            $login = $user->login(
                Input::get('username'),
                Input::get('password')
            );
            if ($login) {
                header('Location: myaccount.php');
            }
        } else {
            Session::flashMessage('error', $validate->error());
        }
    }
}
?>

<section class = "main-content">
    <div class = "jumbotron d-flex align-items-center m-0 p-0">
        <div class="container rounded w-75">
            <form action = "login.php" class="d-flex flex-column my-lg-0 pl-5 pr-5" method = "POST">
                <h1 class="register-title">Sign In</h1>
                <input class="form-control mr-sm-2 my-2" type="text" name = "username" placeholder="Username">
                <input class="form-control mr-sm-2 my-2" type="password" name = "password" placeholder="Password">
                <input type = "hidden" name = "token" value = "<?php echo Token::generate(); ?>">
                <?php
                if (Session::exists('error')) {
                    $message = Session::flashMessage('error');
                    echo "<h6 class = 'error text-danger'>{$message}</h6>";
                }
                ?>
                <button class="submit my-2" name = "register-submit" type="submit">Sign in</button>
            </form>
        </div>
    </div>
</section>