<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
// use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Validator;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
   
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        // Eager loading
        // $products = Product::with('category')->get();
        $products = Product::all();
        // var_dump($products);
    
        // return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  public function store(Request $request)
    //  {
    //     $validateData = $request->validate([
    //         'name'=>'required|string',
    //         'details'=>'required|string'
    //     ]);
    //     $product = Product::create([
    //         'name'=> $validateData['name'],
    //         'details'=>$validateData['details'],
    //     ]);

    //     if($product){
    //         return response()->json([
    //             'message'=>'Product added successfully',
    //             'product'=>$product,
    //         ], 201);
    //     } else{
    //         return response()->json([
    //             'message'=>'Failed to create product',
    //         ]);
    //     }

        
    //  }
    public function store(Request $request): JsonResponse
    {
        // dd();
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'details' => 'required',
            'category_id'=> ['required', 'exists:categories,id']
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $product = Product::create($input);
   
        // return $this->sendResponse(new ProductResource($product), 'Product created successfully.');

        return response()->json($product);
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $product = Product::find($id);
  
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
   
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'details' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $product->name = $input['name'];
        $product->details = $input['details'];
        $product->save();
   
        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');

        // return response()->json([
        //     'message'=>'product updated successfully',
        //     'product'=>$product
        // ]);
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
   
        return $this->sendResponse([], 'Product deleted successfully.');
    }
}