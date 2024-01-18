<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function getProducts() {
        $products = Product::all();
        return response()->json([
            'products' => $products
        ], 200) ;
    }

    public function getProductById($id) {
        $product = Product::find($id);
        return response()->json([
            'product' => $product
        ], 200) ;
    }

    public function store(Request $req) {
        $req->validate([
            'image' => 'required',
            'name' => 'required|string',
            'type' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $image = $req->file('image');
        $fileName = time() . '.' . $image->getClientOriginalExtension();
        $image->move('products/', $fileName) ;

        $product = new Product([
            'image'       => $fileName,
            'name'        => $req->name,
            'type'        => $req->type,
            'size'        => $req->size,
            'description' => $req->description,
            'price'       => $req->price,
            'quantity'    => $req->quantity,
        ]) ;

        if($product->save()) {
            return response()->json([
                'message' => 'Product Created Successfully',
            ], 200) ;
        } else {
            return response()->json([
                'error' => 'Error Creating Product',
            ], 401) ;
        }
    }

    public function update(Request $req, $id) {
        $req->validate([
            'image' => 'required',
            'name' => 'required|string',
            'type' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        
        $product = Product::find($id) ;
        if($req->hasFile('image')) {
            $image = $req->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('products/', $fileName) ;
            $product->image = $fileName ;
        }
        $product->name        = $req->name ;
        $product->type        = $req->type ;
        $product->size        = $req->size ;
        $product->description = $req->description ;
        $product->price       = $req->price ;
        $product->quantity    = $req->quantity ;

        if($product->save()) {
            return response()->json([
                'message' => 'Product Updated Successfully',
            ], 200) ;
        } else {
            return response()->json([
                'error' => 'Error Updating Product',
            ], 401) ;
        }
    }

    public function destroy($id) {
        $product = Product::find($id);
        $product->delete() ;

        return response()->json([
                'message' => 'Product Deleted',
            ], 200) ;
    }
}
