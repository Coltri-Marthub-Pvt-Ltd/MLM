<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
    ];

    protected $casts = [
        'value' => 'string',
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $cacheKey = "setting.{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }
            
            return static::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $type = 'string', $group = 'general', $label = null, $description = null)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => static::prepareValue($value, $type),
                'type' => $type,
                'group' => $group,
                'label' => $label,
                'description' => $description,
            ]
        );

        // Clear cache
        Cache::forget("setting.{$key}");
        
        return $setting;
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup($group)
    {
        $cacheKey = "settings.group.{$group}";
        
        return Cache::remember($cacheKey, 3600, function () use ($group) {
            return static::where('group', $group)
                ->get()
                ->mapWithKeys(function ($setting) {
                    return [
                        $setting->key => static::castValue($setting->value, $setting->type)
                    ];
                });
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        Cache::flush();
    }

    /**
     * Cast value to appropriate type
     */
    protected static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return (bool) $value;
            case 'integer':
                return (int) $value;
            case 'array':
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    /**
     * Prepare value for storage
     */
    protected static function prepareValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return $value ? '1' : '0';
            case 'array':
            case 'json':
                return json_encode($value);
            default:
                return (string) $value;
        }
    }

    /**
     * Get theme attributes for body tag
     */
    public static function getThemeAttributes()
    {
        $themeColor = static::get('theme_color', 'default');
        $fontFamily = static::get('font_family', 'inter');
        $colorMode = static::get('color_mode', 'light');
        $animationsEnabled = static::get('animations_enabled', true);

        return [
            'data-theme-color' => $themeColor,
            'data-font-family' => $fontFamily,
            'data-color-mode' => $colorMode,
            'data-animations' => $animationsEnabled ? 'true' : 'false',
        ];
    }

    /**
     * Get theme attributes as HTML string
     */
    public static function getThemeAttributesString()
    {
        $attributes = static::getThemeAttributes();
        
        return collect($attributes)->map(function ($value, $key) {
            return "{$key}=\"{$value}\"";
        })->implode(' ');
    }

    /**
     * Boot method to clear cache on model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            static::clearCache();
        });

        static::deleted(function () {
            static::clearCache();
        });
    }
}
