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
        'middle_name',
        'email',
        'password',
        'taxnomy_code',
        'user_type',
        'is_admin',
        'is_active',
        'phone',
        'ssn_encrypted',
        'date_of_birth',
        'npi_number',
        'caqh_id',
        'caqh_login',
        'caqh_password',
        'pecos_login',
        'pecos_password',
        'dea_number',
        'dea_expiration_date',
        'current_team_id',
        'profile_photo_path',
        'specialty_id',
        'state_id',
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
     * Get the organization this user belongs to through organization staff
     */
    public function organization()
    {
        return $this->belongsToMany(Organization::class, 'organization_staff')
                    ->withPivot(['role_id', 'position_title', 'department', 'start_date', 'end_date', 'is_active', 'is_primary'])
                    ->withTimestamps()
                    ->wherePivot('is_active', true)
                    ->wherePivot('is_primary', true);
    }

    /**
     * Get all licenses for this user through doctor profile
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(DoctorLicense::class);
    }

    /**
     * Get all work history for this user through doctor profile
     */
    public function workHistory(): HasMany
    {
        return $this->hasMany(DoctorWorkHistory::class);
    }



    /**
     * Get all documents for this user through doctor profile
     */
    public function documents(): HasMany
    {
        return $this->hasMany(DoctorDocument::class);
    }

    public function addresses():HasMany{
        return $this->hasMany(Address::class);
    }

    /**
     * Get all doctor specialties
     */
    public function specialties(): BelongsToMany
    {
        return $this->belongsToMany(Specialty::class, 'doctor_specialties')
                    ->withPivot(['is_primary'])
                    ->withTimestamps();
    }

    /**
     * Get all doctor certificates through doctor profile
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(DoctorCertificate::class);
    }

    /**
     * Get all doctor tasks
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(DoctorTask::class);
    }
    /**
     * Get all professional references for this doctor
     */
    public function professionalReferences(): HasMany
    {
        return $this->hasMany(DoctorReference::class);
    }
    /**
     * Check if user is a doctor
     */
    public function isDoctor(): bool
    {
        return $this->user_type === UserType::DOCTOR;
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
     * Get all transactions for this doctor
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the doctor's full name
     */
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    /**
     * Get the doctor's display name with type
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name . ' (' . UserType::label($this->user_type) . ')';
    }

    /**
     * Check if doctor has a doctor profile
     */
    public function hasDoctorProfile(): bool
    {
        return $this->doctorProfile()->exists();
    }

    /**
     * Check if doctor has any organizations
     */
    public function hasOrganization(): bool
    {
        return $this->organization()->exists();
    }

    /**
        * Get the doctor's primary organization
     */
    // public function getPrimaryOrganizationAttribute()
    // {
    //     return $this->organization()->first();
    // }
}
