<?php

namespace App\Http\Controllers\Providers\Footballs;

use App\Http\Controllers\Controller;
use App\Repositories\Providers\Footballs\OpenTimeRepository;
use Illuminate\Http\Request;

class OpenTimeController extends Controller
{
    private $repository;
    private $controller;

    public function __construct(OpenTimeRepository $repository)
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
        $openTime = $this->repository->getOpenTimeFirstByFootballPlaceId($footballPlaceId);
        if(isset($openTime))
        {
            return $this->edit($openTime);
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
        return view('providers.footballs.open_times.create');
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
            $openTimeRequest = $request->except(['_token','football_place_id']);
            $openTime = $this->repository->create([
                'football_place_id' => $request->football_place_id,
                'open_time' => json_encode($openTimeRequest)
            ]);

            return response()->json([
                'status' => 200,
                'error' => null,
                'message' => 'create success',
                'data' => $openTime,
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
    public function edit($openTime)
    {
        return view('providers.footballs.open_times.edit', ['openTime' => $openTime]);
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
            $request->merge(['football_place_id' => $request->cookie('football_place_id')]);
            $openTimeRequest = $request->except(['_token','football_place_id','_method']);
            $openTime = $this->repository->update([
                'football_place_id' => $request->football_place_id,
                'open_time' => json_encode($openTimeRequest)
            ],$id);
            return response()->json([
                'status' => 200,
                'error' => null,
                'message' => 'update success',
                'data' => $openTime,
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
    public function destroy(Request $request, $id)
    {

    }
}
