<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kawasan extends Model {
    protected $table = 'kawasan';
    protected $primaryKey = 'id_kawasan'; 
    public $incrementing = true;

    protected $fillable = ['nama_kawasan', 'id_direktorat'];

    public function direktorat() {
        return $this->belongsTo(Direktorat::class, 'id_direktorat');
    }

    public function negara() {
        return $this->hasMany(Negara::class, 'id_kawasan');
    }
}
