<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\User;
use App\Models\Comment;
use App\Models\Lawsuit;
use App\Models\document;
use App\Models\Appraiser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\ClaimsExport;
use Illuminate\Validation\Rule;
use App\Models\InsuranceCompany;
use App\Services\LawsuitService;
use Illuminate\Support\Facades\DB;
use Takshak\Imager\Facades\Imager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class LawsuitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $lawsuitService;

    public function __construct(LawsuitService $lawsuitService)
    {
        $this->lawsuitService = $lawsuitService;
    }
    public function index(Request $request)
    {
        $this->authorize('insurance_claim_access');
        
       $lawsuits = $this->lawsuitService->getFilteredLawsuits($request);

        return view('lawsuit.index', compact('lawsuits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('insurance_claim_create');
        $companies = InsuranceCompany::orderBy('name')->orderByDesc('name')->get();
        $agents = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['agent']);
        })->orderByDesc('name')->get();
        $appraisers = Appraiser::orderByDesc('name')->get();
        return view('lawsuit.create', compact('companies', 'agents', 'appraisers'));
    }


    public function store(Request $request)
    {
        $this->authorize('insurance_claim_create');

        $user_id = Auth::user()->id;

        $validatedData = $request->validate([
            'lawsuit_no' => 'nullable|unique:lawsuits,lawsuit_no',
            'name' => 'nullable',
            'email' => 'nullable|email|unique:users,email',
            'dl_number' => 'nullable',
            'license_plate' => 'nullable',
            'mobile' => 'nullable',
            'manufacturer' => 'nullable',
            'year' => 'nullable|integer',
            'third_party_plate' => 'nullable',
            'inc_company_id' => 'nullable|exists:insurance_companies,id',
            'agent_id' => 'nullable|exists:users,id',
            'appraiser' => 'nullable|exists:appraisers,id',
            'lawsuit_begin_date' => 'nullable|date',
            'payment_date' => 'nullable|date',
            'check_total' => 'nullable|integer',
            'deductible' => 'nullable|integer',
            'vat' => 'nullable|integer',
            'invoice_no' => 'nullable'
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->dl_number = $validatedData['dl_number'];
        $user->mobile = $validatedData['mobile'];
        $user->tz = $request->tz;
        $user->password = Hash::make(Str::random(10));
        $user->save();
        $user->roles()->sync([5]);
if($validatedData['license_plate']){
        $vehicle = new Car();
        $vehicle->license_plate = $validatedData['license_plate'];
        $vehicle->user_id = $user->id;
        $vehicle->manufacturer = $validatedData['manufacturer'];
        $vehicle->year = $validatedData['year'];
        $vehicle->save();
}
        $lawsuit = new Lawsuit();
        $lawsuit->lawsuit_no = $validatedData['lawsuit_no'];
        $lawsuit->client_id = $user->id;
        $lawsuit->user_id = $user_id;
        $lawsuit->third_party_plate = $validatedData['third_party_plate'];
        $lawsuit->car_id = isset($vehicle) ? $vehicle->id : null;
        $lawsuit->inc_company_id = $validatedData['inc_company_id'];
        $lawsuit->agent_id = $validatedData['agent_id'];
        $lawsuit->appraiser = $validatedData['appraiser'];
        $lawsuit->lawsuit_begin_date = $validatedData['lawsuit_begin_date'];
        $lawsuit->payment_date = $validatedData['payment_date'];
        $lawsuit->check_total = $validatedData['check_total'];
        $lawsuit->deductible = $validatedData['deductible'];
        $lawsuit->vat = $validatedData['vat'];
        $lawsuit->invoice_no = $validatedData['invoice_no'];

        $lawsuit->save();
        return redirect()->route('insurance-claims.index')->with('success', __('Insurance claim created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Lawsuit $insurance_claim)
    {
        $this->authorize('insurance_claim_show');

        $lawsuit = $insurance_claim->load(
            'client',
            'car',
            'agent',
            'appraiser_data',
            'inc_company',
            'comments',
            'documents'
        );
        return view('lawsuit.show', compact('lawsuit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lawsuit $insurance_claim)
    {
        $this->authorize('insurance_claim_update');
        $lawsuit = $insurance_claim->load('client', 'car', );
        $companies = InsuranceCompany::orderBy('name')->orderByDesc('name')->get();
        $agents = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['agent']);
        })->orderByDesc('name')->get();
        $appraisers = Appraiser::orderByDesc('name')->get();
        $lawsuit->payment_date_formatted = Carbon::parse($lawsuit->payment_date)->format('Y-m-d');
        $lawsuit->lawsuit_begin_date_formatted = Carbon::parse($lawsuit->lawsuit_begin_date)->format('Y-m-d');
        return view('lawsuit.edit', compact('companies', 'agents', 'appraisers', 'lawsuit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lawsuit $insurance_claim)
    {
        $this->authorize('insurance_claim_update');

        $user_id = Auth::user()->id;

        $validatedData = $request->validate([
            'lawsuit_no' => [
                'nullable',
                Rule::unique('lawsuits')->ignore($insurance_claim->id),
            ],
            'name' => 'nullable',
            'email' => 'nullable|email|unique:users,email,' . $insurance_claim->client_id,
            'dl_number' => 'nullable',
            'license_plate' => 'nullable',
            'mobile' => 'nullable',
            'manufacturer' => 'nullable',
            'year' => 'nullable|integer',
            'third_party_plate' => 'nullable',
            'inc_company_id' => 'nullable|exists:insurance_companies,id',
            'agent_id' => 'nullable|exists:users,id',
            'appraiser' => 'nullable|exists:appraisers,id',
            'lawsuit_begin_date' => 'nullable|date',
            'payment_date' => 'nullable|date',
            'check_total' => 'nullable|integer',
            'deductible' => 'nullable|integer',
            'vat' => 'nullable|integer',
            'invoice_no' => 'nullable'

        ]);

        $user = User::find($insurance_claim->client_id);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->dl_number = $validatedData['dl_number'];
        $user->mobile = $validatedData['mobile'];
        $user->tz = $request->tz;
        $user->save();
if($insurance_claim->car_id){
        $vehicle = Car::find($insurance_claim->car_id);
        $vehicle->license_plate = $validatedData['license_plate'];
        $vehicle->user_id = $user->id;
        $vehicle->manufacturer = $validatedData['manufacturer'];
        $vehicle->year = $validatedData['year'];
        $vehicle->save();
}
        $insurance_claim->lawsuit_no = $validatedData['lawsuit_no'];
        $insurance_claim->client_id = $user->id;
        $insurance_claim->user_id = $user_id;
        $insurance_claim->third_party_plate = $validatedData['third_party_plate'];
        $insurance_claim->car_id = isset($vehicle) ? $vehicle->id : null;
        $insurance_claim->inc_company_id = $validatedData['inc_company_id'];
        $insurance_claim->agent_id = $validatedData['agent_id'];
        $insurance_claim->appraiser = $validatedData['appraiser'];
        $insurance_claim->lawsuit_begin_date = $validatedData['lawsuit_begin_date'];
        $insurance_claim->payment_date = $validatedData['payment_date'];
        $insurance_claim->check_total = $validatedData['check_total'];
        $insurance_claim->deductible = $validatedData['deductible'];
        $insurance_claim->vat = $validatedData['vat'];
        $insurance_claim->invoice_no = $validatedData['invoice_no'];

        $insurance_claim->save();
        return redirect()->route('insurance-claims.index')->with('success', __('Insurance claim updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */

    public function addComment(Request $request)
    {
        $comment = new Comment();
        $comment->lawsuit_id = $request->lawsuit_id;
        $comment->user_id = Auth::user()->id;
        $comment->message = $request->comment;
        $comment->save();
        return redirect()->route('insurance-claims.show', [$request->lawsuit_id])->with('success', __('Comment created successfully!'));

    }
    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', __('Comment deleted successfully!'));
    }

    public function deleteDocument(document $document)
    {
        $this->authorize('insurance_claim_document_delete');
        Storage::delete('public/' . $document->file_name);
        $document->delete();
        return back()->with('success', __('Document deleted successfully!'));

    }

    public function addDocument(Request $request)
    {
        if ($request->hasFile('doc')) {

            foreach ($request->file('doc') as $file) {
                $document = new Document();
                $uuid = (string) Str::uuid();
                $originalName = $file->getClientOriginalName();
                // Try getting extension safely
                $extension = $file->extension();
                if (!$extension) {
                    // Fallback to pathinfo
                    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                }
    
                if (!$extension) {
                    // Still no extension? Use default or abort.
                    return back()->withErrors(['doc' => 'Invalid file: could not determine file extension.']);
                }
    
                $fileName = 'document/' . $uuid . '.' . $extension;
                $document->file_name = $fileName;
        
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                    Imager::init($file)
                        // ->resizeFit(900, 500)
                        // ->inCanvas('#fff')
                        ->save(\Storage::disk('public')->path($document->file_name));
                } else {
                    $file->storeAs('public', $fileName);
                }
        
                $document->lawsuit_id = $request->lawsuit_id;
                $document->extension = $extension;
                $document->real_name = $originalName;
                $document->save();
            }
        
            return back()->with('success', __('Documents uploaded successfully!'));
        }
    }
    public function changeStatus(Lawsuit $insurance_claim, Request $request)
    {
        $insurance_claim->status = $request->status;
        $insurance_claim->save();
        return redirect()->route('insurance-claims.show', [$insurance_claim->id])->with('success', __('Status changed successfully!'));

    }
    public function destroy(Lawsuit $insurance_claim)
    {
        $this->authorize('insurance_claim_delete');

        $insurance_claim->delete();
        return redirect()->route('insurance-claims.index')->with('success', __('Insurance Claim deleted successfully!'));
    }

    public function calendarIndex(Request $request)
    {
        $this->authorize('insurance_claim_access');
        $insuranceClaims = Lawsuit::select('id','check_total','lawsuit_no', 'payment_date')->get()->map(function ($claim) {
            $claim->payment_date = Carbon::parse($claim->getRawOriginal('payment_date'))->format('Y-m-d');
            return $claim;
        });
    
        return view('calendar', compact('insuranceClaims'));
    }
    public function exportClaims(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        return Excel::download(new ClaimsExport($fromDate,$toDate), 'claims.xlsx');
    }
}
