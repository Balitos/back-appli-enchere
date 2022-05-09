<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Console\Scheduling\Schedule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::select('id','title','description','image', 'price', 'endDate')
        ->orderBy('endDate', 'desc')
        ->get();
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userProducts(Request $request)
    {
        $userId = $request->user_id;
        return Product::select('id','title','description','image', 'price', 'endDate')->where('user_id', $userId)->get();
        
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'description'=>'required',
            'price'=>'required',
            'user_id'=>'',
            'endDate'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $product = Product::create(array_merge(
                    $validator->validated(),
                ));

        return response()->json([
            'message' => 'Product successfully created',
            'product' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json([
            'product'=>$product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $validator = Validator::make($request->all(), [
            'title'=>'',
            'description'=>'',
            'price'=>'',
            'user_id'=>'',
            'endDate'=>'',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $product->update(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'Product successfully edited',
        ], 201);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function winningBid(Request $request, Product $product)
    {

        $validator = Validator::make($request->all(), [
            'user_id'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $product->update(array_merge(
                    $validator->validated(),
                ));

        return response()->json([
            'message' => 'The winning bid has been set',
        ], 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Schedule $schedule)
    {
        
        $product->delete();
     
        

        return response()->json([
            'message'=>'Product Deleted Successfully!!'
        ]);
            
        
    }
}
