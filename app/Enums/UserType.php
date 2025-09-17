<?php

namespace App\Enums;

enum UserType: string
{
    case DOCTOR = 'doctor';                        // Doctor/Provider
    case ORGANIZATION = 'organization';            // Organization
    case SUPER_ADMIN = 'super_admin';              // Super admin
    case COORDINATOR = 'coordinator';              // Coordinator
    case ORGANIZATION_ADMIN = 'organization_admin'; // Organization admin

    public function label(): string
    {
        return match($this) {
            self::DOCTOR => 'Doctor',
            self::ORGANIZATION => 'Organization',
            self::SUPER_ADMIN => 'Super Admin',
            self::COORDINATOR => 'Coordinator',
            self::ORGANIZATION_ADMIN => 'Organization Admin',
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
            self::DOCTOR->value => 'bg-green-500 text-white',
            self::ORGANIZATION->value => 'bg-cyan-500 text-white',
            self::SUPER_ADMIN->value => 'bg-teal-500 text-white',
            self::COORDINATOR->value => 'bg-indigo-500 text-white',
            self::ORGANIZATION_ADMIN->value => 'bg-purple-500 text-white',
        ];
    }
}
