<?php

namespace Azuriom\Plugin\Skin3dviewer\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     */
    public function index()
    {
        return view('skin3dviewer::admin.index');
    }
}
