<?php

namespace App\Domains\System\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Models\Country;
use Illuminate\Http\Request;

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

    public function updateLocale(Request $request, $iso2)
    {
        try {
            $country = Country::where('iso2', $iso2)->firstOrFail();

            $country->update([
                'default_language' => $request->default_language,
            ]);

            return $this->success($country->toArray(), 'success');
        } catch (\Exception $e) {
            return $this->notFound();
        }
    }

    public function updateCurrency(Request $request, $iso2)
    {
        try {
            $country = Country::where('iso2', $iso2)->firstOrFail();

            $country->update([
                'currency_code' => $request->currency_code,
            ]);

            return $this->success($country->toArray(), 'success');
        } catch (\Exception $e) {
            return $this->notFound();
        }
    }

    public function updateFormats(Request $request, $iso2)
    {
        try {
            $country = Country::where('iso2', $iso2)->firstOrFail();

            $country->update([
                'date_format' => $request->date_format,
                'decimal_separator' => $request->decimal_separator,
                'thousand_separator' => $request->thousand_separator,
            ]);

            return $this->success($country->toArray(), 'success');
        } catch (\Exception $e) {
            return $this->notFound();
        }
    }

    public function enableLocale($iso2)
    {
        try {
            Country::where('iso2', $iso2)->update(['status' => 'enabled']);

            return $this->success([], 'success');
        } catch (\Exception $e) {
            return $this->error('error');
        }
    }

    public function disableLocale($iso2)
    {
        try {
            Country::where('iso2', $iso2)->update(['status' => 'disabled']);

            return $this->success([], 'success');
        } catch (\Exception $e) {
            return $this->error('error');
        }
    }
}
