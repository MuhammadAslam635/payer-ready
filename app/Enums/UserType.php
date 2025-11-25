<?php

namespace App\Enums;

enum UserType: string
{
    case DOCTOR = 'doctor';                        // Doctor/Provider
    case SUPER_ADMIN = 'super_admin';              // Super admin
    case COORDINATOR = 'coordinator';              // Coordinator
    case ORGANIZATION_ADMIN = 'organization_admin'; // Organization admin
    case ORGANIZATION_COORDINATOR = 'organization_coordinator'; // Organization coordinator

    public static function label(self $userType): string
    {
        return match($userType) {
            self::DOCTOR => 'Provider',
            self::ORGANIZATION_ADMIN => 'Organization Admin',
            self::SUPER_ADMIN => 'Super Admin',
            self::COORDINATOR => 'Coordinator',
            self::ORGANIZATION_COORDINATOR => 'Organization Coordinator',
        };
    }
    public static function values(): array
    {
        return [
            self::DOCTOR->value,
            self::ORGANIZATION_COORDINATOR->value,
            self::SUPER_ADMIN->value,
            self::COORDINATOR->value,
            self::ORGANIZATION_ADMIN->value,
        ];
    }

    public static function options(): array
    {
        return
        [
            self::DOCTOR->value => 'Provider',
            self::ORGANIZATION_COORDINATOR->value => 'Organization Coordinator',
            self::SUPER_ADMIN->value => 'Super Admin',
            self::COORDINATOR->value => 'Coordinator',
            self::ORGANIZATION_ADMIN->value => 'Organization Admin',
        ];
    }
    public static function cssClass(): array{
        return [
            self::DOCTOR->value => 'bg-green-500 text-white',
            self::ORGANIZATION_COORDINATOR->value => 'bg-cyan-500 text-white',
            self::SUPER_ADMIN->value => 'bg-teal-500 text-white',
            self::COORDINATOR->value => 'bg-indigo-500 text-white',
            self::ORGANIZATION_ADMIN->value => 'bg-purple-500 text-white',
        ];
    }
}
