<?php

namespace App\Http\Controllers;

// PASTIKAN DUA BARIS 'USE' INI ADA
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // PASTIKAN BARIS 'USE' INI ADA DI DALAM CLASS
    use AuthorizesRequests, ValidatesRequests;
}