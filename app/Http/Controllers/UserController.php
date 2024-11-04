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

        // Validando o formulario
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ],[
            'file.required' => 'O campo de escolha de arquivo é obrigatório',
            'file.mimes' => 'Tipo de arquivo inválido. Envie um arquivo .csv',
            'file.max' => 'Tamanho do arquivo excede o max de :max MB'
        ]
    );
        dd('Continuar');
    }
}
