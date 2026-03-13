<?php

namespace Backend\Service;

use Backend\Repository\ClientRepository;
use Backend\Model\Client;
use InvalidArgumentException;

class ClientService
{
    private ClientRepository $clientRepository;

    public function __construct(?ClientRepository $clientRepository = null)
    {
        $this->clientRepository = $clientRepository ?? new ClientRepository();
    }

    /**
     * @return Client[]
     */
    public function getAllClients(): array
    {
        return $this->clientRepository->findAll();
    }

    /**
     * Get a client by its ID.
     *
     * @param int $id
     * @return Client|null
     */
    public function getClientById(int $id): ?Client
    {
        return $this->clientRepository->findById($id);
    }

    /**
     * Create a new client.
     *
     * @param string $name
     * @param string|null $email
     * @return bool
     */
    public function createClient(string $name, ?string $email): bool
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Client name is required');
        }

        $client = new Client(null, $name, $email);
        return $this->clientRepository->create($client);
    }

    /**
     * Delete a client by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteClient(int $id): bool
    {
        return $this->clientRepository->delete($id);
    }

    /**
     * Update an existing client.
     *
     * @param int $id
     * @param string|null $name
     * @param string|null $email
     * @return bool
     */
    public function updateClient(int $id, ?string $name, ?string $email): bool
    {
        if ($name !== null && trim($name) === '') {
            throw new InvalidArgumentException('Client name cannot be empty');
        }

        $existingClient = $this->clientRepository->findById($id);

        if (!$existingClient) {
            return false;
        }

        $updatedClient = new Client(
            $id,
            $name ?? $existingClient->getName(),
            $email ?? $existingClient->getEmail()
        );

        return $this->clientRepository->update($updatedClient);
    }
}
