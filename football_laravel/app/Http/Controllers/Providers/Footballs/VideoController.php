<?php

namespace App\Http\Controllers\Providers\Footballs;

use App\Http\Controllers\Controller;
use App\Repositories\Providers\Footballs\VideoRepository;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    private $repository;
    private $controller;

    public function __construct(VideoRepository $repository)
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
        $video = $this->repository->getVideoByIdOrFootballPlaceId(null, $footballPlaceId);
        if(isset($video))
        {
            return $this->edit($video);
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
        return view('providers.footballs.videos.create');
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
            $video = $this->repository->createAndUpdate($request, null);

            return response()->json([
                'status' => 200,
                'error' => null,
                'message' => 'create success',
                'data' => $video,
//                'view' => $this->controller->index($request)->render()
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
    public function edit($video)
    {
        return view('providers.footballs.videos.edit', ['video' => $video]);
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
            $video = $this->repository->createAndUpdate($request, $id);
            return response()->json([
                'status' => 200,
                'error' => null,
                'message' => 'update success',
                'data' => $video,
//                'view' => $this->controller->index($request)->render()
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
        if ($request->ajax()) {
            $datas = $this->repository->delete($request, $id);
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
