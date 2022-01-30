<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemesController extends Controller
{
    public function edit(Request $request, $id = 0)
    {
        if(empty($request->all()) == false){
            return view('top');
        }
        return view('Themes/edit', ['title' => 'テーマの登録']);
    }
}
