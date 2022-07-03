<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'searchFields', 'property_type_id'
    ];

    public $timestamps = false;
    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];

    //cast json field as array
    protected $casts = [
        'searchFields' => 'array'
    ];

    /**
     * Get the property type that search profile belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getSearchProfilePropertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function getSearchProfileFields()
    {
        // if in cast use string I will use this json_decode to convert it to object
        // json_decode($this->searchFields);
        // but I use array here so no need for json decode
        return $this->searchFields;
    }

    public function scopeSearchProfileBypropertyType($query,$property_id)
    {
        return $this->where('property_type_id', $property_id);
    }

}
