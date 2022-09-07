<?php

namespace App\Repositories;

use App\Models\Property;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PropertyRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PropertyRepositoryEloquent extends BaseRepository implements PropertyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Property::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
