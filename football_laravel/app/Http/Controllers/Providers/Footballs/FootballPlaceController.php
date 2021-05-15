<?php

namespace App\Http\Controllers\Providers\Footballs;

use App\Http\Controllers\Controller;
use App\Repositories\Providers\Footballs\FootballPlaceRepository;
use Illuminate\Http\Request;

class FootballPlaceController extends Controller
{
    private $repository;
    private $controller;

    public function __construct(FootballPlaceRepository $repository, DetailController $controller)
    {
        $this->repository = $repository;
        $this->controller = $controller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cookieFootballPlaceId = $request->cookie('football_place_id');
        if($cookieFootballPlaceId != null)
        {
            return $this->edit($cookieFootballPlaceId);
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
        return view('providers.footballs.basic_infos.create');
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
            $credentials = $request->merge(['utilities'=> $request->utilities ? implode(',', $request->utilities) : '',
                'allow_view'=> $request->allow_view ? 1 : 0])
                ->only(['user_id','name','phone','email','website','utilities','max_price','min_price','allow_view']);
            $footballPlace = $this->repository->createFootballPlace($credentials);

            return response()->json([
                'status' => 200,
                'error' => null,
                'message' => 'create success',
                'data' => $footballPlace,
                'view' => view('providers.footballs.details.create')->render()
            ])->withCookie('football_place_id', $footballPlace->id);

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
        $footballPlace = $this->repository->getFootballPlaceById($id);
        return response(view('providers.footballs.basic_infos.edit',compact('footballPlace')))
            ->withCookie('football_place_id', $id);
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
        //$request->merge(['user_id'=>Auth::user()->user_id]);
        $credentials = $request->merge(['amenities'=> $request->amenities ? implode(',', $request->amenities) : '',
            'allow_view'=> $request->allow_view ? 1 : 0])
            ->only(['user_id','name','phone','email','website','amenities','max_price','min_price','allow_view','lang']);
        $footballPlace = $this->repository->updateFootballPlace($credentials,$id);
        return response()->json([
            'status' => 200,
            'error' => null,
            'message' => 'update success',
            'data' => $footballPlace,
            'view' => $this->controller->index($request)->render()
        ])->withCookie('football_place_id', $footballPlace->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
    }
}
