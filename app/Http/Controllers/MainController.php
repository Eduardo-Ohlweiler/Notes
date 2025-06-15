<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FuncoesServicos;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        echo "i am inside newNote";
    }

    public function editNote($id)
    {
        $id = FuncoesServicos::decryptId($id);
        echo 'edtando a nota com id: ' . $id;
    }

    public function deleteNote($id)
    {
        $id = FuncoesServicos::decryptId($id);
        echo 'deletando a nota com id: ' . $id;
    }
}
