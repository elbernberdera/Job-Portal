<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'description'];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        $setting = Cache::rememberForever("setting.{$key}", function () use ($key) {
            return static::where('key', $key)->first();
        });

        if (!$setting) {
            return $default;
        }

        return static::castValue($setting->value, $setting->type);
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return false;
        }

        $setting->value = (string) $value;
        $setting->save();

        Cache::forget("setting.{$key}");
        
        return true;
    }

    /**
     * Cast the value to its proper type
     */
    protected static function castValue($value, ?string $type)
    {
        // If type is null, default to string
        if ($type === null) {
            return $value;
        }

        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }
} 