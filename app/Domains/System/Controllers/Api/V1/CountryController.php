<?php

namespace App\Domains\System\Controllers\Api\V1;

use App\Http\Controllers\BaseApiController;
use App\Models\Country;

class CountryController extends BaseApiController
{
    public function index()
    {
        try {
            $countries = Country::select(
                'name',
                'iso2',
                'default_language',
                'currency_code',
                'decimal_separator',
                'thousand_separator',
                'date_format',
                'status'
            )->get();

            if ($countries->isEmpty()) {
                return $this->notFound();
            }

            return $this->success($countries);
        } catch (\Exception $e) {
            return $this->error('error');
        }
    }
}
