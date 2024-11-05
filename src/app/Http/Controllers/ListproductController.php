<?php

namespace App\Http\Controllers;

use App\Models\Listproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListproductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listproducts = Listproduct::all();

        return response()->json([
            'data' => $listproducts
        ]);
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
        $validator = Validator::make($request->all(), [
            'nama_list' => 'required',
            'harga' => 'required',
            'diskon' => 'required',
            'deskripsi' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();

        $listproduct = Listproduct::create($input);

        return response()->json([
            'data' => $listproduct
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Listproduct  $listproduct
     * @return \Illuminate\Http\Response
     */
    public function show(Listproduct $listproduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Listproduct  $listproduct
     * @return \Illuminate\Http\Response
     */
    public function edit(Listproduct $listproduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Listproduct  $listproduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Listproduct $listproduct)
    {
        $validator = Validator::make($request->all(), [
            'nama_list' => 'required',
            'harga' => 'required',
            'diskon' => 'required',
            'deskripsi' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();

        $listproduct->update($input);

        return response()->json([
            'message' => 'success',
            'data' => $listproduct
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Listproduct  $listproduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listproduct $listproduct)
    {
        $listproduct->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
