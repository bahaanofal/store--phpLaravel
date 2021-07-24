<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\Filter;
use ArrayObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Traversable;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    // لارسال رمز التحقق 
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified']);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* 
            SELECT categories.*, parents.name as parent_name 
            FROM categories JOIN categories as parents
            ON parents.id = categories.parent_id
            WHERE status = 'active'
            ORDER BY created_at DESC, name ASC
        */
        // return collection of Category model object
        $entries = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id') // categories as parents // لأنه الجدول بأشر على نفسه بالمفتاح الأجنبي
            ->select(['categories.*', 'parents.name as parent_name'])
            // ->where('categories.status', '=', 'active')
            ->orderBy('categories.created_at', 'DESC')
            ->orderBy('name', 'ASC')
            ->withTrashed()
            ->get();


        /* $categories = new ArrayObject([]); // عبارة عن مصفوفة على شكل كائن
        if ($entries instanceof Traversable) { // هل المتغير عبارة عن كائن؟
            echo count($entries);
            return;
        } */

        $success = session()->get('success'); // get from session and assigned in variable
        // session()->forget('success'); // delete from session

        return view('admin.categories.index', [
            'categories' => $entries,
            'title' => 'Categories List',
            'success' => $success
        ]);
        // return view('admin/categories/index'); // view نفس المساراللي فوقه بيوديني على مجلد ال
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        $parents = Category::get();
        // return view('admin.categories.create', compact('parents')); // هادا نفس الكود اللي تحته
        return view('admin.categories.create', [
            'parents' => $parents,
            'category' => $category
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
        // return array of all form fields
        // $request->all();


        // Validation rules
        $rules = [
            'name' => [
            'required',
            'string',
            'min:3',
            'unique:categories',
            new Filter(['bahaa', 'admin']),
            ],
            'parent_id' => 'int|nullable|exists:categories,id',
            'description' => ['nullable','min:5',new Filter(['php', 'laravel', 'css'])],
            'status' => 'required|in:active,draft',
            'image' => 'image|max:512000|dimention:min_width=300,min_height=300'
        ];
        $clean = $request->validate($rules, [
            'required' => 'The :attribute is required!',
            'status.required' => 'you must select one status'
        ]);
        // $clean = $this->validate($request, $rules); // نفس السطر اللي فوقه

        // لو بدي أستخدم رسالة الخطأ وأبعتها لصفحة تانية أو أستخدمها بمكان تاني
        // $data = $request->all();
        // $validator = Validator::make($data, $rules);
        // if($validator->fails()) {
        //     return $validator->errors(); // أو بعمللها توجيه لراوت تاني
        // }

        // return single field value
        // $request->description;
        // $request->get('description');
        // $request->input('description');
        // $request->post('description');
        // $request->query('description'); // ?description=value

        // ********************* Method #1 **********************
        // $category = new Category();
        // $category->name = $request->post('name');
        // $category->slug = Str::slug($request->post('name'));
        // $category->parent_id = $request->post('parent_id');
        // $category->description = $request->post('description');
        // $category->status = $request->post('status', 'active');
        // $category->save();


        // ************* Method #2 : Mass assignment *************
        // mass assignment => fillable لازم نضيف بالمودل متغير ال 
        $request->merge([
            'slug' => Str::slug($clean['name']),
        ]);

        Category::create($request->all());

        
        
        // ************* Method #3 : Mass assignment *************
        // $category = new Category([
        //     'name' => $request->post('name'),
        //     'slug' =>  Str::slug($request->post('name')),
        //     'parent_id' => $request->post('parent_id'),
        //     'description' => $request->post('description'),
        //     'status' => $request->post('status', 'active')
        // ]);
        // $category->save();
        
        // PRG : Post Redirect Git
        return redirect()->route('categories.index')->with('success', 'Category [ ' . $request->name . ' ] was created!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // وبنعرض بيانات الفئة أو المنتج حسب العنصر view بنعمل صفحة  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Category::where('id', '=', '$id')->first();
        $category = Category::find($id);
        if(!$category) {
            abort(404);
        }
        $parents = Category::withTrashed()->where('id', '<>', $id)->get();
        // بستثني العنصر اللي بعدّل عليه عشان مش ممكن انو يكون أب لنفسه

        // return view('admin.categories.edit', [
        //     'category' => $category,
        //     'parents' => $parents
        // ]);
        return view('admin.categories.edit', compact('category', 'parents'));
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
        // ************* Method #4 : Mass assignment *************
        // Category::where('id', '=', $id)->update($request->all());
        
        $category = Category::find($id);
        
        // Validation rules
        $rules = [
            'name' => ['required', 'string','min:3', Rule::unique('categories', 'id')->ignore($id)],
            'parent_id' => 'int|nullable|exists:categories,id',
            'description' => 'nullable|min:5',
            'status' => 'required|in:active,draft',
            'image' => 'image|max:512000|dimention:min_width=300,min_height=300'
        ];
        $clean = $request->validate($rules);


        
        // **************** Method #1 **********************
        // $category->name = $request->post('name');
        // $category->parent_id = $request->post('parent_id');
        // $category->description = $request->post('description');
        // $category->status = $request->post('status');
        // $category->save();


        // ************* Method #2 : Mass assignment *************
        $category->update($request->all());
        

        // ************* Method #3 : Mass assignment *************
        // $category->fill($request->all())->save();

        // PRG
        return redirect(route('categories.index'))->with('success', 'Category [ ' . $category->name . ' ] Was Updated!');
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Method #1    // بستعملها لما بدي آخد معلومات العنصر قبل حذفه
        $category = Category::find($id);
        // $category->delete();
        
        // Method #2
        Category::destroy($id);
        
        // Method #3
        // Category::where('id', '=', $id)->delete();

        // session()->put('success', 'Category [ ' . $category->name . ' ] was deleted!');
        
        
        // PRG
        return redirect()->route('categories.index')->with('success', 'Category [ ' . $category->name . ' ] Was Deleted!');
    }
}





// ************************ Session **********************
// write into session
// Session::put('success', 'Category deleted');
// session()->put('success', 'Category deleted');
// session(['success' => 'Category deleted']);

// // read from session
// Session::get('success');
// session()->get('success');
// session('success');

// // delete from session
// Session::forget('success');
// session()->forget('success');