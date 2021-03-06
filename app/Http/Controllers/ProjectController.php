<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $repository;

    /**
     * @var ProjectService
     */
    private $service;

    /**
     * ProjectController constructor.
     * @param ProjectRepository $repository
     * @param ProjectService $service
     */
    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
        $this->repository = $repository;
        $this->service = $service;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $userId = \Authorizer::getResourceOwnerId();
       $result = $this->repository->findWhere(['owner_id'=>$userId]);

   //     if(isset($result) && count($result) == 1){
   //         $result = $result['data'][0];
   //     }
return $result;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($this->checkProjectPermissions($id) == false){
            return ['error'=>'Access Forbidden'];
        }
        try {
            return $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Projeto nao encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao encontrar o projeto.'];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if($this->checkProjectPermissions($id)==false){
                return ['error'=>'Access forbidden'];
            }
            return $this->service->update($request->all(), $id);
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Projeto não encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao localizar o projeto.'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            if($this->checkProjectPermissions($id)==false){
                return ['error'=>'Access forbidden'];
            }
            $this->repository->find($id)->delete();
            return [
                'success' => true,
                'message' => "Projeto deletado com sucesso!"
            ];
            }
            catch(QueryException $e){
                return ['error'=>true,'message'=>'Projeto nao pode ser apagado pois existe um ou mais projetos vinculados a ele.'];
     	    }
     	    catch(ModelNotFoundException $e){
     	    return ['error'=>true,'message'=>'Projeto não encontrado.'];
     	    }
     	    catch(\Exception $e){
     	    return ['error'=>true,'message'=>'Ocorreu um erro ao excluir o Projeto.'];
     	    }
     	}

    private function checkProjectOwner($projectId)
        {
            $userId = \Authorizer::getResourceOwnerId();
            return $this->repository->isOwner($projectId, $userId);
        }

    private function checkProjectMember($projectId)
        {
            $userId = \Authorizer::getResourceOwnerId();
            return $this->repository->hasMember($projectId, $userId);
        }

    private function checkProjectPermissions($projectId)
        {
        if ($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId))
            {
            return true;
            }
            return false;
        }
    }
