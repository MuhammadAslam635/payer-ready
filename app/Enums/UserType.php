<?php

namespace App\Enums;

enum UserType: string
{
    case DOCTOR = 'doctor';                        // Doctor/Provider
    case ORGANIZATION = 'organization';            // Organization
    case SUPER_ADMIN = 'super_admin';              // Super admin
    case COORDINATOR = 'coordinator';              // Coordinator
    case ORGANIZATION_ADMIN = 'organization_admin'; // Organization admin

    public static function label(self $userType): string
    {
        return match($userType) {
            self::DOCTOR => 'Doctor',
            self::ORGANIZATION => 'Organization',
            self::SUPER_ADMIN => 'Super Admin',
            self::COORDINATOR => 'Coordinator',
            self::ORGANIZATION_ADMIN => 'Organization Admin',
        };
    }
    public static function values(): array
    {
        return [
            self::DOCTOR->value,
            self::ORGANIZATION->value,
            self::SUPER_ADMIN->value,
            self::COORDINATOR->value,
            self::ORGANIZATION_ADMIN->value,
        ];
    }

    public static function options(): array
    {
        return
        [
            self::DOCTOR->value => 'Doctor',
            self::ORGANIZATION->value => 'Organization',
            self::SUPER_ADMIN->value => 'Super Admin',
            self::COORDINATOR->value => 'Coordinator',
            self::ORGANIZATION_ADMIN->value => 'Organization Admin',
        ];
    }
    public static function cssClass(): array{
        return [
            self::DOCTOR => 'bg-green-500 text-white',
            self::ORGANIZATION => 'bg-cyan-500 text-white',
            self::SUPER_ADMIN => 'bg-teal-500 text-white',
            self::COORDINATOR => 'bg-indigo-500 text-white',
            self::ORGANIZATION_ADMIN->value => 'bg-purple-500 text-white',
            self::ORGANIZATION_ADMIN => 'bg-purple-500 text-white',
        ];
    }
}
