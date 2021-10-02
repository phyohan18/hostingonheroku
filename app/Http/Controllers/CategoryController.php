<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);

        return view('dashboard', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {

        if($request['is_publish'] == null)
        {
            $request['is_publish'] = false;
        }
        $validated = $request->validate([
            'name'=> [
                'required',
                Rule::unique('categories'),
            ],
            'is_publish'=>'boolean',
            'category_photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_icon'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($category_photo = $request->file('category_photo')) {
            $destinationPath = 'image/photo/';
            $categoryPhoto = date('YmdHis') . "." . $category_photo->getClientOriginalExtension();
            $category_photo->move($destinationPath, $categoryPhoto);
            $validated['category_photo'] = $categoryPhoto;
        }

        if ($category_icon = $request->file('category_icon')) {
            $destinationPathForIcon = 'image/icon/';
            $categoryIcon = date('YmdHis') . "." . $category_icon->getClientOriginalExtension();
            $category_icon->move($destinationPathForIcon, $categoryIcon);
            $validated['category_icon'] = $categoryIcon;
        }

        Category::create($validated);

        return redirect()->route('categories.index')
                ->with('success','You have successfully added a new category');
    }

    public function show($id)
    {
        
    }

    public function edit($category)
    {
        $category = Category::find($category);
        return view('categories.edit',compact('category'));
    }

    public function update(Request $request, $id)
    {
        if($request['is_publish'] == null)
        {
            $request['is_publish'] = false;
        }


        $validated = $request->validate([
            'name'=> [
               'required',
                Rule::unique('categories')->ignore($id),
            ],
            'is_publish'=>'boolean',
            'category_photo'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_icon'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
       
    
        $category = Category::find($id);
        if($request->hasFile('category_photo'))
        {
            $destinationPath = 'image/photo/'.$category->category_photo;
            if(File::exists($destinationPath))
            {
                File::delete($destinationPath);
            }
            $file = $request->file('category_photo');
            $categoryPhoto = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move('image/photo/', $categoryPhoto);
            $validated['category_photo'] = $categoryPhoto;
        }
        else
        {
            $validated['category_photo'] = $category->category_photo;
        };

        if($request->hasFile('category_icon'))
        {
           $destinationPath = 'image/icon/'.$category->category_icon;
           if(File::exists($destinationPath))
           {
               File::delete($destinationPath);
           }
           $file = $request->file('category_icon');
           $categoryIcon = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move('image/icon/', $categoryIcon);
            $validated['category_icon'] = $categoryIcon;
        }
        else
        {
            $validated['category_icon'] = $category->category_icon;
         }

        $category->name = $validated['name'];
        $category->is_publish = $validated['is_publish'];
        $category->category_photo = $validated['category_photo'];
        $category->category_icon = $validated['category_icon'];

        $category->save();
       
        return redirect()->route('categories.index')
                ->with('success','You have successfully updated the category');

    }

    public function destroy($category)
    {
        $category = Category::find($category);
        $destinationPathForIcon = 'image/icon/'.$category->category_icon;
        if(File::exists($destinationPathForIcon))
        {
            File::delete($destinationPathForIcon);
        }
        $destinationPathForPhoto = 'image/photo/'.$category->category_photo;
        if(File::exists($destinationPathForPhoto))
        {
            File::delete($destinationPathForPhoto);
        }
        $category->delete();

        return redirect()->route('categories.index')
                ->with('success','You have successfully deleted the category');
    }
}
