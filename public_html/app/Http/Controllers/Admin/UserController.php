<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Takshak\Adash\Models\Role;
use Takshak\Adash\Traits\ImageTrait;
use Takshak\Imager\Facades\Imager;
class UserController extends Controller
{
    use ImageTrait;
    public function index(Request $request)
    {
        if($request->get('role_id') == 1){
            $this->authorize('admin_access');
        } elseif($request->get('role_id') == 2){
            $this->authorize('employee_access');
        }elseif ($request->get('role_id') == 3) {
            $this->authorize('agent_access');
        }elseif ($request->get('role_id') == 5) {
            $this->authorize('client_access');
        }elseif ($request->get('role_id') == 6) {
            $this->authorize('lawyer_access');
        }
        $roleName='';
        $query = User::with('roles');
        if ($request->get('search')) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('search') . '%');
                $query->orWhere('email', 'like', '%' . $request->get('search') . '%');
                $query->orWhere('mobile', 'like', '%' . $request->get('search') . '%');
            });
        }
        if ($request->get('role_id')) {
            $query->whereHas('roles', function ($query) {
                $query->where('roles.id', request()->get('role_id'));
            });
            $role = Role::find($request->get('role_id'));
            if ($role) {
                $roleName = ucfirst($role->name).'s';
            }
        }
        $users = $query->paginate(25)->withQueryString();
        $roles = Role::orderBy('name', 'DESC')->get();
        return view('admin.users.index')->with('users', $users)->with('roles', $roles)->with('roleName',$roleName);
    }

    public function create(Request  $request)
    {
        if($request->get('role_id') == 1){
            $this->authorize('admin_create');
        } elseif($request->get('role_id') == 2){
            $this->authorize('employee_create');
        }elseif ($request->get('role_id') == 3) {
            $this->authorize('agent_create');
        }elseif ($request->get('role_id') == 5) {
            $this->authorize('client_create');
        }elseif ($request->get('role_id') == 6) {
            $this->authorize('lawyer_create');
        }
        $roles = Role::orderBy('name', 'DESC')->get();
        return view('admin.users.create')->with('roles', $roles);
    }

    public function store(Request $request)
    {
        if($request->get('role_id') == 1){
            $this->authorize('admin_create');
        } elseif($request->get('role_id') == 2){
            $this->authorize('employee_create');
        }elseif ($request->get('role_id') == 3) {
            $this->authorize('agent_create');
        }elseif ($request->get('role_id') == 5) {
            $this->authorize('client_create');
        }elseif ($request->get('role_id') == 6) {
            $this->authorize('lawyer_create');
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required',
            'password' => 'required|confirmed',
            'roles' => 'required|array|min:1',
            'email_verified' => 'required|boolean',
            'profile_img' => 'nullable|image',
        ]);

        $user = new User;
        $user->name = $request->post('name');
        $user->email = $request->post('email');
        $user->mobile = $request->post('mobile');
        $user->password = Hash::make($request->post('password'));
        $user->email_verified_at = $request->post('email_verified') ? date('Y-m-d H:i:s') : null;

        if ($request->file('profile_img')) {
            $user->profile_img = 'users/' . time() . '.jpg';
            Imager::init($request->file('profile_img'))
                ->resizeFit(400, 400)->inCanvas('#fff')
                ->basePath(storage_path('app/public/'))
                ->save($user->profile_img);
        }

        $user->save();

        $user->roles()->sync($request->post('roles'));
        return to_route('users.index', ['role_id' => request('role_id')])->withSuccess('SUCCESS !! New user is successfully created');
    }

    public function edit(User $user, Request $request)
    {
        if($request->get('role_id') == 1){
            $this->authorize('admin_update');
        } elseif($request->get('role_id') == 2){
            $this->authorize('employee_update');
        }elseif ($request->get('role_id') == 3) {
            $this->authorize('agent_update');
        }elseif ($request->get('role_id') == 5) {
            $this->authorize('client_update');
        }elseif ($request->get('role_id') == 6) {
            $this->authorize('lawyer_update');
        }
        $roles = Role::orderBy('name', 'DESC')->get();
        return view('admin.users.edit')->with('roles', $roles)->with('user', $user);
    }

    public function update(Request $request, User $user)
    {
        if($request->get('role_id') == 1){
            $this->authorize('admin_update');
        } elseif($request->get('role_id') == 2){
            $this->authorize('employee_update');
        }elseif ($request->get('role_id') == 3) {
            $this->authorize('agent_update');
        }elseif ($request->get('role_id') == 5) {
            $this->authorize('client_update');
        }elseif ($request->get('role_id') == 6) {
            $this->authorize('lawyer_update');
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required',
            'roles' => 'required|array|min:1',
            'email_verified' => 'required|boolean',
        ]);

        $user->name = $request->post('name');
        $user->email = $request->post('email');
        $user->mobile = $request->post('mobile');
        $user->email_verified_at = $request->post('email_verified') ? now() : null;

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
        $user->save();

        $user->roles()->sync($request->post('roles'));

        return to_route('users.index', ['role_id' => request('role_id')])->withSuccess('SUCCESS !! User is successfully updated');
    }

    public function show(User $user)
    {
        if(request('role_id') == 1){
            $this->authorize('admin_show');
        } elseif(request('role_id') == 2){
            $this->authorize('employee_show');
        }elseif (request('role_id') == 3) {
            $this->authorize('agent_show');
        }elseif (request('role_id') == 5) {
            $this->authorize('client_show');
        }elseif (request('role_id') == 6) {
            $this->authorize('lawyer_show');
        }
        return view('admin.users.show')->with('user', $user);
    }

    public function statusToggle(User $user)
    {
        if(request('role_id') == 1){
            $this->authorize('admin_update');
        } elseif(request('role_id') == 2){
            $this->authorize('employee_update');
        }elseif (request('role_id') == 3) {
            $this->authorize('agent_update');
        }elseif (request('role_id') == 5) {
            $this->authorize('client_update');
        }elseif (request('role_id') == 6) {
            $this->authorize('lawyer_update');
        }
        $user->update(['status' => $user->status ? false : true]);
        return back()->withSuccess('Status successfully updated');
    }

    public function loginToUser(User $user)
    {
        $this->authorize('login_to_user');
        Auth::login($user);
        return to_route('root')->withSuccess("You are now logged in as $user->name. You have the full access of this user.");
    }

    public function destroy(User $user)
    {
        if(request('role_id') == 1){
            $this->authorize('admin_delete');
        } elseif(request('role_id') == 2){
            $this->authorize('employee_delete');
        }elseif (request('role_id') == 3) {
            $this->authorize('agent_delete');
        }elseif (request('role_id') == 5) {
            $this->authorize('client_delete');
        }elseif (request('role_id') == 6) {
            $this->authorize('lawyer_delete');
        }
        $user->delete();
        return to_route('users.index', ['role_id' => request('role_id')])->withErrors('User has been successfully deleted.');
    }

    public function profileImgRemove(User $user)
    {
        if ($user->profile_img && Storage::disk('public')->exists($user->profile_img)) {
            Storage::disk('public')->delete([$user->profile_img]);
        }
        return to_route('users.show', [$user]);
    }
}
