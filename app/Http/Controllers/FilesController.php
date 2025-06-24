<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function index(){
        $images = Image::all();
        return view('files/index', compact('images'));
    }
}
