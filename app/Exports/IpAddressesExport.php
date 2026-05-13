<?php

namespace App\Exports;
use App\Models\IpAddress;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IpAddressesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return IpAddress::all();
    }

    public function map($ip): array
    {
        return [
            $ip->id,
            $ip->ip,
            $ip->country,
            $ip->city,
            $ip->created_at->format('Y-m-d H:i'),
        ];
    }

    public function headings(): array
    {
        return ['ID', 'IP', 'Country', 'City', 'Created At'];
    }
}
