<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectionController extends Controller
{
    public function index()
    {
        return view('inbound.projection.index');
    }

    public function show($projection)
    {
        return view('inbound.projection.show', compact('projection'));
    }
}
