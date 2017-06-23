<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Services\ProjectMemberService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectMemberController extends Controller
{
    /**
     * @var ProjectMemberRepository
     */
    private $repository;

    /**
     * @var ProjectMemberService
     */
    private $service;

    /**
     * ProjectMemberController constructor.
     * @param ProjectMemberRepository $repository
     * @param ProjectMemberService $service
     */
    public function __construct(ProjectMemberRepository $repository, ProjectMemberService $service)
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
        return ['error'=>true, 'Não foram localizados membros neste projeto.'];
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
    public function show($id, $memberId)
    {
        $return = $this->repository->findWhere(['project_id'=>$id, 'id'=>$memberId]);
        if (($result) && count($result)>=1) {
            return $result;
        }
        return ['error'=>true, 'Membro não encontrado.'];
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
    public function update(Request $request, $id, $memberId)
    {
        try {
            return $this->service->update($request->all(), $memberId);
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Membro não encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao localizar o membro do projeto.'];
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $memberId)
    {
        try{
            $this->repository->find($memberId)->delete();
            return [
                'success' => true,
                'message' => "Membro do projeto deletado com sucesso!"
            ];
            }
            catch(QueryException $e){
                return ['error'=>true,'message'=>'Membro do projeto nao pode ser apagado pois existe um ou mais projetos vinculados a ela.'];
     	    }
     	    catch(ModelNotFoundException $e){
     	    return ['error'=>true,'message'=>'Membro do projeto não encontrado.'];
     	    }
     	    catch(\Exception $e){
     	    return ['error'=>true,'message'=>'Ocorreu um erro ao excluir o membro do projeto.'];
     	    }
     	}
    }
