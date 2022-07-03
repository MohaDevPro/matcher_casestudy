<?php
/**
 * Tutorial used :: https://www.educative.io/answers/how-to-use-uuids-in-laravel
 */

namespace App\Traits;

use Illuminate\Support\Str;
trait UUID
{
    public static function boot()
    {
        // Boot method from parent
        parent::boot();

        //sets the 'id' to a UUID using Str::uuid() on the instance being created
        static::creating(function ($model) {
            // use Str Helper to call uuid method
            // $model->getKeyName() : this is the id field that I declare it as primary with uuid type in migration and set the type to string
            $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
        });
    }

    public function getIncrementing ()
    {
        //prevent DB from auto-increment this field
        return false;
    }

    public function getKeyType ()
    {
        //specify the field type as string in DB
        return 'string';
    }
}
