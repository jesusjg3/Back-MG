<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaintenanceRequest;
use App\Services\MaintenanceService;
use Illuminate\Http\JsonResponse;

class MaintenanceController extends Controller
{
    protected MaintenanceService $maintenanceService;

    public function __construct(MaintenanceService $maintenanceService)
    {
        $this->maintenanceService = $maintenanceService;
    }

    public function index(): JsonResponse
    {
        $maintenances = $this->maintenanceService->getAllMaintenances();
        return response()->json($maintenances);
    }

    public function store(MaintenanceRequest $request): JsonResponse
    {
        try {
            $maintance = $this->maintenanceService->createMaintenance($request->validated());
            return response()->json([
                'message' => 'Mantenimiento creado exitosamente',
                'data' => $maintance
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el mantenimiento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        $maintenance = $this->maintenanceService->getMaintenanceById($id);
        return response()->json($maintenance);
    }

    public function update(MaintenanceRequest $request, $id): JsonResponse
    {
        try {
            $maintenance = $this->maintenanceService->updateMaintenance($id, $request->validated());
            return response()->json([
                'message' => 'Mantenimiento actualizado exitosamente',
                'data' => $maintenance
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el mantenimiento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $this->maintenanceService->deleteMaintenance($id);
        return response()->json([
            'message' => 'Mantenimiento eliminado exitosamente'
        ], 200);
    }
}
