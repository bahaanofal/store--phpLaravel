<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-any', Product::class);

        $products = Product::with('category.parent')
            // join('categories', 'categories.id', '=', 'products.category_id')
            // ->select(['products.*', 'categories.name as category_name'])
            ->orderBy('products.created_at', 'DESC')
            ->orderBy('products.name', 'ASC')
            ->paginate();
        
        $success = session()->get('success');
        return view('admin.products.index', [
            'products' => $products,
            'success' => $success
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Product::class);
        
        // value => $name , key => $id بترجع مصفوفة 
        $categories = Category::pluck('name', 'id');
        return view('admin.products.create', [
            'categories' => $categories,
            'product' => new Product()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        $request->validate(Product::validateRules());

        // ضفتها في المودل
        // $request->merge([
        //     'slug' => Str::slug($request->post('name'))
        // ]);
        
        $product = Product::create($request->all());
        
        return redirect()->route('products.index')->with('success', 'Product ( ' . $product->name . ' ) was Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // SELECT * FROM ratings WHERE rateable_id = 1 AND rateable_type = 'App\Model\Product'
        return $product->ratings;
        
        $this->authorize('view', $product);
        
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        
        $this->authorize('update', $product);

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::pluck('name', 'id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $request->validate(Product::validateRules());
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image_path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $request->merge([
                'image_path' => $image_path
            ]);
        }
        
        $product = Product::findOrFail($id);

        $this->authorize('update', $product);
        
        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'product ( ' . $product->name . ' ) was Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        $this->authorize('delete', $product);

        $product->delete();

        // يعني ممكن أرجع الصورة softDeletes لحذف الصورة عند حذف المنتج، ما بحذف الصورة عشان استخدمت ال
        // Storage::disk('public')->delete($product->image_path); 
        // unlink(public_path('uploads' . $product->image_path));

        return redirect()->route('products.index')->with('success', 'product ( ' . $product->name . ' ) was Deleted.');

    }

    public function trash()
    {
        $products = Product::onlyTrashed()->paginate();
        return view('admin.products.trash', compact('products'));
    }

    public function restore(Request $request, $id = null)
    {
        if ($id) {
            $product = Product::onlyTrashed()->findOrFail($id);
            $product->restore();
            return redirect()->route('products.trash')->with('success', 'product ( ' . $product->name . ' ) was restored.');
        }
        Product::onlyTrashed()->restore();
        return redirect()->route('products.trash')->with('success', 'All trashed products was restored.');
    }
    
    public function forceDelete($id = null)
    {
        if ($id) {
            $product = Product::onlyTrashed()->findOrFail($id);
            $product->forceDelete();
            return redirect()->route('products.trash')->with('success', 'product ( ' . $product->name . ' ) was deleted forever.');
        }
        Product::onlyTrashed()->forceDelete();
        return redirect()->route('products.trash')->with('success', 'All trashed products was deleted forever.');
    }
}
