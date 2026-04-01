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
        $keyword = trim($_GET['q'] ?? '');
        if ($keyword) {
            $byName = \App\Models\ProductModel::search('name', $keyword);
            $byDesc = \App\Models\ProductModel::search('description', $keyword);
            $merged = array_merge($byName, $byDesc);
            $ids = [];
            $data = array_filter($merged, function($item) use (&$ids) {
                if (in_array($item->id, $ids)) return false;
                $ids[] = $item->id;
                return true;
            });
            $data = array_values($data);
        } else {
            $data = \App\Models\ProductModel::all();
        }
        view('client.home', compact('data', 'keyword'));
    }
}
