<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiFromRequest;


class StoreHetznerAccount extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'token' => 'required',
            'maxServerPerRequest' => 'required|integer',
        ];
    }
}
