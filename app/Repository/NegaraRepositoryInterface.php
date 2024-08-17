<?php

namespace App\Repository;

interface NegaraRepositoryInterface {

    public function getAllNegara();

    public function getNegaraById($id);

    public function getOrCreateDirektorat($direktoratData);

    public function getOrCreateKawasan($kawasanData, $direktorat);

    public function createNegara($data);

    public function deleteNegara($id);
}
