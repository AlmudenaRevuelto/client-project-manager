<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Backend\Service\ClientService;
use Backend\Repository\ClientRepository;
use Backend\Model\Client;
use InvalidArgumentException;

#[\PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations]
class ClientServiceTest extends TestCase
{
    /**
     * Ensure createClient returns true when the repository successfully creates a client.
     */
    public function testCreateClientSuccess(): void
    {
        $clientRepositoryMock = $this->createMock(ClientRepository::class);
        $clientRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn(true);

        $service = new ClientService($clientRepositoryMock);

        $result = $service->createClient('Test Client', 'test@example.com');

        $this->assertTrue($result);
    }

    /**
     * Ensure createClient throws when name is empty.
     */
    public function testCreateClientThrowsWhenNameEmpty(): void
    {
        $clientRepositoryMock = $this->createMock(ClientRepository::class);
        // No expects because validation happens before calling repository

        $service = new ClientService($clientRepositoryMock);

        $this->expectException(InvalidArgumentException::class);
        $service->createClient('', 'test@example.com');
    }

    /**
     * Ensure updateClient returns true when the client exists and update succeeds.
     */
    public function testUpdateClientSuccess(): void
    {
        $clientRepositoryMock = $this->createMock(ClientRepository::class);
        $clientRepositoryMock
            ->expects($this->once())
            ->method('findById')
            ->willReturn(new Client(1, 'Existing', 'existing@example.com'));
        $clientRepositoryMock
            ->expects($this->once())
            ->method('update')
            ->willReturn(true);

        $service = new ClientService($clientRepositoryMock);

        $result = $service->updateClient(1, 'Updated name', 'updated@example.com');

        $this->assertTrue($result);
    }

    /**
     * Ensure updateClient returns false when the client does not exist.
     */
    public function testUpdateClientReturnsFalseWhenNotFound(): void
    {
        $clientRepositoryMock = $this->createMock(ClientRepository::class);
        $clientRepositoryMock
            ->expects($this->once())
            ->method('findById')
            ->willReturn(null);

        $service = new ClientService($clientRepositoryMock);

        $result = $service->updateClient(1, 'Updated name', 'updated@example.com');

        $this->assertFalse($result);
    }

    /**
     * Ensure updateClient throws when name is an empty string.
     */
    public function testUpdateClientThrowsWhenNameEmpty(): void
    {
        $clientRepositoryMock = $this->createMock(ClientRepository::class);
        // No expects because validation happens before calling repository

        $service = new ClientService($clientRepositoryMock);

        $this->expectException(InvalidArgumentException::class);
        $service->updateClient(1, '', 'updated@example.com');
    }

    /**
     * Ensure deleteClient returns true when the repository successfully deletes a client.
     */
    public function testDeleteClientSuccess(): void
    {
        $clientRepositoryMock = $this->createMock(ClientRepository::class);
        $clientRepositoryMock
            ->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $service = new ClientService($clientRepositoryMock);

        $result = $service->deleteClient(1);

        $this->assertTrue($result);
    }

    /**
     * Ensure deleteClient returns false when the client does not exist.
     */
    public function testDeleteClientReturnsFalseWhenNotFound(): void
    {
        $clientRepositoryMock = $this->createMock(ClientRepository::class);
        $clientRepositoryMock
            ->expects($this->once())
            ->method('delete')
            ->willReturn(false);

        $service = new ClientService($clientRepositoryMock);

        $result = $service->deleteClient(1);

        $this->assertFalse($result);
    }

    /**
     * Ensure getAllClients returns the list of clients from the repository.
     */
    public function testGetAllClients(): void
    {
        $clients = [
            new Client(1, 'Client 1', 'client1@example.com'),
            new Client(2, 'Client 2', 'client2@example.com'),
        ];

        $clientRepositoryMock = $this->createMock(ClientRepository::class);
        $clientRepositoryMock
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($clients);

        $service = new ClientService($clientRepositoryMock);

        $result = $service->getAllClients();

        $this->assertEquals($clients, $result);
    }

    /**
     * Ensure getClientById returns the client when found.
     */
    public function testGetClientByIdSuccess(): void
    {
        $client = new Client(1, 'Client 1', 'client1@example.com');

        $clientRepositoryMock = $this->createMock(ClientRepository::class);
        $clientRepositoryMock
            ->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn($client);

        $service = new ClientService($clientRepositoryMock);

        $result = $service->getClientById(1);

        $this->assertEquals($client, $result);
    }

    /**
     * Ensure getClientById returns null when client not found.
     */
    public function testGetClientByIdReturnsNullWhenNotFound(): void
    {
        $clientRepositoryMock = $this->createMock(ClientRepository::class);
        $clientRepositoryMock
            ->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn(null);

        $service = new ClientService($clientRepositoryMock);

        $result = $service->getClientById(1);

        $this->assertNull($result);
    }
}

