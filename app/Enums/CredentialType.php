<?php

namespace App\Enums;

enum CredentialType: string
{
    case LICENSE = 'license';
    case CERTIFICATE = 'certificate';
    case EDUCATION = 'education';
    case TRAINING = 'training';
    case INSURANCE = 'insurance';

    // Instance method to get label for current case
    public function label(): string
    {
        return match($this) {
            self::LICENSE => 'License',
            self::CERTIFICATE => 'Certificate',
            self::EDUCATION => 'Education',
            self::TRAINING => 'Training',
            self::INSURANCE => 'Insurance',
        };
    }
    public static function values():array{
        return [
            self::LICENSE->value,
            self::CERTIFICATE->value,
            self::EDUCATION->value,
            self::TRAINING->value,
            self::INSURANCE->value,
        ];
    }

    // Static method to get all options
    public static function options(): array
    {
        return [
            self::LICENSE->value => self::LICENSE->label(),
            self::CERTIFICATE->value => self::CERTIFICATE->label(),
            self::EDUCATION->value => self::EDUCATION->label(),
            self::TRAINING->value => self::TRAINING->label(),
            self::INSURANCE->value => self::INSURANCE->label(),
        ];
    }

    // Instance method to get CSS class for current case
    public function cssClass(): string
    {
        return match($this) {
            self::LICENSE => 'bg-green-500 text-white',
            self::CERTIFICATE => 'bg-cyan-500 text-white',
            self::EDUCATION => 'bg-yellow-500 text-white',
            self::TRAINING => 'bg-teal-500 text-white',
            self::INSURANCE => 'bg-teal-700 text-white',
        };
    }

    // Static method to get all CSS classes
    public static function cssClasses(): array
    {
        return [
            self::LICENSE->value => self::LICENSE->cssClass(),
            self::CERTIFICATE->value => self::CERTIFICATE->cssClass(),
            self::EDUCATION->value => self::EDUCATION->cssClass(),
            self::TRAINING->value => self::TRAINING->cssClass(),
            self::INSURANCE->value => self::INSURANCE->cssClass(),
        ];
    }
}
