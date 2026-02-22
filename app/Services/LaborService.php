<?php

namespace App\Services;

use App\Repositories\LaborRepository;

class LaborService
{
    protected LaborRepository $laborRepository;

    public function __construct(LaborRepository $laborRepository)
    {
        $this->laborRepository = $laborRepository;
    }

    public function getAllLabors()
    {
        return $this->laborRepository->getAll();
    }

    public function getLaborById($id)
    {
        return $this->laborRepository->getById($id);
    }

    public function createLabor(array $data)
    {
        return $this->laborRepository->create($data);
    }

    public function updateLabor($id, array $data)
    {
        return $this->laborRepository->update($id, $data);
    }

    public function deleteLabor($id)
    {
        return $this->laborRepository->delete($id);
    }
}