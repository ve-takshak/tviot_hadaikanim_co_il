<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InsuranceCompany;
use App\Models\Lawsuit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Takshak\Imager\Facades\Imager;
use App\Services\LawsuitService;

class AdminController extends Controller
{
    protected $lawsuitService;

    public function __construct(LawsuitService $lawsuitService)
    {
        $this->lawsuitService = $lawsuitService;
    }
    public function index(Request $request)
    {
        $lawsuits = $this->lawsuitService->getFilteredLawsuits($request);
        return view('admin.dashboard', compact('lawsuits'));
        
    }

    public function profileEdit()
    {
        return view('admin.profile_edit');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name'      =>  'required',
            'email'     =>  'required|email|unique:users,email,' . auth()->id(),
            'mobile'    =>  'required',
            'password'  =>  'nullable|min:6',
        ]);

        $user = auth()->user();
        $user->name          =  $request->post('name');
        $user->mobile        =  $request->post('mobile');

        if ($user->email != $request->post('email')) {
            $user->email_verified_at = null;
        }
        if ($request->post('password')) {
            $user->password = Hash::make($request->post('password'));
        }
        if ($request->file('profile_img')) {
            $user->profile_img = 'users/' . time() . '.jpg';
            Imager::init($request->file('profile_img'))
                ->resizeFit(400, 400)->inCanvas('#fff')
                ->basePath(storage_path('app/public/'))
                ->save($user->profile_img);
        }
        $user->email =  $request->post('email');
        $user->save();

        return to_route('profile.edit')->withSuccess('SUCCESS !! Your profile is successfully updated');
    }
}
