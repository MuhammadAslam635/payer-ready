<?php

namespace App\Enums;

enum CredentialRequest:string
{
     case ENROLLMENT_NEW = 'enrollment_new';
    case RE_CREDENTIALING = 'recredentialing';

    // Instance method to get label for current case
    public function label(): string
    {
        return match($this) {
            self::ENROLLMENT_NEW => 'Enrollment New',
            self::RE_CREDENTIALING => 'Re-Credentialing',
        };
    }
    public static function values():array{
        return [
            self::ENROLLMENT_NEW->value,
            self::RE_CREDENTIALING->value,
        ];
    }

    // Static method to get all options
    public static function options(): array
    {
        return [
            self::ENROLLMENT_NEW->value => self::ENROLLMENT_NEW->label(),
            self::RE_CREDENTIALING->value => self::RE_CREDENTIALING->label(),
        ];
    }

    // Instance method to get CSS class for current case
    public function cssClass(): string
    {
        return match($this) {
            self::ENROLLMENT_NEW => 'bg-green-500 text-white',
            self::RE_CREDENTIALING => 'bg-cyan-500 text-white',
        };
    }

    // Static method to get all CSS classes
    public static function cssClasses(): array
    {
        return [
            self::ENROLLMENT_NEW->value => self::ENROLLMENT_NEW->cssClass(),
            self::RE_CREDENTIALING->value => self::RE_CREDENTIALING->cssClass(),
        ];
    }
}
