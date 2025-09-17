<?php

namespace App\Enums;

enum CoverageType: string
{
    case OCCURRENCE = 'occurrence';
    case CLAIMS_MADE = 'claims_made';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::OCCURRENCE => 'Occurrence',
            self::CLAIMS_MADE => 'Claims Made',
            self::OTHER => 'Other',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
    public static function cssClass(): array{
        return [
            self::OCCURRENCE->value => 'bg-green-500 text-white',
            self::CLAIMS_MADE->value => 'bg-cyan-500 text-white',
            self::OTHER->value => 'bg-indigo-500 text-white',
        ];
    }
}
