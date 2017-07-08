<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 23/06/17
 * Time: 10:55
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
    //protected $defaultIncludes = ['members', 'notes', 'tasks', 'files', 'client'];
    protected $defaultIncludes = ['client'];

    public function transform(Project $project) {
        return [
            'project_id' => $project->id,
            'client_id' => $project->client_id,
            'owner_id' => $project->owner_id,
            'name' => $project->name,
            'description' => $project->description,
            'progress'=> (int) $project->progress,
            'status'=> $project->status,
            'due_date'=> $project->due_date,
            'is_member'=>$project->user_id != \Authorizer::getResourceOwnerId()
        ];
    }

    public function includeMembers(Project $project)
    {
        return $this->collection($project->members, new ProjectMemberTransformer());
    }

    public function includeNotes(Project $project){
        return $this->collection($project->notes, new ProjectNoteTransformer());
    }

    public function includeTasks(Project $project){
        return $this->collection($project->tasks, new ProjectTaskTransformer());
    }

    public function includeFiles(Project $project){
        return $this->collection($project->files, new ProjectFileTransformer());
    }

    public function includeClient(Project $project)
    {
        if($project->client) {
            return $this->item($project->client, new ClientTransformer());
        }
        return null;
    }
}