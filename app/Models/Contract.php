<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

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

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
