<?php

use Illuminate\Support\Facades\Auth;

function isCurrentUser($id)
{
    if (Auth::guard('user')->user()->id === $id) {
        return true;
    }
    return false;
}

if (!function_exists('getUrlByRole')) {
    function getUrlByRole() : string
    {
        if(Auth::guard('admin')->user()->role_id === \App\Models\Admin::ADMIN_ROLE){
            $url = 'admin/';
        } else {
            $url = 'admin/comments';
        }

        return $url;
    }
}
