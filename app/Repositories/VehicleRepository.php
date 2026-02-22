<?php

namespace App\Repositories;

use App\Models\Vehicle;

class VehicleRepository
{
    public function getAll()
    {
        return Vehicle::with('client')->paginate(15); // Incluimos al cliente para que sea útil
    }

    public function getById($id)
    {
        return Vehicle::with(['client', 'maintenances'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Vehicle::create($data);
    }

    public function update($id, array $data)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($data);
        return $vehicle;
    }

    public function delete($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();
        return $vehicle;
    }
}
