<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('user/index');
    }

    public function create(){
        return view('user/create');
    }

    public function edit(int $id){
        $user = User::findOrFail($id);
        return view('user/edit', compact('user'));
    }

    public function store(StoreUser $request){
        
    }
}
