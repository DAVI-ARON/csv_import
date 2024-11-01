<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Litsar Usuários
    public function index() {

        // recuperar registros do banco de dados
        $users = User::get();

        return view('users.index', ['users' => $users]);

    }

    // Importando arquivos
    public function import(Request $request) {
        dd($request);
    }
}
