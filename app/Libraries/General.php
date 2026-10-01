<?php

namespace App\Libraries;

class General
{

    function isLogin()
    {
        $session = session();
        if ($session->get('isLogin') == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function cekUserLogin()
    {
        if ($this->isLogin() != TRUE) {
            return redirect()->to('/auth/login');
        }
    }
}
