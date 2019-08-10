<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    public $primaryKey = 'buku_id';
    public $timestamps = false;

    public function kategori()
    {
        return $this->belongsTo('App\Models\Kategori', 'kategori_id', 'kategori_id');
    }

    public function gambar()
    {
        return $this->belongsTo('App\Models\Gambar_buku','buku_id','buku_id');
    }
}
