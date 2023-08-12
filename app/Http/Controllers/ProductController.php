<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $getProduct = Product::get();
        return view('product.index',compact('getProduct') );
    }
    public function storeProduct(Request $request)
{
    $validatedData = $request->validate([
        'partner_name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|string', // Allow for comma-formatted price
        'product_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validating image upload
    ]);
    
    // Convert comma-formatted price to integer
    $price = str_replace(',', '', $validatedData['price']);
    $price = intval($price);
    
    // Update the validated data with the converted price
    $validatedData['price'] = $price;

    $productName = $validatedData['partner_name'];
    $description = $validatedData['description'];
    $price = $validatedData['price'];

    if ($request->hasFile('product_picture')) {
        $productPicture = $request->file('product_picture');
        $imageName = time() . '.' . $productPicture->getClientOriginalExtension();
        $productPicture->move(public_path('img'), $imageName); // Move uploaded file to public/img directory

        // Save product details and image path in the database
        $product = new Product([
            'name' => $productName,
            'description' => $description,
            'price' => $price,
            'product_picture' => 'img/' . $imageName,
        ]);

        $product->save();

        return redirect()->back()->with('success', 'Product added successfully.');
    }
}

public function updateProduct(Request $request) {
    $id = $request->id; // Get the product ID from the hidden input

    $product = Product::findOrFail($id); // Replace 'Product' with your actual model class name

    // Validate input
    $validatedData = $request->validate([
        'partner_name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'product_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validating image upload
    ]);

    // Update fields if changed
    if ($product->name !== $request->partner_name) {
        $product->name = $request->partner_name;
    }
    if ($product->description !== $request->description) {
        $product->description = $request->description;
    }
    if ($product->price !== $request->price) {
        $product->price = $request->price;
    }

    // Update product picture if provided
    if ($request->hasFile('product_picture')) {
        // Delete old picture if exists
        if ($product->product_picture) {
            Storage::delete($product->product_picture);
        }
        
        $product->product_picture = $request->file('product_picture')->store('product_pictures', 'public');
    }

    // Save changes if anything was updated
    if ($product->isDirty()) {
        $product->save();
        return redirect()->back()->with('success', 'Product updated successfully.');
    } else {
        return redirect()->back()->with('failed', 'No changes were made to the product.');
    }
}

public function deleteProduct(Request $request){
    $id = $request->input('id'); // Get the product ID

    $product = Product::findOrFail($id); // Replace 'Product' with your actual model class name

    // Delete the product picture file from the public directory if it exists
    if ($product->product_picture) {
        Storage::delete('public/' . $product->product_picture);
    }

    // Delete the product
    $product->delete();

    return redirect()->back()->with('success', 'Product deleted successfully.');
}   

}
