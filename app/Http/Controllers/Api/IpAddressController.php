<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\GeoServiceException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ip\StoreIpAddressRequest;
use App\Http\Requests\Ip\UpdateIpAddressRequest;
use App\Http\Resources\IpAddressResource;
use App\Models\IpAddress;
use App\Services\IpAddressService;
use App\Services\IpGeoService;
use Illuminate\Http\JsonResponse;
use App\Exports\IpAddressesExport;
use Maatwebsite\Excel\Facades\Excel;


class IpAddressController extends Controller
{
    public function __construct(
        private readonly IpGeoService     $geoService,
        private readonly IpAddressService $ipAddressService,
    )
    {
    }

    public function index()
    {
        return IpAddressResource::collection(
            IpAddress::all()
        );
    }

    public function store(StoreIpAddressRequest $request): JsonResponse
    {
        $ip = $request->validated('ip');

        try {
            $geo = $this->geoService->getGeoData($ip);
        } catch (GeoServiceException $e) {
            $geo = [
                'country' => null,
                'city' => null,
            ];
        }

        $ip = $this->ipAddressService->create($ip, $geo);

        return (new IpAddressResource($ip))
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
