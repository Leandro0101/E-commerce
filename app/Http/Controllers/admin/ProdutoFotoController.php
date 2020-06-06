<?php

namespace App\Http\Controllers\admin;

use App\ProdutoFoto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProdutoFotoController extends Controller
{
    public function removeFoto(Request $requet){
        $fotoProduto = new ProdutoFoto();
        $nomeFoto = $requet->get('nomeFoto');

        if(Storage::disk('public')->exists($nomeFoto)){
            Storage::disk('public')->delete($nomeFoto);
        }

        $fotoRemovida = $fotoProduto->where('path', $nomeFoto);
        $produtoId = $fotoRemovida->first()->produto;

        $fotoRemovida->delete();

        
        flash('Imagem removida com sucesso')->success();

        return redirect()->route('admin.produto.edit', ['produto' => $produtoId] );

    }
}
