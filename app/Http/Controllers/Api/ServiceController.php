<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    /**
     * @var ServiceService
     */
    protected $serviceService;

    /**
     * ServiceController constructor.
     *
     * @param ServiceService $serviceService
     */
    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    /**
     * Display a listing of the services.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $services = $this->serviceService->getAllServices();
        return response()->json($services);
    }

    /**
     * Store a newly created service in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $service = $this->serviceService->createService($request->all());
        return response()->json($service, 201);
    }

    /**
     * Display the specified service.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $service = $this->serviceService->findServiceById($id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        return response()->json($service);
    }

    /**
     * Update the specified service in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $updated = $this->serviceService->updateService($id, $request->all());

        if (!$updated) {
            return response()->json(['message' => 'Service not found or could not be updated'], 404);
        }

        return response()->json(['message' => 'Service updated successfully']);
    }

    /**
     * Remove the specified service from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->serviceService->deleteService($id);

        if (!$deleted) {
            return response()->json(['message' => 'Service not found or could not be deleted'], 404);
        }

        return response()->json(['message' => 'Service deleted successfully']);
    }
}
