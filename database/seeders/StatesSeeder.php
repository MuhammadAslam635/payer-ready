<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['code' => 'AL', 'name' => 'Alabama', 'country' => 'US', 'is_active' => true],
            ['code' => 'AK', 'name' => 'Alaska', 'country' => 'US', 'is_active' => true],
            ['code' => 'AZ', 'name' => 'Arizona', 'country' => 'US', 'is_active' => true],
            ['code' => 'AR', 'name' => 'Arkansas', 'country' => 'US', 'is_active' => true],
            ['code' => 'CA', 'name' => 'California', 'country' => 'US', 'is_active' => true],
            ['code' => 'CO', 'name' => 'Colorado', 'country' => 'US', 'is_active' => true],
            ['code' => 'CT', 'name' => 'Connecticut', 'country' => 'US', 'is_active' => true],
            ['code' => 'DE', 'name' => 'Delaware', 'country' => 'US', 'is_active' => true],
            ['code' => 'FL', 'name' => 'Florida', 'country' => 'US', 'is_active' => true],
            ['code' => 'GA', 'name' => 'Georgia', 'country' => 'US', 'is_active' => true],
            ['code' => 'HI', 'name' => 'Hawaii', 'country' => 'US', 'is_active' => true],
            ['code' => 'ID', 'name' => 'Idaho', 'country' => 'US', 'is_active' => true],
            ['code' => 'IL', 'name' => 'Illinois', 'country' => 'US', 'is_active' => true],
            ['code' => 'IN', 'name' => 'Indiana', 'country' => 'US', 'is_active' => true],
            ['code' => 'IA', 'name' => 'Iowa', 'country' => 'US', 'is_active' => true],
            ['code' => 'KS', 'name' => 'Kansas', 'country' => 'US', 'is_active' => true],
            ['code' => 'KY', 'name' => 'Kentucky', 'country' => 'US', 'is_active' => true],
            ['code' => 'LA', 'name' => 'Louisiana', 'country' => 'US', 'is_active' => true],
            ['code' => 'ME', 'name' => 'Maine', 'country' => 'US', 'is_active' => true],
            ['code' => 'MD', 'name' => 'Maryland', 'country' => 'US', 'is_active' => true],
            ['code' => 'MA', 'name' => 'Massachusetts', 'country' => 'US', 'is_active' => true],
            ['code' => 'MI', 'name' => 'Michigan', 'country' => 'US', 'is_active' => true],
            ['code' => 'MN', 'name' => 'Minnesota', 'country' => 'US', 'is_active' => true],
            ['code' => 'MS', 'name' => 'Mississippi', 'country' => 'US', 'is_active' => true],
            ['code' => 'MO', 'name' => 'Missouri', 'country' => 'US', 'is_active' => true],
            ['code' => 'MT', 'name' => 'Montana', 'country' => 'US', 'is_active' => true],
            ['code' => 'NE', 'name' => 'Nebraska', 'country' => 'US', 'is_active' => true],
            ['code' => 'NV', 'name' => 'Nevada', 'country' => 'US', 'is_active' => true],
            ['code' => 'NH', 'name' => 'New Hampshire', 'country' => 'US', 'is_active' => true],
            ['code' => 'NJ', 'name' => 'New Jersey', 'country' => 'US', 'is_active' => true],
            ['code' => 'NM', 'name' => 'New Mexico', 'country' => 'US', 'is_active' => true],
            ['code' => 'NY', 'name' => 'New York', 'country' => 'US', 'is_active' => true],
            ['code' => 'NC', 'name' => 'North Carolina', 'country' => 'US', 'is_active' => true],
            ['code' => 'ND', 'name' => 'North Dakota', 'country' => 'US', 'is_active' => true],
            ['code' => 'OH', 'name' => 'Ohio', 'country' => 'US', 'is_active' => true],
            ['code' => 'OK', 'name' => 'Oklahoma', 'country' => 'US', 'is_active' => true],
            ['code' => 'OR', 'name' => 'Oregon', 'country' => 'US', 'is_active' => true],
            ['code' => 'PA', 'name' => 'Pennsylvania', 'country' => 'US', 'is_active' => true],
            ['code' => 'RI', 'name' => 'Rhode Island', 'country' => 'US', 'is_active' => true],
            ['code' => 'SC', 'name' => 'South Carolina', 'country' => 'US', 'is_active' => true],
            ['code' => 'SD', 'name' => 'South Dakota', 'country' => 'US', 'is_active' => true],
            ['code' => 'TN', 'name' => 'Tennessee', 'country' => 'US', 'is_active' => true],
            ['code' => 'TX', 'name' => 'Texas', 'country' => 'US', 'is_active' => true],
            ['code' => 'UT', 'name' => 'Utah', 'country' => 'US', 'is_active' => true],
            ['code' => 'VT', 'name' => 'Vermont', 'country' => 'US', 'is_active' => true],
            ['code' => 'VA', 'name' => 'Virginia', 'country' => 'US', 'is_active' => true],
            ['code' => 'WA', 'name' => 'Washington', 'country' => 'US', 'is_active' => true],
            ['code' => 'WV', 'name' => 'West Virginia', 'country' => 'US', 'is_active' => true],
            ['code' => 'WI', 'name' => 'Wisconsin', 'country' => 'US', 'is_active' => true],
            ['code' => 'WY', 'name' => 'Wyoming', 'country' => 'US', 'is_active' => true],
            // US Territories
            ['code' => 'AS', 'name' => 'American Samoa', 'country' => 'US', 'is_active' => true],
            ['code' => 'DC', 'name' => 'District of Columbia', 'country' => 'US', 'is_active' => true],
            ['code' => 'FM', 'name' => 'Federated States of Micronesia', 'country' => 'US', 'is_active' => true],
            ['code' => 'GU', 'name' => 'Guam', 'country' => 'US', 'is_active' => true],
            ['code' => 'MH', 'name' => 'Marshall Islands', 'country' => 'US', 'is_active' => true],
            ['code' => 'MP', 'name' => 'Northern Mariana Islands', 'country' => 'US', 'is_active' => true],
            ['code' => 'PW', 'name' => 'Palau', 'country' => 'US', 'is_active' => true],
            ['code' => 'PR', 'name' => 'Puerto Rico', 'country' => 'US', 'is_active' => true],
            ['code' => 'VI', 'name' => 'Virgin Islands', 'country' => 'US', 'is_active' => true],
        ];

        foreach ($states as $state) {
            State::updateOrCreate(
                ['code' => $state['code']],
                $state
            );
        }
    }
}
