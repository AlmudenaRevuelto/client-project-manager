<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Backend\Service\ProjectService;
use Backend\Repository\ProjectRepository;
use Backend\Repository\ClientRepository;
use Backend\Model\Client;
use Backend\Model\Project;
use InvalidArgumentException;

#[\PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations]
class ProjectServiceTest extends TestCase
{
    /**
     * Ensure createProject returns true when the repository successfully creates a project.
     */
    public function testCreateProjectSuccess(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $clientRepositoryMock
            ->expects($this->once())
            ->method('findById')
            ->willReturn(new Client(1, 'Test Client', 'test@example.com'));

        $projectRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn(true);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $data = [
            'name' => 'Portfolio',
            'client_id' => 1,
            'status' => 'active'
        ];

        $result = $service->createProject($data);

        $this->assertTrue($result);
    }

    /**
     * Ensure createProject throws when name is empty.
     */
    public function testCreateProjectThrowsWhenNameEmpty(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $this->expectException(InvalidArgumentException::class);
        $service->createProject(['name' => '', 'client_id' => 1]);
    }

    /**
     * Ensure createProject throws when client_id is missing.
     */
    public function testCreateProjectThrowsWhenClientIdMissing(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $this->expectException(InvalidArgumentException::class);
        $service->createProject(['name' => 'Test Project']);
    }

    /**
     * Ensure createProject throws when client not found.
     */
    public function testCreateProjectThrowsWhenClientNotFound(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $clientRepositoryMock
            ->expects($this->once())
            ->method('findById')
            ->willReturn(null);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $this->expectException(InvalidArgumentException::class);
        $service->createProject(['name' => 'Test Project', 'client_id' => 1]);
    }

    /**
     * Ensure createProject throws when status is invalid.
     */
    public function testCreateProjectThrowsWhenStatusInvalid(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $clientRepositoryMock
            ->expects($this->once())
            ->method('findById')
            ->willReturn(new Client(1, 'Test Client', 'test@example.com'));

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $this->expectException(InvalidArgumentException::class);
        $service->createProject(['name' => 'Test Project', 'client_id' => 1, 'status' => 'invalid']);
    }

    /**
     * Ensure getAllProjects returns the list of projects from the repository.
     */
    public function testGetAllProjects(): void
    {
        $projects = [
            new Project(1, 'Project 1', 'active', null, new Client(1, 'Client 1', 'client1@example.com')),
            new Project(2, 'Project 2', 'finished', null, new Client(2, 'Client 2', 'client2@example.com')),
        ];

        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $projectRepositoryMock
            ->expects($this->once())
            ->method('findAllWithClient')
            ->willReturn($projects);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $result = $service->getAllProjects();

        $this->assertEquals($projects, $result);
    }

    /**
     * Ensure getProjectsByClient returns projects for an existing client.
     */
    public function testGetProjectsByClientSuccess(): void
    {
        $projects = [
            new Project(1, 'Project 1', 'active', null, new Client(1, 'Client 1', 'client1@example.com')),
        ];

        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $clientRepositoryMock
            ->expects($this->once())
            ->method('findById')
            ->willReturn(new Client(1, 'Client 1', 'client1@example.com'));

        $projectRepositoryMock
            ->expects($this->once())
            ->method('findByClientId')
            ->with(1)
            ->willReturn($projects);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $result = $service->getProjectsByClient(1);

        $this->assertEquals($projects, $result);
    }

    /**
     * Ensure getProjectsByClient throws when client not found.
     */
    public function testGetProjectsByClientThrowsWhenClientNotFound(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $clientRepositoryMock
            ->expects($this->once())
            ->method('findById')
            ->willReturn(null);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $this->expectException(InvalidArgumentException::class);
        $service->getProjectsByClient(1);
    }

    /**
     * Ensure getProjectById returns the project when found.
     */
    public function testGetProjectByIdSuccess(): void
    {
        $project = new Project(1, 'Project 1', 'active', null, new Client(1, 'Client 1', 'client1@example.com'));

        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $projectRepositoryMock
            ->expects($this->once())
            ->method('findByIdWithClient')
            ->with(1)
            ->willReturn($project);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $result = $service->getProjectById(1);

        $this->assertEquals($project, $result);
    }

    /**
     * Ensure getProjectById throws when project not found.
     */
    public function testGetProjectByIdThrowsWhenNotFound(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $projectRepositoryMock
            ->expects($this->once())
            ->method('findByIdWithClient')
            ->willReturn(null);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $this->expectException(InvalidArgumentException::class);
        $service->getProjectById(1);
    }

    /**
     * Ensure updateProject succeeds when project exists and data is valid.
     */
    public function testUpdateProjectSuccess(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $projectRepositoryMock
            ->expects($this->once())
            ->method('update')
            ->with(1, ['name' => 'Updated Project', 'status' => 'finished'])
            ->willReturn(true);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $service->updateProject(1, ['name' => 'Updated Project', 'status' => 'finished']);

        // No assertion needed, just ensure no exception
        $this->assertTrue(true);
    }

    /**
     * Ensure updateProject throws when name is empty.
     */
    public function testUpdateProjectThrowsWhenNameEmpty(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $this->expectException(InvalidArgumentException::class);
        $service->updateProject(1, ['name' => '', 'status' => 'active']);
    }

    /**
     * Ensure updateProject throws when status is missing.
     */
    public function testUpdateProjectThrowsWhenStatusMissing(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $this->expectException(InvalidArgumentException::class);
        $service->updateProject(1, ['name' => 'Test Project']);
    }

    /**
     * Ensure updateProject throws when status is invalid.
     */
    public function testUpdateProjectThrowsWhenStatusInvalid(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $this->expectException(InvalidArgumentException::class);
        $service->updateProject(1, ['name' => 'Test Project', 'status' => 'invalid']);
    }

    /**
     * Ensure updateProject throws when project not found.
     */
    public function testUpdateProjectThrowsWhenNotFound(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $projectRepositoryMock
            ->expects($this->once())
            ->method('update')
            ->willReturn(false);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $this->expectException(InvalidArgumentException::class);
        $service->updateProject(1, ['name' => 'Test Project', 'status' => 'active']);
    }

    /**
     * Ensure deleteProject succeeds when project exists.
     */
    public function testDeleteProjectSuccess(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $projectRepositoryMock
            ->expects($this->once())
            ->method('delete')
            ->with(1)
            ->willReturn(true);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $service->deleteProject(1);

        // No assertion needed, just ensure no exception
        $this->assertTrue(true);
    }

    /**
     * Ensure deleteProject throws when project not found.
     */
    public function testDeleteProjectThrowsWhenNotFound(): void
    {
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);
        $clientRepositoryMock = $this->createMock(ClientRepository::class);

        $projectRepositoryMock
            ->expects($this->once())
            ->method('delete')
            ->willReturn(false);

        $service = new ProjectService(
            $projectRepositoryMock,
            $clientRepositoryMock
        );

        $this->expectException(InvalidArgumentException::class);
        $service->deleteProject(1);
    }
}