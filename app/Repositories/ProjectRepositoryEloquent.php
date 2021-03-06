<?php

namespace CodeProject\Repositories;

use CodeProject\Presenters\ProjectPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Entities\Project;
use CodeProject\Validators\ProjectValidator;

/**
 * Class ProjectRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $projectId
     * @param $userId
     * @return bool
     */
    public function isOwner($projectId, $userId) {
        if(count($this->skipPresenter()->findWhere(['id'=>$projectId, 'owner_id'=>$userId]))) {
            return true;
        }
        return false;
    }

    public function findOwner($userId, $limit = null, $columns = array()){
        return $this->scopeQuery(function ($query) use($userId){
            return $query->select('projects.*')->where('projects.owner_id', '=', $userId);
        })->paginate($limit, $columns);
    }

    public function hasMember($projectId, $memberId)
    {
        $project = $this->skipPresenter()->find($projectId);
        foreach ($project->members as $member) {
            if($member->id == $memberId) {
                return true;
            }
        }
        return false;
    }

    public function presenter()
    {
        //return $this->repository->setPresenter("CodeProject\Presenters\ProjectPresenter"); Transformer::class;
        return ProjectPresenter::class;
    }

}
