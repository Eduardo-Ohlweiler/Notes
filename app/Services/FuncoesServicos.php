<?php

namespace App\Services;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class FuncoesServicos
{
    public static function decryptId($id)
    {
        try
        {
            $id = Crypt::decrypt($id);
            return $id;
        }
        catch (DecryptException $e)
        {
            return redirect()->route('home');
        }
    }
}
