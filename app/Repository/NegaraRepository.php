<?php

namespace App\Repository;

use App\Models\Negara;
use App\Models\Kawasan;
use App\Models\Direktorat;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NegaraRepository implements NegaraRepositoryInterface {
    
    public function getAllNegara() {
        return Negara::all();
    }

    public function getNegaraById($id) {
        try {
            return Negara::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function getDirektoratById($id) {
        try {
            return Direktorat::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function getKawasanById($id) {
        try {
            return Kawasan::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function getOrCreateDirektorat($direktoratData) {
        return Direktorat::firstOrCreate(
            ['nama_direktorat' => $direktoratData['nama_direktorat']]
        );
    }

    public function getOrCreateKawasan($kawasanData, $direktorat) {
        return Kawasan::firstOrCreate(
            [
                'nama_kawasan' => $kawasanData['nama_kawasan'],
                'id_direktorat' => $direktorat->id_direktorat
            ]
        );
    }

    public function createNegara($data) {
        $direktoratData = $data['direktorat'];
        $kawasanData = $data['kawasan'];

        $direktorat = $this->getOrCreateDirektorat($direktoratData);

        $kawasan = $this->getOrCreateKawasan($kawasanData, $direktorat);

        $negara = Negara::create([
            'nama_negara' => $data['nama_negara'],
            'kode_negara' => $data['kode_negara'],
            'id_kawasan' => $kawasan->id_kawasan,
            'id_direktorat' => $direktorat->id_direktorat
        ]);

        return $negara;
    }

    public function deleteNegara($id) {
        try {
            $negara = Negara::findOrFail($id);
            $negara->delete();
            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }
}
