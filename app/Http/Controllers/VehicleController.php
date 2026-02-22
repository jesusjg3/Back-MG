<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;

class VehicleController extends Controller
{
    protected VehicleService $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    public function index(): JsonResponse
    {
        $vehicles = $this->vehicleService->getAllVehicles();
        return response()->json($vehicles);
    }

    public function store(VehicleRequest $request): JsonResponse
    {
        $vehicle = $this->vehicleService->createVehicle($request->validated());
        return response()->json([
            'message' => 'Vehículo creado exitosamente',
            'data' => $vehicle
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $vehicle = $this->vehicleService->getVehicleById($id);
        return response()->json($vehicle);
    }

    public function update(VehicleRequest $request, $id): JsonResponse
    {
        $vehicle = $this->vehicleService->updateVehicle($id, $request->validated());
        return response()->json([
            'message' => 'Vehículo actualizado exitosamente',
            'data' => $vehicle
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->vehicleService->deleteVehicle($id);
        return response()->json([
            'message' => 'Vehículo eliminado exitosamente'
        ]);
    }
}
