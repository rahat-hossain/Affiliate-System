<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserProfileValidation;
use App\Marketing;
use App\User;
use Image;
use File;
use Carbon\Carbon;
use App\Profile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function profileEdit(UserProfileValidation $request,$id)
    {
        $profile = Profile::where('user_id', $id)->first();
        if ($profile)
        {
            $profile->update($request->except('image'));
            if($request->hasFile('image'))
            {
                $user_photo = $request->file('image');
                $new_name = $id.".".$user_photo->getClientOriginalExtension();
                $save_location = "public/uploads/users_photos/".$new_name;
                Image::make($user_photo)->resize(170, 200)->save(base_path($save_location));
                $profile->photo = $new_name;
                $profile->save();
            }
        }
        else
        {
           $createP = Profile::create([
                'user_id' => $id,
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'alternate_phone' => $request->alternate_phone,
            ]);
            if($request->hasFile('image'))
            {
                $user_photo = $request->file('image');
                $new_name = $id.".".$user_photo->getClientOriginalExtension();
                $save_location = "public/uploads/users_photos/".$new_name;
                Image::make($user_photo)->resize(170, 200)->save(base_path($save_location));
                $createP->photo = $new_name;
                $createP->save();
            }
        }

        User::where('id', $id)->update($request->except('image','_token', 'alternate_phone','address','user_id'));



        return back()->with('status', 'Profile updated successfully!!');
    }
}
