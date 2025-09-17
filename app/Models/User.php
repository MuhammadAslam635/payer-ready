<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'user_type' => UserType::class,
        ];
    }

    /**
     * Get the doctor profile for this user
     */
    public function doctorProfile(): HasOne
    {
        return $this->hasOne(DoctorProfile::class);
    }

    /**
     * Get all organizations this user belongs to
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_staff')
                    ->withPivot(['role_id', 'position_title', 'department', 'start_date', 'end_date', 'is_active', 'is_primary'])
                    ->withTimestamps();
    }

    /**
     * Get the primary organization for this user
     */
    public function primaryOrganization()
    {
        return $this->organizations()->wherePivot('is_primary', true);
    }

    /**
     * Get all organization staff records for this user
     */
    public function organizationStaff(): HasMany
    {
        return $this->hasMany(OrganizationStaff::class);
    }

    /**
     * Get all licenses for this user through doctor profile
     */
    public function licenses(): HasMany
    {
        return $this->hasManyThrough(DoctorLicense::class, DoctorProfile::class);
    }

    /**
     * Get all work history for this user through doctor profile
     */
    public function workHistory(): HasMany
    {
        return $this->hasManyThrough(DoctorWorkHistory::class, DoctorProfile::class);
    }

    /**
     * Get all professional references for this user through doctor profile
     */
    public function professionalReferences(): HasMany
    {
        return $this->hasManyThrough(DoctorReference::class, DoctorProfile::class);
    }

    /**
     * Get all documents for this user through doctor profile
     */
    public function documents(): HasMany
    {
        return $this->hasManyThrough(DoctorDocument::class, DoctorProfile::class);
    }

    /**
     * Get all user specialties
     */
    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'user_specialties');
    }

    /**
     * Get all user certificates through doctor profile
     */
    public function certificates(): HasMany
    {
        return $this->hasManyThrough(DoctorCertificate::class, DoctorProfile::class);
    }

    /**
     * Get all user tasks through doctor profile
     */
    public function tasks(): HasMany
    {
        return $this->hasManyThrough(DoctorTask::class, DoctorProfile::class);
    }
    /**
     * Check if user is a doctor
     */
    public function isDoctor(): bool
    {
        return $this->user_type === UserType::DOCTOR;
    }

    /**
     * Check if user is a clinic manager
     */
    public function isClinicManager(): bool
    {
        return $this->user_type === UserType::CLINIC_MANAGER && $this->is_admin;
    }

    /**
     * Check if user is clinic staff
     */
    public function isClinicStaff(): bool
    {
        return $this->user_type === UserType::CLINIC_STAFF;
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->user_type === UserType::SUPER_ADMIN;
    }

    /**
     * Check if user is coordinator
     */
    public function isCoordinator(): bool
    {
        return $this->user_type === UserType::COORDINATOR;
    }
    /**
     * Get all transactions for this user
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the user's full name
     */
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    /**
     * Get the user's display name with type
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name . ' (' . $this->user_type->label() . ')';
    }

    /**
     * Check if user has a doctor profile
     */
    public function hasDoctorProfile(): bool
    {
        return $this->doctorProfile()->exists();
    }

    /**
     * Check if user has any organizations
     */
    public function hasOrganizations(): bool
    {
        return $this->organizations()->exists();
    }

    /**
     * Check if user has a primary organization
     */
    public function hasPrimaryOrganization(): bool
    {
        return $this->primaryOrganization()->exists();
    }

    /**
     * Get the user's primary organization
     */
    public function getPrimaryOrganizationAttribute()
    {
        return $this->primaryOrganization()->first();
    }

    /**
     * Get the clinic associated with this user (for doctors/providers)
     */
    public function clinic(): HasOne
    {
        return $this->hasOne(Clinic::class);
    }

    /**
     * Check if user has a clinic
     */
    public function hasClinic(): bool
    {
        return $this->clinic()->exists();
    }
}
