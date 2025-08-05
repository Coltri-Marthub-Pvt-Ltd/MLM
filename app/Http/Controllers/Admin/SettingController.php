<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        $settings = [
            'theme' => Setting::getByGroup('theme'),
            'appearance' => Setting::getByGroup('appearance'),
        ];

        // Define available options
        $options = [
            'themes' => [
                'default' => 'Default Blue',
                'green' => 'Nature Green',
                'purple' => 'Royal Purple',
                'red' => 'Bold Red',
                'black' => 'Elegant Black',
                'teal' => 'Ocean Teal',
                'pink' => 'Soft Pink',
                'indigo' => 'Deep Indigo',
            ],
            'fonts' => [
                'inter' => 'Inter (Default)',
                'roboto' => 'Roboto',
                'opensans' => 'Open Sans',
                'lato' => 'Lato',
                'poppins' => 'Poppins',
                'nunito' => 'Nunito',
                'sourcesans' => 'Source Sans Pro',
                'montserrat' => 'Montserrat',
            ],
            'modes' => [
                'light' => 'Light Mode',
                'dark' => 'Dark Mode',
                'auto' => 'Auto (System)',
            ]
        ];

        return view('admin.settings.index', compact('settings', 'options'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'theme_color' => 'required|string|in:default,green,purple,red,black,teal,pink,indigo',
            'font_family' => 'required|string|in:inter,roboto,opensans,lato,poppins,nunito,sourcesans,montserrat',
            'color_mode' => 'required|string|in:light,dark,auto',
            'sidebar_collapsed' => 'boolean',
            'animations_enabled' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update theme settings
        Setting::set('theme_color', $request->theme_color, 'string', 'theme', 'Theme Color', 'Primary color theme for the admin panel');
        Setting::set('font_family', $request->font_family, 'string', 'theme', 'Font Family', 'Font family for the admin panel');
        Setting::set('color_mode', $request->color_mode, 'string', 'theme', 'Color Mode', 'Light, dark, or auto mode');

        // Update appearance settings
        Setting::set('sidebar_collapsed', $request->has('sidebar_collapsed'), 'boolean', 'appearance', 'Sidebar Collapsed', 'Default sidebar state');
        Setting::set('animations_enabled', $request->has('animations_enabled'), 'boolean', 'appearance', 'Animations Enabled', 'Enable UI animations');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }

    /**
     * Reset settings to default
     */
    public function reset()
    {
        // Reset to default values
        Setting::set('theme_color', 'default', 'string', 'theme', 'Theme Color', 'Primary color theme for the admin panel');
        Setting::set('font_family', 'inter', 'string', 'theme', 'Font Family', 'Font family for the admin panel');
        Setting::set('color_mode', 'light', 'string', 'theme', 'Color Mode', 'Light, dark, or auto mode');
        Setting::set('sidebar_collapsed', false, 'boolean', 'appearance', 'Sidebar Collapsed', 'Default sidebar state');
        Setting::set('animations_enabled', true, 'boolean', 'appearance', 'Animations Enabled', 'Enable UI animations');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings reset to default values!');
    }
}
