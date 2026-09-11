<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'is_available',
        'is_customizable',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_available' => 'boolean',
        'is_customizable' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the option groups for the product.
     */
    public function optionGroups()
    {
        return $this->belongsToMany(OptionGroup::class, 'product_option_groups')
            ->withPivot('sort_order')
            ->withTimestamps();
    }

    /**
     * Register media collections for the product.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product-images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();
    }

    /**
     * Get the product's image URL.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->hasMedia('product-images')) {
            return $this->getFirstMediaUrl('product-images');
        }

        return asset('images/placeholder-product.jpg');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['category_id', 'name', 'slug', 'description', 'price', 'is_available', 'is_customizable'])
            ->logOnlyDirty()
            ->useLogName('product')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => "Created product: {$this->name}",
                'updated' => $this->wasChanged('is_available') 
                    ? "Changed product {$this->name} availability to " . ($this->is_available ? 'available' : 'unavailable')
                    : "Updated product: {$this->name}",
                'deleted' => "Deleted product: {$this->name}",
                default => "{$eventName} product: {$this->name}",
            });
    }
}
