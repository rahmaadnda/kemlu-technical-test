<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negara extends Model {
    protected $table = 'negara';
    protected $primaryKey = 'id_negara'; 
    public $incrementing = true;

    protected $fillable = ['nama_negara', 'kode_negara', 'id_kawasan', 'id_direktorat'];

    public function kawasan() {
        return $this->belongsTo(Kawasan::class, 'id_kawasan');
    }

    public function direktorat() {
        return $this->belongsTo(Direktorat::class, 'id_direktorat');
    }
}
