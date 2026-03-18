<?php

namespace App\Repositories;

use App\Models\Maintenance;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

class MaintenanceRepository
{
    public function getAll()
    {
        return Maintenance::with([
            'vehicle' => function ($query) {
                $query->withTrashed()->with('client');
            }, 
            'parts', 
            'labors'
        ])->get();
    }

    public function getById($id)
    {
        return Maintenance::with([
            'vehicle' => function ($query) {
                $query->withTrashed()->with('client');
            }, 
            'parts', 
            'labors'
        ])->findOrFail($id);
    }

    /**
     * Inserta en 'maintenances', 'maintenance_part' y 'maintenance_labor'
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Crear cabecera
            $maintenance = Maintenance::create([
                'vehicle_id' => $data['vehicle_id'],
                'kilometraje' => $data['kilometraje'],
                'prox_kilometraje' => $data['prox_kilometraje'],
                'fecha' => $data['fecha'],
                'total_cost' => $data['total_cost'], // El valor final calculado
                'observaciones' => $data['observaciones'] ?? null,
            ]);

            // Actualizar kilometraje del vehículo con el nuevo registro
            if (isset($data['kilometraje']) && isset($data['vehicle_id'])) {
                Vehicle::where('id', $data['vehicle_id'])->update(['kilometraje' => $data['kilometraje']]);
            }

            // 2. Persistir relación con Partes (Pivot)
            if (!empty($data['parts'])) {
                foreach ($data['parts'] as $part) {
                    $maintenance->parts()->attach($part['id'], [
                        'quantity' => $part['quantity'],
                        'price_at_time' => $part['price_at_time'],
                    ]);
                }
            }

            // 3. Persistir relación con Labores (Pivot)
            if (!empty($data['labors'])) {
                foreach ($data['labors'] as $labor) {
                    $maintenance->labors()->attach($labor['id'], [
                        'cost_at_time' => $labor['cost_at_time'],
                    ]);
                }
            }

            return $maintenance;
        });
    }

    public function update($id, array $data)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->update($data);

        // Actualizar kilometraje del vehículo también en caso de edición
        if (isset($data['kilometraje'])) {
            Vehicle::where('id', $maintenance->vehicle_id)->update(['kilometraje' => $data['kilometraje']]);
        }

        if (isset($data['parts'])) {
            $formattedParts = [];
            foreach ($data['parts'] as $part) {
                $formattedParts[$part['id']] = [
                    'quantity' => $part['quantity'],
                    'price_at_time' => $part['price_at_time']
                ];
            }
            $maintenance->parts()->sync($formattedParts);
        }

        if (isset($data['labors'])) {
            $formattedLabors = [];
            foreach ($data['labors'] as $labor) {
                $formattedLabors[$labor['id']] = [
                    'cost_at_time' => $labor['cost_at_time']
                ];
            }
            $maintenance->labors()->sync($formattedLabors);
        }

        return $maintenance;
    }

    public function delete($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete(); // Gracias al modelo, esto hará SoftDelete
        return $maintenance;
    }
}