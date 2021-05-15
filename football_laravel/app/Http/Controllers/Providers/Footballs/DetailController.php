<?php

namespace App\Http\Controllers\Providers\Footballs;

use App\Http\Controllers\Controller;
use App\Repositories\Providers\Footballs\DetailRepository;
use App\Services\GetSession;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    private $repository;
    private $controller;

    public function __construct(DetailRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $footballPlaceId = $request->cookie('football_place_id');
        $detail = $this->repository->getDetailByIdOrFootballPlaceId( null, $footballPlaceId);
        if(isset($detail))
        {
            return $this->edit($footballPlaceId);
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
        return view('providers.footballs.details.create');
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
            $request->merge(['football_place_id' => $request->cookie('football_place_id'),'lang'=>GetSession::getLocale()]);
            $detail = $this->repository->createAndUpdate($request, null);

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
    public function edit($detail)
    {
        return view('providers.footballs.details.edit', ['detail' => $detail]);
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
        if ($request->ajax()) {
            $request->merge(['football_place_id' => $request->cookie('football_place_id'), 'lang' => GetSession::getLocale()]);
            $detail = $this->repository->createAndUpdate($request, $id);
            return response()->json([
                'status' => 200,
                'error' => null,
                'message' => 'update success',
                'data' => $detail,
                'view' => $this->controller->index($request)->render()
            ]);
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

    }
}
