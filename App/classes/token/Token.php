<?php

namespace Token;

use Session\Session;

class Token
{
    public static function generate()
    {
        return Session::put("token", md5(uniqid()));
    }
    
    public static function check($token)
    {
        $token_name = "token";
        if (Session::exists($token_name) && $token === Session::get($token_name)) {
            Session::delete($token_name);
            return true;
        }
        return false;
    }
}
