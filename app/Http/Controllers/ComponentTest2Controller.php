<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComponentTest2Controller extends Controller
{
    public function show() {
        return view('tests.component');
    }

    // public function show2() {
    //     return view('tests.component2');
    // }
}
