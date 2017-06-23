<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/06/17
 * Time: 10:31
 */

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;


class ProjectService
{
    /**
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * @var ProjectValidator
     */
     protected $validator;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;

    }

    public function create(array $data){
        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }

    public function update(array $data, $id){
        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessagebag()
            ];
        }
    }

    /**
     * @param  int   $id
     * @param  int   $memberId
     * @return array
     */
    public function isMember($id, $memberId)
    {
        try {
            $member = $this->repository->find($id)->members()->find($memberId);
            if($member) {
                return [
                    'error'   => false,
                    'message' => "Membro {$memberId} já pertence ao projeto"
                    ];
            }
            return [
                'error' => true,
                'message' => "Membro {$memberId} não pertence ao projeto"
                ];
        } catch(ModelNotFoundException $ex) {
            return [
                'error' => true,
                'message' => "ID {$memberId} não encontrado"
                ];
        }
    }

    /**
     * @param int    $id
     * @param int    $memberId
     * @return array
     */
    public function addMember($id, $memberId)
    {
        try {
            $checkIsMember = $this->isMember($id, $memberId);
            if(!$checkIsMember['error']) {
                return [
                    'error'   => true,
                    'message' => "Membro ID {$memberId} já está relacionado ao projeto"
                    ];
            }
            $this->repository->find($id)->members()->attach($memberId);
            return [
                'error'   => false,
                'message' => "Membro ID {$memberId} adicionado"
                ];
        } catch (ModelNotFoundException $e) {
            return [
                'error' => true,
                'message' => "ID {$memberId} não encontrado"
                ];
        }
    }

    /**
     * @param  int   $id
     * @return array
     * @param  int   $memberId
     */
    public function removeMember($id, $memberId)
    {
        try {
            $checkIsMember = $this->isMember($id, $memberId);
            if($checkIsMember['error']) {
                return $checkIsMember;
            }
            $this->repository->find($id)->members()->detach($memberId);
            return [
                "error"   => false,
                "message" => "Membro ID {$memberId} foi removido"
                ];
        } catch (ModelNotFoundException $e) {
            return [
                'error' => true,
                'message' => "ID {$memberId} não encontrado"
                ];
        }
    }

}