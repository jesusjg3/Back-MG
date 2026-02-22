<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository
{
    public function getAll()
    {
        return Client::all();
    }

    public function getById($id)
    {
        return Client::with('vehicles.maintenances')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Client::create($data);
    }

    public function update($id, array $data)
    {
        $client = Client::findOrFail($id);
        $client->update($data);
        return $client;
    }

    public function delete($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return $client;
    }
}
