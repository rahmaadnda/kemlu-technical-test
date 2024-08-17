<?php

namespace App\Http\Controllers;

use App\Repository\NegaraRepositoryInterface;
use Illuminate\Http\Request;

class NegaraController extends Controller {
    protected $negaraRepository;

    public function __construct(NegaraRepositoryInterface $negaraRepository) {
        $this->negaraRepository = $negaraRepository;
    }

    public function index() {
        return response()->json($this->negaraRepository->getAllNegara());
    }

    public function show($id) {
        return response()->json($this->negaraRepository->getNegaraById($id));
    }

    public function store(Request $request) {
        $negara = $this->negaraRepository->createNegara($request->all());
        return response()->json($negara, 201);
    }

    public function update(Request $request, $id) {
        $negara = $this->negaraRepository->updateNegara($id, $request->all());
        return response()->json($negara);
    }

    public function destroy($id) {
        $this->negaraRepository->deleteNegara($id);
        return response()->json(null, 204);
    }

    public function showDirektorat($id) {
        return response()->json($this->negaraRepository->getDirektoratById($id));
    }

    public function showKawasan($id) {
        return response()->json($this->negaraRepository->getKawasanById($id));
    }
}
