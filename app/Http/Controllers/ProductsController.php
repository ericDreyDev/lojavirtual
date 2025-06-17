<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Type;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        //dd($request->all());
        $filter = $request->input('search');
        if ($filter) {
            $products = Product::where('name', 'like', "%$filter%")->get();
        } else {
            $products = Product::with('type')
                ->orderBy('name', 'asc') // ordena pelo nome
                ->get();
        }

        return view('products.index', [
            'products' => $products,
            'filter' => $filter
        ]);
    }

    public function catalog(Request $request)
    {
        $selectedType = $request->input('type');

        $productsQuery = Product::with('type')->where('quantity', '>', 0);

        if ($selectedType) {
            $productsQuery->where('type_id', $selectedType);
        }

        $products = $productsQuery->get();
        $types = Type::all();

        // Buscar imagens para cada produto
        $imageLinks = [];
        foreach ($products as $product) {
            $imageLinks[$product->id] = $this->buscarImagemGoogle($product->name);
        }

        return view('catalog', compact('products', 'types', 'selectedType', 'imageLinks'));
    }

    private function buscarImagemGoogle($query)
{
    $apiKey = env('GOOGLE_API_KEY');
    $cx = env('GOOGLE_CX_ID');

    $url = 'https://www.googleapis.com/customsearch/v1?' . http_build_query([
        'key' => $apiKey,
        'cx' => $cx,
        'searchType' => 'image',
        'q' => $query,
        'num' => 1
    ]);

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if (isset($data['items'][0]['link'])) {
        return $data['items'][0]['link'];
    } else {
        return '/images/default.jpg';
    }
}


    public function create()
    {
        return view('products.create', [
            'types' => Type::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'description' => 'nullable|max:500',
            'quantity' => 'required|integer|gt:0',
            'price' => 'required|numeric|gt:0',
            'type_id' => 'required|exists:types,id',
        ]);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'type_id' => $request->type_id
        ]);
        return redirect('/products')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view('products.edit', ['product' => $product, 'types' => Type::all()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required|min:2|max:50',
            'description' => 'nullable|max:500',
            'quantity' => 'required|integer|gt:0',
            'price' => 'required|numeric|gt:0',
            'type_id' => 'required|exists:types,id',
        ]);

        $product = Product::find($request->id);
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'type_id' => $request->type_id
        ]);
        return redirect('/products')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            $product->delete();
            return redirect('/products')->with('success', 'Produto excluído com sucesso!');
        } catch (QueryException $e) {
            // Caso haja algum erro de banco
            return redirect('/products')
                ->with('error', 'Erro ao excluir produto.');
        }
    }
}
