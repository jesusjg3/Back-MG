<?php

namespace App\Repositories;

use App\Models\Part;

class PartRepository
{
    public function getAll()
    {
        return Part::all();
    }

    public function getInventory()
    {
        return Part::where('manages_stock', true)->get();
    }

    public function getById($id)
    {
        return Part::findOrFail($id);
    }

    public function create(array $data)
    {
        return Part::create($data);
    }

    public function update($id, array $data)
    {
        $part = Part::findOrFail($id);
        $part->update($data);
        return $part;
    }

    public function updateStock($id, $quantity)
    {
        $part = Part::findOrFail($id);
        $part->increment('stock', $quantity); // Si quantity es -2, restará 2.
        return $part;
    }

    public function delete($id)
    {
        $part = Part::findOrFail($id);
        $part->delete();
        return $part;
    }
}
