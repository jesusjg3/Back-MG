<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    protected ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(): JsonResponse
    {
        $clients = $this->clientService->getAllClients();
        return response()->json($clients);
    }

    public function store(ClientRequest $request): JsonResponse
    {
        $client = $this->clientService->createClient($request->validated());
        return response()->json([
            'message' => 'Cliente creado exitosamente',
            'data' => $client
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $client = $this->clientService->getClientById($id);
        return response()->json($client);
    }

    public function update(ClientRequest $request, $id): JsonResponse
    {
        $client = $this->clientService->updateClient($id, $request->validated());
        return response()->json([
            'message' => 'Cliente actualizado exitosamente',
            'data' => $client
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->clientService->deleteClient($id);
        return response()->json([
            'message' => 'Cliente eliminado exitosamente'
        ]);
    }
}
