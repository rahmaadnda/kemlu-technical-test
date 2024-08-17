<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direktorat extends Model {
    protected $table = 'direktorat';
    protected $primaryKey = 'id_direktorat'; 
    public $incrementing = true;
    
    protected $fillable = ['nama_direktorat'];

    public function kawasan() {
        return $this->hasMany(Kawasan::class, 'id_direktorat');
    }

    public function negara() {
        return $this->hasMany(Negara::class, 'id_direktorat');
    }
}
