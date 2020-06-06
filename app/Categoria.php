<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasSlug;
    protected $table = "categorias";
    protected $fillable = ['nome', 'descricao'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nome')
            ->saveSlugsTo('slug');
    }


    public function produtos()
    {
        return $this->hasMany(Produto::class, 'categoria', 'id');
    }
}
