<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 23/06/17
 * Time: 10:55
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\user;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{
    public function transform(User $member) {
        return [
            'member_id' => $member->id,
            'name' => $member->name
        ];
    }
}