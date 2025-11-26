<?php

namespace App\Http\Controllers\Admin;

use Mail;
use App\Models\User;
use App\Models\Admin;
use App\Mail\Websitemail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(){
        return view('admin.login');
    }

    public function dashboard()
{
    return view('admin.dashboard');
}

    public function login_submit(Request $request){
        $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $check = $request->all();
    $data = [
        'email' => $check['email'],
        'password' => $check['password']
    ];

    if(Auth::guard('admin')->attempt($data)) {
        return redirect()->route('admin_dashboard')->with('success','Login is successful!');
    } else {
        return redirect()->route('admin_login')->with('error','The information you entered is incorrect! Please try again!');
    }
    }

    public function profile(){
        return view('admin.profile');
    }

    public function profile_submit(Request $request){
        $request->validate([
            'name' => [''],
            'email' => ['required'],
            'photo' => 'nullable|image|mimes:jpg,png,jpeg,svg|max:2048'
        ]);

        $admin = Admin::where('id',Auth::guard('admin')->user()->id)->first();

          if ($request->hasFile('photo')) {

        // Hapus foto lama jika ada
        if ($admin->photo && file_exists(public_path('uploads/admin/'.$admin->photo))) {
            unlink(public_path('uploads/admin/'.$admin->photo));
        }

        // Simpan foto baru
        $file     = $request->file('photo');
        $filename = 'admin_'.time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/admin/'), $filename);

        // Update database
        $admin->photo = $filename;
    }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->update();
    
        return redirect()->route('admin_profile')->with('succces','profile berhasil diupdate');
    }

     public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin_login')->with('success','Logout is successful!');
    }

    public function forgetPassword(){
        return view('admin.forget_password');
    }

   
    public function forget_password_submit(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    $user = User::where('email',$request->email)->first();
    if(!$user) {
        return redirect()->back()->with('error','Email is not found');
    }

    $token = hash('sha256',time());
    $user->token = $token;
    $user->update();

    $reset_link = url('admin/reset-password/'.$token.'/'.$request->email);
    $subject = "Password Reset";
    $message = "To reset password, please click on the link below:<br>";
    $message .= "<a href='".$reset_link."'>Click Here</a>";

    \Mail::to($request->email)->send(new Websitemail($subject,$message));

    return redirect()->back()->with('success','We have sent a password reset link to your email. Please check your email. If you do not find the email in your inbox, please check your spam folder.');
}

public function reset_password($token,$email)
{
    $admin = Admin::where('email',$email)->where('token',$token)->first();
    if(!$admin) {
        return redirect()->route('admin_login')->with('error','Token or email is not correct');
    }
    return view('admin.reset_password', compact('token','email'));
}

public function reset_password_submit(Request $request, $token, $email)
{
    $request->validate([
        'password' => ['required'],
        'confirm_password' => ['required','same:password'],
    ]);

    $admin = Admin::where('email',$request->email)->where('token',$request->token)->first();
    $admin->password = Hash::make($request->password);
    $admin->token = "";
    $admin->update();

    return redirect()->route('admin_login')->with('success','Password reset is successful. You can login now.');
}

}