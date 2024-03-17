<?php

namespace App\Http\Controllers;

class FrontendController extends Controller
{
    public function __construct()
    {
        $this->theme = template();
    }

    public function index()
    {
        return redirect()->route('login');
    }

}
