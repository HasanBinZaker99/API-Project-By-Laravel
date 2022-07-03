<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        // Get --all data from database
        //$products = Product::paginate(2);
        //$products = Product::linit(5);
        $products = Product::all();
        return response()->json($products);

    }

    public function store(Request $request)
    {
        // Post data to database from user

        // Validation

        $this->validate($request,[
            'title' => 'required',
            'price' => 'required',
            'photo' => 'required',
            'description' => 'required'
        ]);
        $product = new Product();
        // Image Upload
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $allowedfileExtention = ['pdf','png','jpg'];
            $extention = $file->getClientOriginalExtension();
            $check = in_array($extention,$allowedfileExtention);
            if($check){
                $name = time().$file->getClientOriginalName();
                $file->move('images',$name); // Move this file into the images folder in the public directory and save the information in the database as well.
                $product->photo = $name;
            }
        }

        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->save();
        return response()->json($product);
    }


    public function show($id)
    {
        // give 1 items from products table
        $product = Product::find($id);
        return response()->json($product);
    }




    public function update(Request $request, $id)
    {
        // Update- ID
        $this->validate($request,[
            'title' => 'required',
            'price' => 'required',
            'photo' => 'required',
            'description' => 'required'
        ]);
        $product = Product::find($id);
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $allowedfileExtention = ['pdf','png','jpg'];
            $extention = $file->getClientOriginalExtension();
            $check = in_array($extention,$allowedfileExtention);
            if($check){
                $name = time().$file->getClientOriginalName();
                $file->move('images',$name); // Move this file into the images folder in the public directory and save the information in the database as well.
                $product->photo = $name;
            }
        }

        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->save();
        return response()->json($product);
    }


    public function destroy($id)
    {
        // Delete - ID

        $product = Product::find($id);
        $product->delete();
        return response()->json('Product Deleted Successfully!');
    }
}
