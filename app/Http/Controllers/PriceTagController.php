<?php

namespace App\Http\Controllers;
use illuminate\Support\Facades\Auth;
use App\PriceTag;
use Illuminate\Http\Request;

class PriceTagController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
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
        $request->validate([
            'name' =>'required',
            'cost' => 'required',
            'client_id'=> 'required'
        ]);
        $pricetag = PriceTag::create([
            'kind' => $request->kind,
            'name' => $request->name,
            'cost' => $request->cost,
            'client_id'=>$request->client_id

        ]);
        return response()->json([
            'pricetag' => $pricetag,
            'message' => 'pricetag has been added'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PriceTag $pricetag)
    {
        //
        $pricetag->delete();

        return response()->json([
            '$pricetag' => $pricetag,
            'message' => 'Pricetag has been deleted'
        ]);
    }
}
