<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 23/06/17
 * Time: 15:24
 */

namespace CodeProject\Presenters;

use CodeProject\Transformers\ProjectTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ProjectPresenter extends FractalPresenter
{
    public function getTransformer()
    {
        return new ProjectTransformer();
    }
}

