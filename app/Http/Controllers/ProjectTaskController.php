<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ProjectTaskController
 * @package CodeProject\Http\Controllers
 */
class ProjectTaskController extends Controller
{
    /**
     * @var ProjectTaskRepository
     */
    private $repository;

    /**
     * @var ProjectTaskService
     */
    private $service;

    /**
     * ProjectTaskController constructor.
     * @param ProjectTaskRepository $repository
     * @param ProjectTaskService $service
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
    {
        $this->repository = $repository;
        $this->service = $service;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $result = $this->repository->findWhere(['project_id'=>$id]);
        if (($result) && count($result)>=1) {
            return $result;
        }
        return ['error'=>true, 'Não foram localizadas tarefas neste projeto.'];
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
    public function show($id, $taskId)
    {
        $return = $this->repository->findWhere(['project_id'=>$id, 'id'=>$taskId]);
        if (($result) && count($result)>=1) {
            return $result;
        }
        return ['error'=>true, 'Tarefa não encontrada.'];
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
    public function update(Request $request, $id, $taskId)
    {
        try {
            return $this->service->update($request->all(), $taskId);
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Tarefa não encontrada.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao localizar a tarefa do projeto.'];
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $taskId)
    {
        try{
            $this->repository->find($taskId)->delete();
            return [
                'success' => true,
                'message' => "Tarefa do projeto deletada com sucesso!"
            ];
            }
            catch(QueryException $e){
                return ['error'=>true,'message'=>'Tarefa do projeto nao pode ser apagada pois existe um ou mais projetos vinculados a ela.'];
     	    }
     	    catch(ModelNotFoundException $e){
     	    return ['error'=>true,'message'=>'Tarefa do projeto não encontrada.'];
     	    }
     	    catch(\Exception $e){
     	    return ['error'=>true,'message'=>'Ocorreu um erro ao excluir a tarefa do projeto.'];
     	    }
     	}
    }
