<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/06/17
 * Time: 07:10
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\Client;
use CodeProject\Presenters\ClientPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {

    protected $fieldSearchable = [
        'name'
    ];

    public function model(){
        return Client::class;
    }
    public function presenter()
    {
        return ClientPresenter::class;
    }
    public function boot(){
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

/**$this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));*/
