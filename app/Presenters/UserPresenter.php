<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 06/07/17
 * Time: 10:01
 */

namespace CodeProject\Presenters;

use CodeProject\Transformers\UserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class UserPresenter extends FractalPresenter
{
    public function getTransformer()
    {
        return new UserTransformer();
    }
}