<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::withoutVerifying()
            ->timeout(30)
            ->get('https://restcountries.com/v3.1/all?fields=name,cca2,idd,flags');

        if (! $response->successful()) {
            dd($response->status(), $response->body());
        }

        foreach ($response->json() as $country) {

            if (
                empty($country['cca2']) ||
                empty($country['idd']['root']) ||
                empty($country['idd']['suffixes'][0])
            ) {
                continue;
            }

            Country::updateOrCreate(
                ['iso2' => strtolower($country['cca2'])],
                [
                    'name' => $country['name']['common'],
                    'phone_code' => $country['idd']['root'].$country['idd']['suffixes'][0],
                    'flag_url' => $country['flags']['png'] ?? null,
                ]
            );
        }
    }
}
