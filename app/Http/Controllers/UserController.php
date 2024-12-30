<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
    // Criar um array com as colunas do banco de dados
        $headers = ['name', 'email', 'password'];

    // Receber o arquivo, ler os dados e converter a string em array
        $dataFile = array_map('str_getcsv', file($request->file('file')));

    // Definindo variável de iteração
        $numberRegisteredRecords = 0;
        $emailAlredyRegistered = false;

    // Percorrer todas as linhas do arquivo
        foreach ($dataFile as $KeyData => $row) {

            // Converter linha em array
                $value = explode(';', $row[0]);

            // Percorrer as colunas do cabeçalho
                foreach ($headers as $key => $header) {

                    // Atribui o valor ao elemento do array
                     $arrayValues[$KeyData][$header] = $value[$key];

                    // Verifica se a colune é um email
                        if ($header == "email") {

                            // Verifica se o email já está cadastrado no banco de dados
                                if(User::where('email', $arrayValues[$KeyData]['email'])->first()) {

                                    // Atribui o e-mail na lista de e-mails já cadastrados
                                        $emailAlredyRegistered .= $arrayValues[$KeyData]['email'] . ", ";

                                }
                        }

                    }

                    // Verifica se está na coluna senha para criptografia
                        if ($header = "password") {
                            // Criptografa a senha vinda no arquivo excel
                            // $arrayValues[$KeyData][$header] = Hash::make($arrayValues[$KeyData]['password'], ['rounds' => 12]);

                            // Cria uma senha aleatória para o usuário caso ele não tenha
                            $arrayValues[$KeyData][$header] = Hash::make(Str::random(7), ['rounds' => 12]);
                            // $arrayValues[$KeyData][$header] = Str::random(7);
                        }

                $numberRegisteredRecords++;
        }

        if ($emailAlredyRegistered) {

            return back()->with('error', 'Dados não importados. Existem e-mails já cadastrados.:<br>' . $emailAlredyRegistered);

        }

        User::insert($arrayValues);
        return back()->with('success', 'Dados importados com sucesso. <br>Quantidade: ' . $numberRegisteredRecords);
    }
}
