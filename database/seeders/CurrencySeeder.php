<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $url = 'https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies.json';

        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $code => $name) {
                $code = strtoupper(substr($code, 0, 3)); // ensure max 3 chars
                Currency::updateOrCreate(
                    ['code' => $code],
                    ['name' => $name, 'symbol' => null]
                );
            }

            $this->command->info('Currencies imported successfully!');
        } else {
            $this->command->error('Failed to fetch currency list.');
        }
    }
}
