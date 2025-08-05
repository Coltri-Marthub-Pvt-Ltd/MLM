<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Theme Settings
        Setting::set('theme_color', 'default', 'string', 'theme', 'Theme Color', 'Primary color theme for the admin panel');
        Setting::set('font_family', 'inter', 'string', 'theme', 'Font Family', 'Font family for the admin panel');
        Setting::set('color_mode', 'light', 'string', 'theme', 'Color Mode', 'Light, dark, or auto mode');

        // Appearance Settings  
        Setting::set('sidebar_collapsed', false, 'boolean', 'appearance', 'Sidebar Collapsed', 'Default sidebar state');
        Setting::set('animations_enabled', true, 'boolean', 'appearance', 'Animations Enabled', 'Enable UI animations');

        $this->command->info('Settings seeded successfully!');
    }
}
