<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 23/06/17
 * Time: 10:55
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectTask;
use League\Fractal\TransformerAbstract;

class ProjectTaskTransformer extends TransformerAbstract
{
    public function transform(ProjectTask $task) {
        return [
            'id' => $task->id,
            'project_id' => $task->project_id,
            'name' => $task->name,
            'start_date' => $task->start_date,
            'due_date' => $task->due_date,
            'status' => $task->status
        ];
    }
}
