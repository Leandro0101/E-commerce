<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Cliente extends Model
{
    protected $fillable = ['nome', 'senha', 'email'];

    use HasSlug;

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nome')
            ->saveSlugsTo('slug');
    }

    public function foto()
    {
        
        return $this->hasOne(ClienteFoto::class, 'cliente', 'id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'cliente', 'id');
    }

    public function favoritos()
    {
        return $this->belongsToMany(Produto::class, 'favoritos', 'cliente', 'produto');
    }

}
