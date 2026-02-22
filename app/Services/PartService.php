<?php

namespace App\Services;

use App\Repositories\PartRepository;

class PartService
{
    protected PartRepository $partRepository;

    public function __construct(PartRepository $partRepository)
    {
        $this->partRepository = $partRepository;
    }

    public function getAllParts()
    {
        return $this->partRepository->getAll();
    }

    public function getPartById($id)
    {
        return $this->partRepository->getById($id);
    }

    public function createPart(array $data)
    {
        return $this->partRepository->create($data);
    }

    public function updatePart($id, array $data)
    {
        return $this->partRepository->update($id, $data);
    }

    public function deletePart($id)
    {
        return $this->partRepository->delete($id);
    }
}