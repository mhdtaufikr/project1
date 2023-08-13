<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\CustomerOrder;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
   public function index(){
   $getProduct = Product::get();
    return view('customer.index' ,compact('getProduct'));
   }

   public function detailProduct($id){
      $id = decrypt($id);
      $getProductDetail = Product::where('id',$id)->first();

      return view('customer.detail' ,compact('getProductDetail'));
   }
   public function orderProduct(Request $request)
   {
       $productId = $request->id; // Get the product ID from the request
       $customerId = Auth::guard('customer')->id(); // Get the authenticated customer ID
   
       // Check if the product is already sold
       $product = Product::find($productId);
       if (!$product) {
           return redirect()->back()->with('failed', 'Product not found.');
       }
   
       if ($product->status == 1) {
           return redirect()->back()->with('failed', 'Product already sold.');
       }
   
       // Check if the user has already ordered the product
       $existingOrder = CustomerOrder::where('customer_id', $customerId)
           ->where('product_id', $productId)
           ->first();
   
       if ($existingOrder) {
           return redirect()->back()->with('failed', 'Product already in your cart.');
       }
   
       // Create a new CustomerOrder instance
       $order = new CustomerOrder();
       $order->customer_id = $customerId;
       $order->product_id = $productId;
       $order->status = 0; // 0 means "Pending"
   
       // Save the order
       $order->save();
   
       return redirect()->back()->with('success', 'Product added to your cart.');
   }
   

public function cartProduct($id)
{
    $userId = Auth::guard('customer')->id(); // Get the authenticated customer's ID
    $decryptedId = decrypt($id); // Decrypt the provided ID if necessary

    // Retrieve the cart items for the specific user along with product details
    $cartItems = CustomerOrder::leftJoin('products', 'customer_orders.product_id', '=', 'products.id')
                              ->select('customer_orders.*', 'products.name', 'products.description', 'products.price', 'products.status', 'products.product_picture')
                              ->where('customer_orders.customer_id', $userId)
                              ->paginate(10); // Add pagination here

    return view('customer.cart', compact('cartItems'));
}

public function cancelProduct(Request $request)
{
    $orderId = $request->item_id; // Get the order ID from the request
    
    // Find the order by ID
    $order = CustomerOrder::find($orderId);
    
    if (!$order) {
        return redirect()->back()->with('failed', 'Order not found.');
    }
    
    // Delete the order
    $order->delete();
    
    return redirect()->back()->with('success', 'Order canceled successfully.');
}

public function payProduct(Request $request)
{
    $item_id = $request->item_id;
    $amount = str_replace(',', '', $request->amount);
    $amount = intval($amount);

    // Retrieve the product
    $product = Product::find($item_id);

    if (!$product) {
        return redirect()->back()->with('failed', 'Product not found.');
    }

    if ($product->status == 1) {
        return redirect()->back()->with('failed', 'Product is already sold.');
    }

    if ($amount != $product->price) {
        return redirect()->back()->with('failed', 'Incorrect amount.');
    }

    // Update product status to sold
    $product->status = 1;
    $product->save();

    // Update customer order status
    $customerOrder = CustomerOrder::where('product_id', $item_id)
                                  ->where('customer_id', auth()->guard('customer')->id())
                                  ->first();

    if ($customerOrder) {
        $customerOrder->status = 1;
        $customerOrder->save();
    }

    return redirect()->back()->with('success', 'Payment successful.');
}






}
