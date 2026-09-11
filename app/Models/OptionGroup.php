<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class OptionGroup extends Model
{
    use LogsActivity;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'selection_type',
        'min_selection',
        'max_selection',
        'is_active',
        'is_required',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_required' => 'boolean',
        'min_selection' => 'integer',
        'max_selection' => 'integer',
    ];

    /**
     * Get the options for the option group.
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    /**
     * Get the products that have this option group.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_option_groups')
            ->withPivot('sort_order')
            ->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'description', 'selection_type', 'min_selection', 'max_selection', 'is_active', 'is_required'])
            ->logOnlyDirty()
            ->useLogName('option_group')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => "Created option group: {$this->name}",
                'updated' => $this->wasChanged('is_active') 
                    ? "Changed option group {$this->name} status to " . ($this->is_active ? 'active' : 'inactive')
                    : "Updated option group: {$this->name}",
                'deleted' => "Deleted option group: {$this->name}",
                default => "{$eventName} option group: {$this->name}",
            });
    }
}
