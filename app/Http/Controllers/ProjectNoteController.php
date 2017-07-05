<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ProjectNoteController
 * @package CodeProject\Http\Controllers
 */
class ProjectNoteController extends Controller
{
    /**
     * @var ProjectNoteRepository
     */
    private $repository;

    /**
     * @var ProjectNoteService
     */
    private $service;

    /**
     * ProjectNoteController constructor.
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteService $service
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service)
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
        $result = $this->repository->skipPresenter()->findWhere(['project_id'=>$id]);
        if (($result) && count($result)>=1) {
            return $result;
        }
        return ['error'=>true, 'Não foram localizadas notas neste projeto.'];
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
    public function show($id, $noteId)
    {
        $result = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
        if(isset($result) && count($result) == 1){
            $result = $result['data'][0];
        }
        return $result;
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
    public function update(Request $request, $id, $noteId)
    {
        try {
            return $this->service->update($request->all(), $noteId);
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Nota não encontrada.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao localizar a nota do projeto.'];
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $noteId)
    {
        try{
            $this->repository->skipPresenter()->find($noteId)->delete();
            return [
                'success' => true,
                'message' => "Nota do projeto deletada com sucesso!"
            ];
            }
            catch(QueryException $e){
                return ['error'=>true,'message'=>'Nota do projeto nao pode ser apagada pois existe um ou mais projetos vinculados a ela.'];
     	    }
     	    catch(ModelNotFoundException $e){
     	    return ['error'=>true,'message'=>'Nota do projeto não encontrada.'];
     	    }
     	    catch(\Exception $e){
     	    return ['error'=>true,'message'=>'Ocorreu um erro ao excluir a Nota do projeto.'];
     	    }
     	}
    }
