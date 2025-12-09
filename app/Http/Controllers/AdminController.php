<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $buttons = [
            ['label' => 'Перейти на сайт', 'href' => '/', 'class' => 'btn btn-secondary'],
        ];

        return view('admin.index', [
            'pageTitle' => 'Панель администратора',
            'buttons' => $buttons,
        ]);
    }
}
