<?php

namespace App\Services;

use App\Models\Service;

class ServiceService
{
    /**
     * @var Service
     */
    protected $service;

    /**
     * ServiceService constructor.
     *
     * @param Service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Retrieve all services.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllServices()
    {
        return $this->service->all();
    }

    /**
     * Find a service by ID.
     *
     * @param int $id
     * @return Service|null
     */
    public function findServiceById(int $id): ?Service
    {
        return $this->service->find($id);
    }

    /**
     * Create a new service.
     *
     * @param array $data
     * @return Service
     */
    public function createService(array $data): Service
    {
        return $this->service->create($data);
    }

    /**
     * Update an existing service.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateService(int $id, array $data): bool
    {
        $service = $this->service->find($id);
        if ($service) {
            return $service->update($data);
        }
        return false;
    }

    /**
     * Delete a service by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteService(int $id): bool
    {
        $service = $this->service->find($id);
        if ($service) {
            return $service->delete();
        }
        return false;
    }
}
