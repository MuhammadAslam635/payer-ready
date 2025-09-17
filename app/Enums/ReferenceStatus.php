<?php

namespace App\Enums;

enum ReferenceStatus: string
{
    case PENDING = 'pending';
    case CONTACTED = 'contacted';
    case COMPLETED = 'completed';
    case DECLINED = 'declined';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::CONTACTED => 'Contacted',
            self::COMPLETED => 'Completed',
            self::DECLINED => 'Declined',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
