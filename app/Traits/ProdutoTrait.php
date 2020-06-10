<?php

namespace App\Traits;

trait ProdutoTrait
{
    private function produtos($produto)
    {
        $produtos = $produto->limit(8)->orderBy('id', 'desc')->get();

        return $produtos;
    }
}
