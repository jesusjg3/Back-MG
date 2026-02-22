<?php

namespace App\Repositories;

use App\Models\Labor;

class LaborRepository
{
    public function getAll()
    {
        return Labor::all();
    }

    public function getById($id)
    {
        return Labor::findOrFail($id);
    }

    public function create(array $data)
    {
        return Labor::create($data);
    }

    public function update($id, array $data)
    {
        $labor = Labor::findOrFail($id);
        $labor->update($data);
        return $labor;
    }

    public function delete($id)
    {
        $labor = Labor::findOrFail($id);
        $labor->delete();
        return $labor;
    }
}
