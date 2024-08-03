<?php

namespace Azuriom\Plugin\Skin3dviewer\Controllers;

use Azuriom\Http\Controllers\Controller;

class Skin3dviewerHomeController extends Controller
{
    /**
     * Show the home plugin page.
     */
    public function index()
    {
        return view('skin3dviewer::index');
    }
}
