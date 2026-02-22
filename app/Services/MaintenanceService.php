<?php

namespace App\Services;

use App\Repositories\MaintenanceRepository;
use App\Repositories\PartRepository;
use Illuminate\Support\Facades\DB;

class MaintenanceService
{
    protected MaintenanceRepository $maintenanceRepository;
    protected PartRepository $partRepository;

    public function __construct(MaintenanceRepository $maintenanceRepository, PartRepository $partRepository)
    {
        $this->maintenanceRepository = $maintenanceRepository;
        $this->partRepository = $partRepository;
    }

    public function getAllMaintenances()
    {
        return $this->maintenanceRepository->getAll();
    }

    public function getMaintenanceById($id)
    {
        return $this->maintenanceRepository->getById($id);
    }

    public function createMaintenance(array $data)
    {
        return DB::transaction(function () use ($data) {

            $total = 0;

            if (isset($data['parts'])) {
                foreach ($data['parts'] as $partData) {
                    $total += $partData['quantity'] * $partData['price_at_time'];
                }
            }

            if (isset($data['labors'])) {
                foreach ($data['labors'] as $laborData) {
                    $total += $laborData['cost_at_time'];
                }
            }

            $data['total_cost'] = $total;

            $maintenance = $this->maintenanceRepository->create($data);

            if (isset($data['parts'])) {
                foreach ($data['parts'] as $partData) {
                    $part = $this->partRepository->getById($partData['id']);

                    if ($part->manages_stock) {
                        $this->partRepository->updateStock($part->id, -$partData['quantity']);
                    }
                }
            }

            return $maintenance;
        });
    }

    public function updateMaintenance($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $maintenance = $this->maintenanceRepository->getById($id);

            // 1. Revertir stock de las partes anteriores (Devolver al inventario)
            foreach ($maintenance->parts as $oldPart) {
                if ($oldPart->manages_stock) {
                    $this->partRepository->updateStock($oldPart->id, $oldPart->pivot->quantity);
                }
            }

            // 2. Calcular nuevo costo total
            $total = 0;
            if (isset($data['parts'])) {
                foreach ($data['parts'] as $partData) {
                    $total += $partData['quantity'] * $partData['price_at_time'];
                }
            }
            if (isset($data['labors'])) {
                foreach ($data['labors'] as $laborData) {
                    $total += $laborData['cost_at_time'];
                }
            }
            $data['total_cost'] = $total;

            // 3. Actualizar mantenimiento y relaciones en BD
            $updatedMaintenance = $this->maintenanceRepository->update($id, $data);

            // 4. Descontar stock de las nuevas partes (Consumir del inventario)
            if (isset($data['parts'])) {
                foreach ($data['parts'] as $partData) {
                    $part = $this->partRepository->getById($partData['id']);
                    if ($part->manages_stock) {
                        $this->partRepository->updateStock($part->id, -$partData['quantity']);
                    }
                }
            }

            return $updatedMaintenance;
        });
    }

    public function deleteMaintenance($id)
    {
        return $this->maintenanceRepository->delete($id);
    }
}