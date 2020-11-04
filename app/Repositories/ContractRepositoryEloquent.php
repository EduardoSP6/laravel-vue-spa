<?php

namespace App\Repositories;

use App\Contract;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ContractRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ContractRepositoryEloquent extends BaseRepository implements ContractRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contract::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
