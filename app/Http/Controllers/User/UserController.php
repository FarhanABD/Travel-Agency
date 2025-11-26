<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Review;
use App\Models\Wishlists;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function profile(){
        return view('user.profile');
    }

    public function profile_submit(Request $request){
        // dd($request->all());
        $user = User::where('id',auth()->id())->first();

        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'country'=>'required',
            'address'=>'required',
            'state'=>'required',
            'city'=>'required',
            'zip'=>'required',
        ]);
        if($request->photo){
            $request->validate([
                'photo'=>'image|mimes:png,jpg,jpeg|max:2048',
            ]);
            $photoName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('uploads'),$photoName);
            $user->photo = $photoName;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->address = $request->address;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->zip = $request->zip;
        $user->save();

        return back()->with('success','Profile updated successfully');
    }

      public function review()
    {
        $reviews = Review::with('package')->where('user_id',Auth::guard('web')->user()->id)->get();
        //dd($reviews);
        return view('user.review', compact('reviews'));
    }

     public function wishlist()
    {
        $wishlist = Wishlists::with('package')->where('user_id',Auth::guard('web')->user()->id)->get();
        return view('user.wishlist', compact('wishlist'));
    }

    public function wishlist_delete($id)
    {
        $obj = Wishlists::where('id',$id)->first();
        $obj->delete();
        return redirect()->back()->with('success', 'Wishlist item is deleted successfully!');
    }
   
}