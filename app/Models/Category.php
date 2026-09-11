<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Category extends Model
{
    use LogsActivity;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'slug', 'description', 'is_active', 'sort_order'])
            ->logOnlyDirty()
            ->useLogName('category')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => "Created category: {$this->name}",
                'updated' => $this->wasChanged('is_active') 
                    ? "Changed category {$this->name} status to " . ($this->is_active ? 'active' : 'inactive')
                    : "Updated category: {$this->name}",
                'deleted' => "Deleted category: {$this->name}",
                default => "{$eventName} category: {$this->name}",
            });
    }
}
