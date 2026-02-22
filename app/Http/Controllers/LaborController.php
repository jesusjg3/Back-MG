<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaborRequest;
use App\Services\LaborService;
use Illuminate\Http\JsonResponse;

class LaborController extends Controller
{
    protected LaborService $laborService;

    public function __construct(LaborService $laborService)
    {
        $this->laborService = $laborService;
    }

    public function index(): JsonResponse
    {
        $labors = $this->laborService->getAllLabors();
        return response()->json($labors);
    }

    public function store(LaborRequest $request): JsonResponse
    {
        $labor = $this->laborService->createLabor($request->validated());
        return response()->json([
            'message' => 'Mano de obra creada exitosamente',
            'data' => $labor
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $labor = $this->laborService->getLaborById($id);
        return response()->json($labor);
    }

    public function update(LaborRequest $request, $id): JsonResponse
    {
        $labor = $this->laborService->updateLabor($id, $request->validated());
        return response()->json([
            'message' => 'Mano de obra actualizada exitosamente',
            'data' => $labor
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->laborService->deleteLabor($id);
        return response()->json([
            'message' => 'Mano de obra eliminada exitosamente'
        ]);
    }
}
