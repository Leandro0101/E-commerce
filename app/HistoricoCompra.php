<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoCompra extends Model
{
    protected $table = "historico_compras";
    protected $fillable = ['quantidade', 'cliente'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    
    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'historico_compras_produtos', 'historico_compra', 'produto');
    }
}
