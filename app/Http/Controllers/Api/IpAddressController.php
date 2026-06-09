<?php

namespace App\Http\Controllers\Api;

use App\Exports\IpAddressesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ip\StoreIpAddressRequest;
use App\Http\Requests\Ip\UpdateIpAddressRequest;
use App\Http\Resources\IpAddressResource;
use App\Models\IpAddress;
use App\Services\IpManagementService;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;


class IpAddressController extends Controller
{
    public function __construct(
        private readonly IpManagementService $ipManagementService,
    ) {
    }

    public function index()
    {
        return IpAddressResource::collection(
            IpAddress::all()
        );
    }

    public function store(StoreIpAddressRequest $request): JsonResponse
    {
        $ipAddress = $this->ipManagementService->create(
            $request->validated('ip')
        );

        return (new IpAddressResource($ipAddress))
            ->response()
            ->setStatusCode(201);
    }

    public function show(IpAddress $ipAddress): IpAddressResource
    {
        return new IpAddressResource($ipAddress);
    }

    public function update(
        UpdateIpAddressRequest $request,
        IpAddress              $ipAddress
    ): IpAddressResource
    {
        $ip = $this->ipAddressService->update(
            $ipAddress,
            $request->validated()
        );

        return new IpAddressResource($ip);
    }

    public function destroy(IpAddress $ipAddress): JsonResponse
    {
        $this->ipAddressService->delete($ipAddress);

        return response()->json([
            'message' => 'Deleted'
        ]);
    }

    public function export()
    {
        return Excel::download(
            new IpAddressesExport,
            'ip-addresses.xlsx'
        );
    }
}
