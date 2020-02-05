<?php
include './includes/header.php';
require_once './includes/autoloader.php';
spl_autoload_register('myAutoLoader');

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
                'unique' => 'users',
            ),
            'email' => array(
                'required' => true,
                'email' => true,
            ),
            'password' => array(
                'required' => true,
            ),
            're-password' => array(
                'required' => true,
                'matches' => 'password',
            ),
        ));

        if ($validate->passed()) {
            $user->create(array(
                Input::get('username'),
                Input::get('email'),
                password_hash(Input::get('password'), PASSWORD_DEFAULT),
            ));
            Session::flashMessage('success', 'Account successfully registered');
            header('Location: index.php');
        } else {
            Session::flashMessage('error', $validate->error());
        }
    }
}
?>

<section class = "main-content">
    <div class = "jumbotron d-flex align-items-center m-0 p-0">
        <div class="container rounded w-75">
            <form action = "" class="register_form d-flex flex-column my-lg-0 pl-5 pr-5" method = "POST">
                <h1 class="register-title">Register</h1>
                <input class="form-control mr-sm-2 my-2" type="text" name = "username" 
                placeholder="Username" value = "<?php echo Input::get('username'); ?>">
                <input class="form-control mr-sm-2 my-2 " type="text" name = "email" 
                placeholder="Email" value = "<?php echo Input::get('email'); ?>">
                <input class="form-control mr-sm-2 my-2" type="password" name = "password" placeholder="Password">
                <input class="form-control mr-sm-2 my-2" type="password" name = "re-password" placeholder="Re-enter password">
                <input type = "hidden" name = "token" value = "<?php echo Token::generate(); ?>">
                <?php
                if (Session::exists('error')) {
                    $message = Session::flashMessage('error');
                    echo "<h6 class = 'error text-danger'>{$message}</h6>";
                }
                ?>
                <button class="submit my-2" name = "register-submit" type="submit">Sign up</button>
            </form>
        </div>
    </div>
</section>