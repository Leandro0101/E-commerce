<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasSlug;
    protected $fillable = ['nome, quantidade, descricao, preco', 'slug'];
    protected $table = "produtos";

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nome')
            ->saveSlugsTo('slug');
    }

    public function fotos()
    {
        return $this->hasMany(ProdutoFoto::class, 'produto', 'id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'produto', 'id');
    }

    public function favoritos()
    {
        return $this->belongsToMany(Cliente::class, 'favoritos', 'produto', 'cliente');
    }


}
