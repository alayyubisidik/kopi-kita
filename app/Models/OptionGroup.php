<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionGroup extends Model
{
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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
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
}
