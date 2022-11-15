<?php

namespace App\Http\View\AdminLte;

use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class AuthorizeMenuFilter implements FilterInterface
{
    public function transform($item)
    {
        // return false, if not authorized.
        if (Auth::guest()) {
            return false;
        }

        if (Arr::has($item, 'submenu')) {
            // get available submenus
            $submenus = array_filter($item['submenu'], function ($submenu) {
                return Auth::guard('admin')->user()->hasAbility($this->ability($submenu));
            });

            // return false, if no available menus
            return empty($submenus) ? false : $item;
        }

        // return false, if not available
        return Auth::guard('admin')->user()->hasAbility($this->ability($item)) ||
        (Auth::guard('admin')->user()?->role === Admin::ADMIN_ROLE & array_key_exists('header', $item)) ? $item : false;
    }

    protected function ability($item)
    {
        // return route as ability
        return Arr::get($item, 'route', '');
    }
}
