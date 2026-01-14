<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Services\PhoneService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CountrySeeder extends Seeder
{
    /**
     * @var PhoneService
     */
    protected $phoneService;

    /**
     * Constructor - Inject PhoneService
     */
    public function __construct()
    {
        $this->phoneService = new PhoneService;
    }

    /**
     * Main seeder execution
     */
    public function run(): void
    {
        // Step 1: Fetch countries from REST Countries API
        $response = Http::withoutVerifying()
            ->timeout(30)
            ->get('https://restcountries.com/v3.1/all?fields=name,cca2,idd,flags');

        if (! $response->successful()) {
            // Log error if API fails
            $this->command->error('Failed to fetch countries from API');

            return;
        }

        $countriesData = $response->json();
        $totalCountries = count($countriesData);
        $processed = 0;
        $failed = 0;

        $this->command->info("Processing {$totalCountries} countries...");

        // Step 2: Process each country
        foreach ($countriesData as $country) {
            // Skip if missing essential data
            if (empty($country['cca2']) || empty($country['idd']['root'])) {
                $failed++;

                continue;
            }

            $iso2 = strtoupper($country['cca2']);

            // Step 3: Extract phone code
            $phoneCode = $country['idd']['root'];
            if (! empty($country['idd']['suffixes']) && ! empty($country['idd']['suffixes'][0])) {
                $phoneCode .= $country['idd']['suffixes'][0];
            }

            // Step 4: Get phone length using PhoneService
            $phoneLength = $this->phoneService->getPhoneLengthForCountry($iso2);

            // Step 5: Get example number (optional)
            $exampleNumber = $this->phoneService->getExampleNumber($iso2);

            // Step 6: Create or update country record
            Country::updateOrCreate(
                ['iso2' => strtolower($iso2)],
                [
                    'name' => $country['name']['common'],
                    'code' => $phoneCode,
                    'flag_url' => $country['flags']['png'] ?? null,
                    'phone_length' => $phoneLength,

                ]
            );

            $processed++;

            // Show progress
            if ($processed % 50 === 0) {
                $this->command->info("Processed {$processed}/{$totalCountries} countries...");
            }
        }

        // Step 7: Summary
        $this->command->info('✅ Country seeding completed!');
        $this->command->info("📊 Total in API: {$totalCountries}");
        $this->command->info("✅ Processed: {$processed}");
        $this->command->info("❌ Failed/Skipped: {$failed}");
        $this->command->info('💾 Saved in DB: '.Country::count());
    }
}
