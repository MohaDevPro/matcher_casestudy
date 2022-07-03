<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'fields','address', 'property_type_id'
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'fields' => 'array'
    ];
    /**
     * Get the user that owns the Property
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getPropertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function getPropertyFields()
    {
        return $this->fields;
    }

}
