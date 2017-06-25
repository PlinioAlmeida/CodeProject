<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 23/06/17
 * Time: 10:55
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectFile;
use League\Fractal\TransformerAbstract;

class ProjectFileTransformer extends TransformerAbstract
{
    public function transform(ProjectFile $file) {
        return [
            'id' => $file->id,
            'project_id' => $file->project_id,
            'name' => $file->name,
            'description' => $file->description,
            'extension' => $file->extension
        ];
    }
}
