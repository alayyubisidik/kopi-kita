<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Option extends Model
{
    use LogsActivity;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'option_group_id',
        'name',
        'additional_price',
        'is_available',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_available' => 'boolean',
        'additional_price' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    /**
     * Get the option group that owns the option.
     */
    public function optionGroup()
    {
        return $this->belongsTo(OptionGroup::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['option_group_id', 'name', 'additional_price', 'is_available', 'sort_order'])
            ->logOnlyDirty()
            ->useLogName('option')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => "Created option: {$this->name}",
                'updated' => $this->wasChanged('is_available') 
                    ? "Changed option {$this->name} availability to " . ($this->is_available ? 'available' : 'unavailable')
                    : "Updated option: {$this->name}",
                'deleted' => "Deleted option: {$this->name}",
                default => "{$eventName} option: {$this->name}",
            });
    }
}
