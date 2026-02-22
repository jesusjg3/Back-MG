<?php

namespace App\Services;

use App\Repositories\VehicleRepository;

class VehicleService
{
    protected VehicleRepository $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function getAllVehicles()
    {
        return $this->vehicleRepository->getAll();
    }

    public function getVehicleById($id)
    {
        return $this->vehicleRepository->getById($id);
    }

    public function createVehicle(array $data)
    {
        return $this->vehicleRepository->create($data);
    }

    public function updateVehicle($id, array $data)
    {
        return $this->vehicleRepository->update($id, $data);
    }

    public function deleteVehicle($id)
    {
        return $this->vehicleRepository->delete($id);
    }
}