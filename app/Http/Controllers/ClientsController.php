<?php

namespace App\Http\Controllers;
use App\Client;
use App\PriceTag;
use illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ClientsController extends Controller
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
        // $clients = Client::all();
        $clients = Client::with('pricetags')->get();

        return response()->json([
            'clients' => $clients 
        ],200);
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
        //
        $request->validate([
            'name' =>'required'
        ]);
        //
        $client = Client::create([
            'name' => $request->name
        ]);
        $client->pricetags()->create([
                'kind' => 'public',
                'name' => 'Normal',
                'cost' => '0.00',
                'client_id'=>$client->id
        ]);
        return response()->json([
            'client' => $client,
            'message' => 'client has been added'
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
        $request->validate([
            'name' =>'required'
        ]);

        $client = Client::findOrFail($id)->update($request->all());

        return response()->json([
            'client' => $client,
            'message' => 'Client info updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        // Code for deleting pricetags/jobs on client 
        // $client->jobs()->delete();
        $client->priceTags()->delete();
        $client->delete();
        return response()->json([
            'client' => $client,
            'message' => 'Client has been deleted'
        ]);
    }
}
