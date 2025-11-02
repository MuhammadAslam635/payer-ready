<?php

namespace App\Livewire\Components;

use App\Enums\UserType;
use App\Models\Organization;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public $user;
    public $organization;
    public $teams = [];
    public $currentTeam = null;

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadUserData();
    }

    public function loadUserData()
    {
        if ($this->user) {
            // Load organization if user is organizational
            if (in_array($this->user->user_type, [UserType::ORGANIZATIONAL_MANAGER, UserType::ORGANIZATIONAL_STAFF])) {
                $this->organization = $this->user->organizationStaff->first()?->organization;

                // Load teams for organizational users
                if ($this->organization) {
                    $this->teams = $this->organization->teams ?? collect();
                }
            }
        }
    }

    public function getNavigationItems()
    {
        if (!$this->user) {
            return [];
        }

        $baseItems = [
            [
                'name' => 'Overview',
                'icon' => 'chart-pie',
                'route' => 'dashboard',
                'permissions' => ['all']
            ],
            [
                'name' => 'My Tasks',
                'icon' => 'clipboard-document-list',
                'route' => 'dashboard',
                'permissions' => ['all']
            ]
        ];

        // Add role-specific navigation items
        switch ($this->user->user_type) {
            case UserType::PROVIDER:
                return array_merge($baseItems, [
                    [
                        'name' => 'My Profile',
                        'icon' => 'user',
                        'route' => 'doctor.profile',
                        'permissions' => ['provider']
                    ],
                    [
                        'name' => 'Applications',
                        'icon' => 'document-text',
                        'route' => 'doctor.applications',
                        'permissions' => ['provider']
                    ],
                    [
                        'name' => 'Licenses',
                        'icon' => 'identification',
                        'route' => 'doctor.licensing',
                        'permissions' => ['provider']
                    ],
                    [
                        'name' => 'Expirables',
                        'icon' => 'calendar-days',
                        'route' => 'doctor.expirables',
                        'permissions' => ['provider']
                    ]
                ]);

            case UserType::ORGANIZATIONAL_MANAGER:
                return array_merge($baseItems, [
                    [
                        'name' => 'Providers',
                        'icon' => 'users',
                        'route' => 'dashboard',
                        'permissions' => ['organizational_manager', 'organizational_staff']
                    ],
                    [
                        'name' => 'Applications',
                        'icon' => 'document-text',
                        'route' => 'dashboard',
                        'permissions' => ['organizational_manager', 'organizational_staff']
                    ],
                    [
                        'name' => 'Licensing',
                        'icon' => 'identification',
                        'route' => 'dashboard',
                        'permissions' => ['organizational_manager', 'organizational_staff']
                    ],
                    [
                        'name' => 'Expirables',
                        'icon' => 'calendar-days',
                        'route' => 'dashboard',
                        'permissions' => ['organizational_manager', 'organizational_staff']
                    ],
                    [
                        'name' => 'Reporting',
                        'icon' => 'chart-bar',
                        'route' => 'dashboard',
                        'permissions' => ['organizational_manager']
                    ],
                    [
                        'name' => 'Team Management',
                        'icon' => 'user-group',
                            'route' => 'dashboard',
                        'permissions' => ['organizational_manager']
                    ]
                ]);

            case UserType::ORGANIZATIONAL_STAFF:
                return array_merge($baseItems, [
                    [
                        'name' => 'Providers',
                        'icon' => 'users',
                        'route' => 'dashboard',
                        'permissions' => ['organizational_staff']
                    ],
                    [
                        'name' => 'Applications',
                        'icon' => 'document-text',
                        'route' => 'dashboard',
                        'permissions' => ['organizational_staff']
                    ],
                    [
                        'name' => 'Licensing',
                        'icon' => 'identification',
                        'route' => 'dashboard',
                        'permissions' => ['organizational_staff']
                    ],
                    [
                        'name' => 'Expirables',
                        'icon' => 'calendar-days',
                        'route' => 'dashboard',
                        'permissions' => ['organizational_staff']
                    ]
                ]);

            case UserType::SUPER_ADMIN:
                return array_merge($baseItems, [
                    [
                        'name' => 'Organizations',
                        'icon' => 'building-office-2',
                        'route' => 'dashboard',
                        'permissions' => ['super_admin']
                    ],
                    [
                        'name' => 'All Providers',
                        'icon' => 'users',
                        'route' => 'dashboard',
                        'permissions' => ['super_admin']
                    ],
                    [
                        'name' => 'System Settings',
                        'icon' => 'cog-6-tooth',
                        'route' => 'dashboard',
                        'permissions' => ['super_admin']
                    ],
                    [
                        'name' => 'Reports',
                        'icon' => 'chart-bar',
                        'route' => 'dashboard',
                        'permissions' => ['super_admin']
                    ]
                ]);

            default:
                return $baseItems;
        }
    }

    public function canAccess($permissions)
    {
        if (in_array('all', $permissions)) {
            return true;
        }

        return in_array($this->user->user_type->value, $permissions);
    }

    public function render()
    {
        $navigationItems = collect($this->getNavigationItems())
            ->filter(fn($item) => $this->canAccess($item['permissions']))
            ->toArray();

        return view('livewire.components.sidebar', [
            'navigationItems' => $navigationItems
        ]);
    }
}
