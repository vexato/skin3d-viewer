<?php

namespace Azuriom\Plugin\Skin3d\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     */
    public function index()
    {
        return view('skin3d::admin.index');
    }
}
