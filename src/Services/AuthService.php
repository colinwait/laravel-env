<?php

namespace Colinwait\EnvEditor\Services;


class AuthService
{
    public function verify($user, $password)
    {
        if (config('env-editor.auth_user') === $user && config('env-editor.auth_password') === $password) {
            return true;
        }
        return false;
    }

    public function openAuth()
    {
        return config('env-editor.auth_user') && config('env-editor.auth_password') ? true : false;
    }

    public function getUser()
    {
        return request()->get('user');
    }

    public function getPassword()
    {
        return request()->get('password');
    }
}