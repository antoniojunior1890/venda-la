<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kit;
use Illuminate\Support\Facades\DB;

class KitController extends Controller
{
    private $kit;

    public function __construct(Kit $kit)
    {
        $this->kit = $kit;
    }

    public function index()
    {
        $data = ['data' => $this->kit->all()];

        return response()->json($data);
    }

    public function show($id)
    {
        $kit = $this->kit->find($id)->with('products')->first();

        if (!$kit) return response()->json(['data' => ['msg' => 'Kit não encontrado!']], 404);

        $data = ['data' => $kit];

        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            // return $request->price;
            $productKit = [];
            foreach ($request->products as $product) {
                // return $product['id'];
                $productKit[$product['id']] = [
                    'product_id' => $product['id'],
                    'qtd' => $product['qtd'],
                ];
            }
            // DB::beginTransaction();
            $resultCreateKit = $this->kit->create([
                'name'  => $request->name,
                'price' => $request->price,
            ]);

            $resultCreateKit->products()->attach($productKit);
            $data = ['data' => ['msg' => 'Produto criado com sucesso!']];
            return response()->json([$data], 201);
        } catch (\Exception $e) {

            return response()->json(($e->getMessage()));
        }
    }
}
