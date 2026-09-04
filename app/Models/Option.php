<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
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
}
