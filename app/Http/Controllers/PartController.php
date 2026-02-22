<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartRequest;
use App\Services\PartService;
use Illuminate\Http\JsonResponse;

class PartController extends Controller
{
    protected PartService $partService;

    public function __construct(PartService $partService)
    {
        $this->partService = $partService;
    }

    public function index(): JsonResponse
    {
        $parts = $this->partService->getAllParts();
        return response()->json($parts);
    }

    public function store(PartRequest $request): JsonResponse
    {
        $part = $this->partService->createPart($request->validated());
        return response()->json([
            'message' => 'Repuesto creado exitosamente',
            'data' => $part
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $part = $this->partService->getPartById($id);
        return response()->json($part);
    }

    public function update(PartRequest $request, $id): JsonResponse
    {
        $part = $this->partService->updatePart($id, $request->validated());
        return response()->json([
            'message' => 'Repuesto actualizado exitosamente',
            'data' => $part
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->partService->deletePart($id);
        return response()->json([
            'message' => 'Repuesto eliminado exitosamente'
        ]);
    }
}
