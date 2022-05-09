<?php

namespace App\Http\Controllers;

use App\Models\Encheres;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EncheresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Encheres::select('id','user_id','product_id','value')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productEnchere(Request $request)
    {
        $productId = $request->product_id;
        return Encheres::select('id','user_id','product_id','value')
            ->where('product_id', $productId)
            ->orderBy('value', 'desc')
            ->get();
        
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function highestBid(Request $request)
    {
        $productId = $request->product_id;
        return Encheres::select('id','user_id','product_id','value')
            ->where('product_id', $productId)
            ->orderBy('value', 'desc')
            ->limit(1)
            ->get();

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
            'user_id'=>'required',
            'product_id'=>'required',
            'value'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $encheres = Encheres::create(array_merge(
                    $validator->validated(),
                ));

        return response()->json([
            'message' => 'Votre enchere a bien été prise en compte',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Encheres  $encheres
     * @return \Illuminate\Http\Response
     */
    public function show(Encheres $encheres)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Encheres  $encheres
     * @return \Illuminate\Http\Response
     */
    public function edit(Encheres $encheres)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Encheres  $encheres
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Encheres $encheres)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Encheres  $encheres
     * @return \Illuminate\Http\Response
     */
    public function destroy(Encheres $encheres)
    {
        //
    }
}
