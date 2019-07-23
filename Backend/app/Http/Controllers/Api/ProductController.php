<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use function GuzzleHttp\json_encode;

class ProductController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $data = ['data' => $this->product->paginate(5)];

        return response()->json($data);
    }

    public function show($id)
    {
        $product = $this->product->find($id);

        if(!$product) return response()->json(['data' => ['msg' => 'Produto não encontrado!', 'status' => 404]],404);

        $data = ['data' => $product];

        return response()->json($data);
    }

    public function store(Request $request)
    {

        try{
            $productData = json_decode($request->product);

            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->storeAs('images', $imageName);
            
            $this->product->create([
                'name' =>  $productData->name,
                'description' => $productData->description, 
                'category'=> $productData->category, 
                'price'=> $productData->price, 
                'image'=> $imageName
            ]);

            $data = ['data' => ['msg' => 'Produto criado com sucesso!']];
            return response()->json([$data],201);

        }catch (\Exception $e){

            return response()->json(($e->getMessage()));
            
        }

    }

    public function delete(Product $id)
    {
        try{

            $id->delete();

            $data = ['data' => ['msg' => 'Produto : '. $id->name .' removido com sucesso!']];
            return response()->json([$data],200);

        }catch (\Exception $e){

            if(config('app.debug')){
                return response()->json(ApiError::errorMsg($e->getMessage(),1012),500);
            }

            return response()->json(ApiError::errorMsg('Houve erro ao realizar operação de remover',1012),500);
        }
    }

    public function autocomplete(Request $request)
    {

        $query = $request->input('query','');

        $data = Product::select("id","name","price")
            ->where("name","LIKE","%{$query}%")
            ->get();

        $array = array();
        foreach ($data as $d) {
            $array[] = array('label' => $d->name, 'id' => $d->id,'value' => $d->name, 'price' => $d->price);
        }

        return json_encode($array);
    }

}
