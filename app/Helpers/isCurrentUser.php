<?php

use Illuminate\Support\Facades\Auth;

function isCurrentUser($id)
{
    if (Auth::guard('user')->user()->id === $id) {
        return true;
    }
    return false;
}
