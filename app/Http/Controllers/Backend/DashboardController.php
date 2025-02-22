<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPasswordUpdateRequest;
use App\Http\Requests\AdminProfileUpdateRequest;
use App\Models\Admin;
use App\Traits\ImageUploadTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Alert;



class DashboardController extends Controller
{
    use ImageUploadTraits;
    public function index()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('user'));
    }

    public function profileUpdate(AdminProfileUpdateRequest $request, $id)
    {
        // Save Image Upload Traits
        $imagePath = $this->updateImage($request, 'image', 'uploads/profile', $request->old_image);
        $admin = Admin::findOrFail($id);
        $admin->image = !empty($imagePath) ? $imagePath : $request->old_image;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        return response()->json([
            'success' => true,
            'message' => __('Profile updated successfully!')
        ]);
    }

    public function passwordUpdate(AdminPasswordUpdateRequest $request, $id)
    {

        // dd($request->all());
        $admin = Auth::guard('admin')->user();
        $validatedData = $request->validated();

        // Check if old password matches
        if (!Hash::check($validatedData['old_password'], $admin->password)) {
            return response()->json([
                'errors' => ['old_password' => ['The old password is incorrect.']]
            ], 422);
        }


        // Update password
        $admin->password = Hash::make($validatedData['password']);
        $admin->save();


        return response()->json([
            'success' => true,
            'message' => __('Password updated successfully!')
        ]);
    }
}
