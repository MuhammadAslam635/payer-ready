<?php

namespace App\Enums;

enum RelationshipType: string
{
    case SUPERVISOR = 'supervisor';
    case COLLEAGUE = 'colleague';
    case PEER = 'peer';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::SUPERVISOR => 'Supervisor',
            self::COLLEAGUE => 'Colleague',
            self::PEER => 'Peer',
            self::OTHER => 'Other',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
