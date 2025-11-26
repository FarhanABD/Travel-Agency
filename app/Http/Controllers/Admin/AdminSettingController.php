<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class AdminSettingController extends Controller
{
    public function index()
    {
        // Fetch the settings record, assuming ID 1 holds the global settings
        $setting = Setting::where('id',1)->first();
        return view('admin.setting.index',compact('setting'));
    }
    
    public function update(Request $request)
    {
        $obj = Setting::where('id',1)->first();
        
        // --- Logo Update ---
        if($request->hasFile('logo'))
        {
            $request->validate([
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Check if an old logo exists in the database
            if($obj->logo != '')
            {
                $old_logo_path = public_path('uploads/setting/'.$obj->logo);
                
                // FIX: Check if the file physically exists before attempting to delete it
                if (file_exists($old_logo_path)) {
                    unlink($old_logo_path);
                }
            }

            $final_name = 'logo_'.time().'.'.$request->logo->extension();
            $request->logo->move(public_path('uploads/setting'), $final_name);
            $obj->logo = $final_name;
        }

        // --- Favicon Update ---
        if($request->hasFile('favicon'))
        {
            $request->validate([
                'favicon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Check if an old favicon exists in the database
            if($obj->favicon != '')
            {
                $old_favicon_path = public_path('uploads/setting/'.$obj->favicon);

                // FIX: Check if the file physically exists before attempting to delete it
                if (file_exists($old_favicon_path)) {
                    unlink($old_favicon_path);
                }
            }

            $final_name1 = 'favicon_'.time().'.'.$request->favicon->extension();
            $request->favicon->move(public_path('uploads/setting'), $final_name1);
            $obj->favicon = $final_name1;
        }

        // --- Banner Update ---
        if($request->hasFile('banner'))
        {
            $request->validate([
                'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Check if an old banner exists in the database
            if($obj->banner != '')
            {
                $old_banner_path = public_path('uploads/setting/'.$obj->banner);

                // FIX: Check if the file physically exists before attempting to delete it
                if (file_exists($old_banner_path)) {
                    unlink($old_banner_path);
                }
            }

            $final_name2 = 'banner_'.time().'.'.$request->banner->extension();
            $request->banner->move(public_path('uploads/setting'), $final_name2);
            $obj->banner = $final_name2;
        }

        // --- Text Fields Update ---
        $obj->top_bar_phone = $request->top_bar_phone;
        $obj->top_bar_email = $request->top_bar_email;
        $obj->footer_address = $request->footer_address;
        $obj->footer_phone = $request->footer_phone;
        $obj->footer_email = $request->footer_email;
        $obj->facebook = $request->facebook;
        $obj->twitter = $request->twitter;
        $obj->youtube = $request->youtube;
        $obj->linkedin = $request->linkedin;
        $obj->instagram = $request->instagram;
        $obj->copyright = $request->copyright;
        $obj->save();

        return redirect()->back()->with('success','Setting is Updated Successfully');
    }
}