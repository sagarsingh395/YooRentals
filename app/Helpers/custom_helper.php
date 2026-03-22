<?php

use App\Models\AuthModel;

if (!function_exists('is_privilege')) {
    function is_privilege($menu_id, $functionId = null)
    {
        if (session()->has('userlogin')) {
            $auth = model('App\Models\AuthModel', false);
            $authenticData = $auth->is_user_privilege(session('group_id'), $menu_id, $functionId);
            if (!empty($authenticData)) {
                //print_r($data); exit;
                return $menu_id;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
}