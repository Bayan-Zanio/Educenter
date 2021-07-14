<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Admin\return__METHOD__;
use App\Http\Requests\CategoryRequest;
use App\Rules\WordsFilter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use App\Models\User;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $categories=Category::when($request->name, function($query,$value){
            $query->where('categories.name','LIKE',"%$value%")
            ->orWhere('categories.description','LIKE',"%$value%");
        })
        ->when($request->parent_id,function($query,$value){
            $query->where('categories.parent_id','=',$value);
        })
       /* ->leftJoin('categories as parents','parents.id','=','categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name'
        ])*/
        // Eager loading
        ->with('parent')
        ->get();

        //SELECT * FROM categories 
        //SELECT * FROM categories WHERE id IN(....)

       /* $query=Category::query();
        if($request->name){
           $query->where(function($query)use ($request){
           $query->where('name','LIKE',"%{$request->name}%")
           ->orWhere('description','LIKE',"%{$request->name}%");
           });
        }
        if($request->parent_id){
            $query->where('parent_id','=',$request->parent_id);   
        }
        $categories=$query->get();*/

        $parents=Category::orderBy('name','asc')->get();
        return view('admin.categories.index',
        [
            'categories'=>$categories,
            'parents'=>$parents,
        ]);
    }

    public function create()
    {  
        $parents=Category::orderBy('name','asc')->get();
        $title='Add Category';
        //return view('admin.categories.create',compact('parents','title'));
        return view('admin.categories.create',[
        'parents' => $parents,
        'title' => 'Ass Category',
        'category' => new Category(),
        ]);
    }

    public function store(Request$request)
    {
        //$request->validate(Category::rules());
       /* $request->validate(
            [
                'name'              =>      'required|string|max:20',
                'email'             =>      'required|email|unique:users,email',
                'phone'             =>      'required|numeric|max:10',
                'password'          =>      'required|alpha_num|min:6',
                'confirm_password'  =>      'required|same:password',
                'address'           =>      'required|string',
                'date_of_birth'     =>      'required|date_format:Y-M-D|before:-14 years'
            ]
        );

        $dataArray      =       array(
            "name"          =>          $request->name,
            "email"         =>          $request->email,
            "phone"         =>          $request->phone,
            "address"       =>          $request->address,
            "password"      =>          $request->password,
            "date_of_birth" =>          $request->date_of_birth
        );

        $user           =       User::create($dataArray);
        if(!is_null($user)) {
            return back()->with("success", "Success! Registration completed");
        }

        else {
            return back()->with("failed", "Alert! Failed to register");
        }*/

        $this->validate( $request , [
            'name'=>'required|string|max:255|min:3|unique:categories',
            'description'=>'nullable|min:5',
            'parent_id'=>[
                'nullable',
                'exists:categories,id'
            ],
            'image'=>[
                'nullable',
                'image',
                'max:1048576',
                'dimension:min_width=200,min_heigh=200,ratio=9/16'
            ],
            'status'=>'required|in:active,inactive',

        ]);
       /* $request->validate([
            'name'=>'required|alpha|max:255|min:3|unique:categories,name',
            'description'=>'nullable|min:5',
            'parent_id'=>[
                'nullable',
                'exists:categories,id'
            ],
            'image'=>[
                'nullable',
                'image',
                'max:1048576',
                'dimension:min_width=200,min_heigh=200,ratio=9/16'
            ],
            'status'=>'required|in:active,inactive',

        ]);

        $Validator=Validator::make(
            $request->all(),
            [
                'name'=>'required|alpha|max:255|min:3|unique:categories,name',
                'description'=>'nullable|min:5',
                'parent_id'=>[
                    'nullable',
                    'exists:categories,id'
                ],
                'image'=>[
                    'nullable',
                    'image',
                    'max:1048576',
                    'dimension:min_width=200,min_heigh=200,ratio=9/16'
                ],
                'status'=>'required|in:active,inactive',

            ]
        );

        $result=$Validator->fails();
        $failed=$Validator->failed();
        $errors=$Validator->errors();
        $clean=$Validator->validated();
        dd($clean);
           
        */

        //$this->validateRequest($request);

        $category=new Category();
        $category->name=$request->name;  //$request->get('name');
        $category->slug=Str::slug($request->name);
        $category->description=$request->input('description');
        $category->parent_id=$request->post('parent_id');
        $category->status=$request->post('status');
        $category->save();
        session()->flash('success','Category added!');
        return redirect(route('admin.categories.index'));
       
    }
   

    public function show($id)
    {
        
        return view('admin.categories.show',
        [
            'category'=>Category::findOrFail($id),
        ]);
    }

    public function edit($id)
    {
     // $category=Category::where('id','=',$id)->first();
      $category=Category::findOrFail($id);  
    
      
      $parents=Category::where('id','<>',$id)->orderBy('name','asc')->get();

      return view('admin.categories.edit',
    [
        'id'=>$id,
        'category'=>$category,
        'parents'=>$parents, 
    ]
    );
    }

    public function update(Request $request, $id)
    {
        $category=Category::findOrFail($id); 
        if($category==null)
        {
            abort(404);
        }  

       // $this->validateRequest($request, $id);


      $category=Category::find($id);
      $category->name=$request->name;  //$request->get('name');
      $category->slug=Str::slug($request->name);
      $category->description=$request->input('description');
      $category->parent_id=$request->post('parent_id');
      $category->status=$request->post('status');
      $category->save();  

      return redirect()
             ->route('admin.categories.index')
             ->with('success','Category updated');
    }

    public function destroy($id)
    {
        //Method 1
        //$category=Category::find($id);
        // $category->delete();

        // Method 2
        Category::where('id','=',$id)->delete();

        // Method 3
        Category::destroy($id);
        return redirect()
               ->route('admin.categories.index')
               ->with('success','Category delete');

    }

    public function trash()
    {
        return view('admin.categories.trash' , [
            'categories' => Category::onlyTrashed()->paginate(),
        ]);
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()
        ->route('admin.categories.trash')
        ->with('success' , 'Category restord');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()
        ->route('admin.categories.trash')
        ->with('success' , 'Category deleted forever.');
    }

    protected function validateRequest(Request $request, $id=0)
    {
        
        $request->validate([
            'name'=>[
                'required',
                'string',
                'max:255',
                'min:3',
                //"unique:categories,name,$id"
                //(new Unique('categories','name'))->ignore($id),
                //Rule::unique('categories','name')->ignore($id)
            ],
            'description'=>[
                'required',
            'min:5',
           /* function($attribute,$value,$fail)
            {
                if(stripos($value,'laravel') !==false){
                   
                    $fail('You can not use the word "laravel"!');
                }
            }
        */
                // new WordsFilter(['php','laravel']),
                'filter:laravel,php'
               ],
            'parent_id'=>[
                'nullable',
                'exists:categories,id'
            ],
            'image'=>[
                'nullable',
                'image',
                'max:1048576',
                'dimension:min_width=200,min_heigh=200,ratio=9/16'
            ],
            'status'=>'required|in:active,inactive',

        ],
          [
              'name.required'=>'هذا الحقل مطلوب'
          ],
    );
    }

    public function storeProduct(Request $request,$id)
    {
        $category=Category::findOrFail($id);

        $product=$category->products()->create([
            'name'=>'Product Name',
            'price'=>10,
            
        ]);

        //$product->category()->associate($category);
        //$product->category()->dissociate();
    }
}
