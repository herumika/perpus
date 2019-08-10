<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';
    public $primaryKey = 'pinjaman_id';
    public $timestamps = false;

    public function buku()
    {
        return $this->belongsTo('App\Models\Buku','buku_id','buku_id');
    }
}
