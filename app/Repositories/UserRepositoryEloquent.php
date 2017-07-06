<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/06/17
 * Time: 07:10
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\User;
use CodeProject\Presenters\UserPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    Public function model()
    {
        return User::class;
    }

    public function presenter()
    {
        return UserPresenter::class;
    }

}