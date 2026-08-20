<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\view\View;

class PublicController extends Controller
{
    public function index()
    {
        return view('public.index');
    }
}
