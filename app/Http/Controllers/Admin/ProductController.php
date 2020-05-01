<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller;
use Image;
use File;
use App\Http\Requests\ProductValidation;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $products = Product::all();
        return view('backend.product.index',compact('products'));
    }

    function productInsert(ProductValidation $request)
    {
        $info = Product::create($request->except('_token'));
        if($request->hasFile('photo'))
        {
            $product_photo = $request->file('photo');
            $new_name = $info->id.".".$product_photo->getClientOriginalExtension();
            $save_location = "public/uploads/product_photos/".$new_name;
            Image::make($product_photo)->resize(400, 400)->save(base_path($save_location));
            $info->photo = $new_name;
            $info->save();
        }
        return back()->with('status', 'product insert successfully!!');
    }

    function productEdit($product_id)
    {
        $product_info =  Product::findorFail($product_id);
        return view('backend.product.edit' , compact('product_info'));
    }

    function productUpdate(Request $request, $id)
    {
        if($request->hasFile('new_image'))
        {
            unlink(base_path('public/uploads/product_photos/'. Product::findOrFail($id)->photo));
            $product_photo = $request->file('new_image');
            $new_name = $id.".".$product_photo->getClientOriginalExtension();
            $save_location = "public/uploads/product_photos/".$new_name;
            Image::make($product_photo)->resize(400, 400)->save(base_path($save_location));
            Product::findOrFail($id)->update([
                'photo' => $new_name,
            ]);
        }
        $product_name = Product::findOrFail($id)->name;
        Product::findOrFail($request->id)->update([
            'name' => $request->name,
            'unit' => $request->unit,
            'unit_price' => $request->unit_price,
        ]);
        return redirect('admin/product')->withEditstatus($product_name.' Edited successfully!!');
    }

    function productDelete($product_id)
    {
        $product = Product::findorFail($product_id);
        if (File::exists(public_path('uploads/product_photos/'.$product->photo))) {

            unlink(public_path('uploads/product_photos/'.$product->photo));
        }
        $product->delete();

        // Slider::findOrFail($slider_id)->delete();
        return back()->with('deletestatus', 'Product deleted successfully!!');
    }

    function active($product_id)
    {
        Product::where('id',$product_id)->update([
            'status' => '0',
        ]);
        return back();
    }

    function deactive($product_id)
    {
        Product::where('id',$product_id)->update([
            'status' => '1',
        ]);
        return back();
    }

}
