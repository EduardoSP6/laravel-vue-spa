<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Property;

class Contract extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;

    protected $fillable = [
        'property_id',
        'person_type',
        'document',
        'contractor_email',
        'contractor_name',
    ];

    public function property() {
        return $this->hasOne(Property::class);
    }
}
