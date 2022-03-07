<?php

namespace App\Http\Controllers\Providers\Footballs;

use App\Http\Controllers\Controller;
use App\Models\Footballs\Service;
use App\Repositories\Providers\Footballs\ServiceRepository;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private $repository;
    private $controller;

    public function __construct(ServiceRepository $repository)
    {
        $this->repository = $repository;
//        $this->controller = $controller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $footballPlaceId = $request->cookie('football_place_id');
        $typeServices = $this->repository->getAllTypeServiceByFootballPlaceId($footballPlaceId);
        if(count($typeServices) > 0)
        {
            return $this->edit($typeServices);
        }
        return $this->create();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('providers.footballs.services.create', ['typeServices' => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $request->merge(['user_id'=>Auth::user()->user_id]);
        if($request->ajax()){
            $request->merge(['football_place_id' => $request->cookie('football_place_id')]);
            $detail = $this->repository->createMenu($request);

            return response()->json([
                'status' => 200,
                'error' => null,
                'message' => 'create success',
                'data' => $detail,
                'view' => $this->controller->index($request)->render()
            ]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $typeServices)
    {
        return view('providers.footballs.services.edit', ['typeServices' => $typeServices]);
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            $datas = $this->repository->delete($request);
            return response()->json([
                'status' => 200,
                'error' => null,
                'message' => 'Delete success',
                'data' => '',
                'view' => ''
            ]);
        }
    }
}
