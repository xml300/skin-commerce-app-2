<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $categories = json_decode(file_get_contents(database_path('seeders/data/categories.json')), true);
        return view('admin.admin', ['categories' => $categories]);
    }
}