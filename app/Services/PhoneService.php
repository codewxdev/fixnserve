<?php

// app/Services/PhoneService.php

namespace App\Services;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;

class PhoneService
{
    /**
     * @var PhoneNumberUtil
     */
    protected $phoneUtil;

    /**
     * Constructor - Initialize the phone utility
     */
    public function __construct()
    {
        // Get singleton instance of PhoneNumberUtil
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    /**
     * Step 1: Validate a phone number for a specific country
     *
     * @param  string  $phone  The phone number to validate
     * @param  string  $countryCode  ISO2 country code (e.g., 'PK', 'US', 'GB')
     * @return array Validation result
     */
    public function validatePhone(string $phone, string $countryCode): array
    {
        try {
            // Parse the phone number with country code
            $phoneNumber = $this->phoneUtil->parse($phone, strtoupper($countryCode));

            // Check 1: Is it a valid number?
            $isValid = $this->phoneUtil->isValidNumber($phoneNumber);

            // Check 2: Is it a mobile number? (optional)
            $isMobile = $this->phoneUtil->getNumberType($phoneNumber) === PhoneNumberType::MOBILE;

            if (! $isValid) {
                return [
                    'valid' => false,
                    'message' => 'Invalid phone number format',
                ];
            }

            // Optional: You can require mobile numbers only
            if (! $isMobile) {
                return [
                    'valid' => false,
                    'message' => 'Please enter a mobile phone number',
                ];
            }

            // Format the phone number internationally
            $formatted = $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::INTERNATIONAL);

            // Get the national number (without country code)
            $nationalNumber = $this->phoneUtil->getNationalSignificantNumber($phoneNumber);

            return [
                'valid' => true,
                'formatted' => $formatted,           // e.g., "+92 300 1234567"
                'national_number' => $nationalNumber, // e.g., "3001234567"
                'country_code' => $phoneNumber->getCountryCode(), // e.g., 92
                'length' => strlen($nationalNumber),  // e.g., 10
            ];

        } catch (\libphonenumber\NumberParseException $e) {
            return [
                'valid' => false,
                'message' => 'Invalid phone number: '.$e->getMessage(),
            ];
        } catch (\Exception $e) {
            return [
                'valid' => false,
                'message' => 'Error validating phone: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Step 2: Get phone length for a country
     *
     * @param  string  $countryCode  ISO2 country code
     * @return int Phone length
     */
    public function getPhoneLengthForCountry(string $countryCode): int
    {
        try {
            // Get example number for the country
            $exampleNumber = $this->phoneUtil->getExampleNumber($countryCode);

            if ($exampleNumber) {
                // Extract national significant number
                $nationalNumber = $this->phoneUtil->getNationalSignificantNumber($exampleNumber);

                return strlen($nationalNumber);
            }
        } catch (\Exception $e) {
            // If library fails, use fallback
        }

        // Step 3: Fallback lengths for common countries
        return $this->getFallbackLength($countryCode);
    }

    /**
     * Step 3: Fallback phone lengths if library doesn't work
     */
    private function getFallbackLength(string $countryCode): int
    {
        $fallbackLengths = [
            // Asia
            'PK' => 10, // Pakistan: 10 digits (3001234567)
            'IN' => 10, // India: 10 digits
            'CN' => 11, // China: 11 digits
            'JP' => 10, // Japan: 10 digits

            // Middle East
            'AE' => 9,  // UAE: 9 digits
            'SA' => 9,  // Saudi Arabia: 9 digits
            'QA' => 8,  // Qatar: 8 digits

            // Europe
            'GB' => 10, // UK: 10 digits
            'DE' => 10, // Germany: 10 digits
            'FR' => 9,  // France: 9 digits

            // North America
            'US' => 10, // USA: 10 digits
            'CA' => 10, // Canada: 10 digits

            // Default
            'DEFAULT' => 10,
        ];

        return $fallbackLengths[strtoupper($countryCode)] ?? $fallbackLengths['DEFAULT'];
    }

    /**
     * Step 4: Get example phone number for a country
     *
     * @param  string  $countryCode  ISO2 country code
     * @return string|null Example phone number
     */
    public function getExampleNumber(string $countryCode): ?string
    {
        try {
            $exampleNumber = $this->phoneUtil->getExampleNumber($countryCode);

            if ($exampleNumber) {
                return $this->phoneUtil->format($exampleNumber, PhoneNumberFormat::INTERNATIONAL);
            }
        } catch (\Exception $e) {
            // Return null if no example
        }

        return null;
    }

    /**
     * Step 5: Format phone number nicely
     */
    public function formatPhone(string $phone, string $countryCode): ?string
    {
        try {
            $phoneNumber = $this->phoneUtil->parse($phone, $countryCode);

            return $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::INTERNATIONAL);
        } catch (\Exception $e) {
            return null;
        }
    }
}
