<?php

namespace App\Http\Requests\Ip;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIpAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ip' => [
                'required',
                'ip',
                'unique:ip_addresses,ip,' . $this->ipAddress->id,
            ],
        ];
    }
}
