<?php

namespace App;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Property extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;

    const STATUS_AVALIABLE = 1;
    const STATUS_HIRED = 2;

    protected $fillable = [
        'owner_email',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'status',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
