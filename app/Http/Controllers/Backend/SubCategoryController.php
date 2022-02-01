<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\SubSubCategory;


class SubCategoryController extends Controller
{
    public function SubCategoryView(){

    $categories = Category::orderby('category_name_en','ASC')->get();
    $subcategory = Subcategory::latest()->get();
    return view('backend.category.subcategory_view', compact('subcategory','categories'));
  
    }



 public function SubCategoryStore(Request $request){

       $request->validate([
            'category_id' => 'required',
            'subcategory_name_en' => 'required',
            'subcategory_name_hin' => 'required',
        ],[
            'category_id.required' => 'Please Select an option',
            'subcategory_name_en.required' => 'Input SubCategory English Name','
            subcategory_name_hin.required' => 'Input SubCategory Hindi Name',
        ]);

         

    SubCategory::insert([
        'category_id' => $request->category_id,
        'subcategory_name_en' => $request->subcategory_name_en,
        'subcategory_name_hin' => $request->subcategory_name_hin,
        'subcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subcategory_name_en)),
        'subcategory_slug_hin' => str_replace(' ', '-',$request->subcategory_name_hin),
        ]);

        $notification = array(
            'message' => 'SubCategory Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // end method 



    public function SubCategoryEdit($id){
      $categories = Category::orderby('category_name_en','ASC')->get();
    $subcategory = Subcategory::findOrFail($id);
    return view('backend.category.subcategory_edit', compact('subcategory','categories'));
  }


  public function SubCategoryUpdate(Request $request){

     $subcat_id = $request->id;

       SubCategory::findOrFail($subcat_id)->update([
        'category_id' => $request->category_id,
        'subcategory_name_en' => $request->subcategory_name_en,
        'subcategory_name_hin' => $request->subcategory_name_hin,
        'subcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subcategory_name_en)),
        'subcategory_slug_hin' => str_replace(' ', '-',$request->subcategory_name_hin),
        ]);

        $notification = array(
            'message' => 'SubCategory Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.subcategory')->with($notification);
  }




   public function SubCategoryDelete($id){

    SubCategory::findOrFail($id)->delete();

     $notification = array(
            'message' => 'SubCategory Deleted Successfully', 'alert-type' => 'info' 
        );

        return redirect()->back()->with($notification);
  }




///////////// Sub-> Sub Category //////////////

 public function SubSubCategoryView(){

  $categories = Category::orderby('category_name_en','ASC')->get();
    $subsubcategory = SubSubcategory::latest()->get();
    return view('backend.category.sub_subcategory_view', compact('subsubcategory','categories'));
    }


    public function GetSubCategory($category_id){

        $subcat = Subcategory::where('category_id', $category_id)->orderby('subcategory_name_en', 'ASC')->get();
        return json_encode($subcat); 
    } 


      public function GetSubSubCategory($subcategory_id){

        $subsubcat = SubSubcategory::where('subcategory_id', $subcategory_id)->orderby('subsubcategory_name_en', 'ASC')->get();
        return json_encode($subsubcat);
    }
    



     public function SubSubCategoryStore(Request $request){

       $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'subsubcategory_name_en' => 'required',
            'subsubcategory_name_hin' => 'required',
        ],[
            'category_id.required' => 'Please Select an option',
            'subsubcategory_name_en.required' => 'Input SubSubCategory English Name',
        ]);

         

    SubSubCategory::insert([
        'category_id' => $request->category_id,
        'subcategory_id' => $request->subcategory_id,
        'subsubcategory_name_en' => $request->subsubcategory_name_en,
        'subsubcategory_name_hin' => $request->subsubcategory_name_hin,
        'subsubcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subsubcategory_name_en)),
        'subsubcategory_slug_hin' => str_replace(' ', '-',$request->subsubcategory_name_hin),
        ]);

        $notification = array(
            'message' => 'SubSubCategory Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // end method 



    public function SubSubCategoryEdit($id){
        $categories = Category::orderby('category_name_en','ASC')->get();
        $subcategories = SubCategory::orderby('subcategory_name_en','ASC')->get();
        $subsubcategories = SubSubcategory::findOrFail($id);
        return view('backend.category.sub_subcategory_edit', compact('categories', 'subcategories', 'subsubcategories'));
    }


    public function SubSubCategoryUpdate(Request $request){

     $subsubcat_id = $request->id;

        SubSubCategory::findOrFail($subsubcat_id)->update([
        'category_id' => $request->category_id,
        'subcategory_id' => $request->subcategory_id,
        'subsubcategory_name_en' => $request->subsubcategory_name_en,
        'subsubcategory_name_hin' => $request->subsubcategory_name_hin,
        'subsubcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subsubcategory_name_en)),
        'subsubcategory_slug_hin' => str_replace(' ', '-',$request->subsubcategory_name_hin),
        ]);

        $notification = array(
            'message' => 'SubSubCategory Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.subsubcategory')->with($notification);

    } // end method 



     public function SubSubCategoryDelete($id){

    SubSubCategory::findOrFail($id)->delete();

     $notification = array(
            'message' => 'SubSubCategory Deleted Successfully', 'alert-type' => 'info' 
        );

        return redirect()->back()->with($notification);
  }

}
