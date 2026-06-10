<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InsuranceCompany;
use Illuminate\Support\Facades\Auth;

class InsuranceCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('inc_companies_access');
        $companies = InsuranceCompany::query()
            ->orderByDesc('created_at');

        if ($request->get('search')) {
            $companies->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('search') . '%');
            });
        }
        $companies = $companies->paginate(25)->withQueryString();
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('inc_companies_create');

        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('inc_companies_create');
        $authid = Auth::user()->id;
        $request->validate([
            'name' => 'required|unique:insurance_companies,name',
            'phone' => 'required',
            'email' => 'required',
        ]);
        $company = new InsuranceCompany();
        $company->name = $request->post('name');
        $company->phone = $request->post('phone');
        $company->fax = $request->post('fax');
        $company->link = $request->post('link');
        $company->user_id = $authid;
        $company->email = $request->post('email');

        $company->save();
        return to_route('insurance-companies.index')->withSuccess(__('SUCCESS !! New Insurance Comapny has been successfully created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(InsuranceCompany $insuranceCompany)
    {
        $this->authorize('inc_companies_show');
        return view('company.show', compact('insuranceCompany'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InsuranceCompany $insuranceCompany)
    {
        $this->authorize('inc_companies_update');
        return view('company.edit', compact('insuranceCompany'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InsuranceCompany $insuranceCompany)
    {
        $this->authorize('inc_companies_update');
        $request->validate([
            'name' => 'required|unique:insurance_companies,name,' . $insuranceCompany->id,
            'phone' => 'required',
            'email' => 'required',      
        ]);

        $authid = Auth::user()->id;
       
        $insuranceCompany->name = $request->post('name');
        $insuranceCompany->phone = $request->post('phone');
        $insuranceCompany->fax = $request->post('fax');
        $insuranceCompany->link = $request->post('link');
        $insuranceCompany->user_id = $authid;
        $insuranceCompany->email = $request->post('email');

        $insuranceCompany->save();

        return to_route('insurance-companies.index')->withSuccess(__('SUCCESS !! Insurance Company has been successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InsuranceCompany $insuranceCompany)
    {
        $this->authorize('inc_companies_delete');
        $insuranceCompany->delete();

        return to_route('insurance-companies.index')->withSuccess(__('SUCCESS !! Insurance company has been successfully deleted'));
    }
}
