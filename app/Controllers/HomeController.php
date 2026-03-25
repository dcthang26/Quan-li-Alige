<?php
namespace App\Controllers;

class HomeController
{
    public function index()
    {
        $data = \App\Models\ProductModel::all();
        view('client.landing', compact('data'));
    }

    public function shop()
    {
        $data = \App\Models\ProductModel::all();
        view('client.home', compact('data'));
    }
}
