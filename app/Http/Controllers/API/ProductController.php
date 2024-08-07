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
            // return $this->sendError('Product not found.');
            return response()->json(['error'=>'product not found'], 404);
        }
   
        // return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
        return response()->json($product);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): JsonResponse
    {
        // Find the product by ID
        $product = Product::find($id);

        // Check if the product exists
        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        // Validate the request input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'details' => 'required|string',
            'category_id' => ['required', 'exists:categories,id'], // If category_id is used
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update product details
        $product->name = $request->input('name');
        $product->details = $request->input('details');
        if ($request->has('category_id')) {
            $product->category_id = $request->input('category_id'); // If using category_id
        }
        $product->save();

        return response()->json(['message' => 'Product updated successfully.', 'product' => $product], 200);
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