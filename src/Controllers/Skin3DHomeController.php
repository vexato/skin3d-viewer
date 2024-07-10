<?php

namespace Azuriom\Plugin\Skin3D\Controllers;
use Illuminate\Http\Request;
use Azuriom\Http\Controllers\Controller;

class Skin3DHomeController extends Controller
{
    /**
     * Show the home plugin page.
     */
    public function index()
    {
        return view('skin3d::index');
    }
}
