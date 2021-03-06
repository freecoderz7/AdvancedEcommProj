<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Product;

class IndexController extends Controller
{
    public function index(){
      $sliders = Slider::where('status',1)->orderby('id','DESC')->limit(3)->get();
      $products = Product::where('status',1)->orderby('id','DESC')->limit(6)->get();
      $categories = Category::orderBy('category_name_en', 'ASC')->get();
        return view('frontend.index',compact('categories','sliders','products'));
    }

      public function UserLogout(){
        Auth::logout();
        return Redirect()->route('login');
    }

      public function UserProfile(){
        $id = Auth::user()->id;
        $user = user::find($id);
        return view('frontend.profile.user_profile', compact('user'));
    }

      public function UserProfileStore(Request $request){
        $data = User::find(Auth::user()->id);
        $data->name = $request->name;    
        $data->email = $request->email;
        $data->phone = $request->phone;

        if($request->file('profile_photo_path')){
            $file = $request->file('profile_photo_path');
           unlink(public_path('upload/user_images/'.$data->profile_photo_path)); 
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['profile_photo_path'] = $filename;
        }
        $data->save();


        $notification = array(
            'message' => 'User Profile Updated Successfully', 'alert-type' => 'success' 
        );

        return redirect()->route('dashboard')->with($notification);
    }

      public function UserChangePassword(){
          $id = Auth::user()->id;
        $user = user::find($id);
         return view('frontend.profile.change_password',compact('user'));
    }


    public function UserPasswordUpdate(Request $request){

        $validateData = $request->validate([
            'oldpassword' => 'required',  
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = Auth::User()->password;
        if(Hash::check($request->oldpassword,$hashedPassword)){
         $user = User::find(Auth::id());
         $user->password = Hash::make($request->password);
         $user->save();
         Auth::logout();
         return redirect()->route('user.logout');
     }else{
            return redirect()->back();
        }


    }

}