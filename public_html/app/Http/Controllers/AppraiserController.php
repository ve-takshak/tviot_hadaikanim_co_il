<?php

namespace App\Http\Controllers;

use App\Models\Appraiser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppraiserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('appraiser_access');
        $appraisers = Appraiser::query()
            ->orderByDesc('created_at');

        if ($request->get('search')) {
            $appraisers->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('search') . '%');
            });
        }
        $appraisers = $appraisers->paginate(25)->withQueryString();
        return view('appraiser.index', compact('appraisers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('appraiser_create');

        return view('appraiser.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('appraiser_create');
        $authid = Auth::user()->id;
        $request->validate([
            'name' => 'required|unique:appraisers,name',
            'phone' => 'required',
            'email' => 'required',
        ]);
        $company = new Appraiser();
        $company->name = $request->post('name');
        $company->phone = $request->post('phone');
        $company->fax = $request->post('fax');
        $company->link = $request->post('link');
        $company->user_id = $authid;
        $company->email = $request->post('email');

        $company->save();
        return to_route('appraiser.index')->withSuccess(__('SUCCESS !! New Appraiser has been successfully created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Appraiser $appraiser)
    {
        $this->authorize('appraiser_show');
        return view('appraiser.show', compact('appraiser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appraiser $appraiser)
    {
        $this->authorize('appraiser_update');
        return view('appraiser.edit', compact('appraiser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appraiser $appraiser)
    {
        $this->authorize('appraiser_update');
        $request->validate([
            'name' => 'required|unique:appraisers,name,' . $appraiser->id,
            'phone' => 'required',
            'email' => 'required',
        ]);

        $authid = Auth::user()->id;

        $appraiser->name = $request->post('name');
        $appraiser->phone = $request->post('phone');
        $appraiser->fax = $request->post('fax');
        $appraiser->link = $request->post('link');
        $appraiser->user_id = $authid;
        $appraiser->email = $request->post('email');

        $appraiser->save();

        return to_route('appraiser.index')->withSuccess(__('SUCCESS !! Appraiser has been successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appraiser $appraiser)
    {
        $this->authorize('appraiser_delete');
        $appraiser->delete();

        return to_route('appraiser.index')->withSuccess(__('SUCCESS !! Appraiser has been successfully deleted'));
    }
}
