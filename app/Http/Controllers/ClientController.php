<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientController extends Controller
{
    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * @var ClientService
     */
    private $service;

    /**
     * ClientController constructor.
     * @param ClientRepository $repository
     * @param ClientService $service
     */
    public function __construct(ClientRepository $repository, ClientService $service)
    {
        $this->repository = $repository;
        $this->service = $service;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->repository->all();
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
        try {
            return $this->repository->find($id);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                        "error" => true,
                        "message" => $e->getMessage()
                        ],
                        404);

            } catch (\Exception $e) {
                return response()->json([
                        "error" => true,
                        "message" => $e->getMessage()
                        ],
                        412);

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
               return $this->service->update($request->all(), $id);
           } catch (ModelNotFoundException $e) {
               return ['error'=>true, 'Cliente não encontrado.'];
           } catch (\Exception $e) {
               return ['error'=>true, 'Ocorreu algum erro ao localizar o cliente.'];
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
            $this->repository->find($id)->delete();
            return [
                'success' => true,
                'message' => "Cliente deletado com sucesso!"
            ];
            }
            catch(QueryException $e){
                return ['error'=>true,'message'=>'Cliente nao pode ser apagado pois existe um ou mais projetos vinculados a ele.'];
     	    }
     	    catch(ModelNotFoundException $e){
     	    return ['error'=>true,'message'=>'Cliente não encontrado.'];
     	    }
     	    catch(\Exception $e){
     	    return ['error'=>true,'message'=>'Ocorreu um erro ao excluir o cliente.'];
     	    }
 	    }
    }
