<?php
use Illuminate\Support\Facades\Auth;

if(!function_exists("CurrentUserRole")){
    function CurrentUserRole()
    {
       return Auth::check()?Auth::user()->getRoleNames()->first():null;
    }
}
