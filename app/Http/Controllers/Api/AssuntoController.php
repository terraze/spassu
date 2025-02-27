<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assunto;

use Illuminate\Http\Request;

class AssuntoController extends Controller
{
    public function indexa()
    {
        return response()->json(Assunto::all());
    }
}
