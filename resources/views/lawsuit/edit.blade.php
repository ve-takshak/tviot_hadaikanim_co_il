<x-admin.layout>
	<x-admin.breadcrumb
			title="{{ __('Edit Insurance Claims') }}"
			:links="[
				['text' =>  __('Dashboard'), 'url' => route('dashboard') ],
                ['text' =>  __('Insurance Claims'), 'url' => route('insurance-claims.index')],
                ['text' =>__('Edit')]
			]"
            :actions="[
                 ['text' => __('Show Claim'), 'icon' => 'fas fa-eye', 'url' => route('insurance-claims.show',[$lawsuit]), 'permission' => 'insurance_claim_access', 'class' => 'btn-primary'],
                ['text' => __('Create Insurance Claims'), 'icon' => 'fas fa-plus', 'url' => route('insurance-claims.create'), 'permission' => 'insurance_claim_create', 'class' => 'btn-success '],
                ['text' => __('All Insurance Claims'), 'icon' => 'fas fa-list', 'url' => route('insurance-claims.index'), 'permission' => 'insurance_claim_access', 'class' => 'btn-danger'],
               
            ]"
		/>

    <form method="POST" action="{{ route('insurance-claims.update', [$lawsuit]) }}" class="card shadow-sm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body table-responsive">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Claim Number') }}</label>
                        <input type="number" value="{{$lawsuit->lawsuit_no}}" name="lawsuit_no" class="form-control" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Invoice Number') }}</label>
                        <input type="number" value="{{$lawsuit->invoice_no}}" name="invoice_no" class="form-control"  >
                    </div>
                </div>
                {{--  --}}
                <h4>{{ __('Customer Details:') }}</h4>
                <hr>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="">{{ __('Name Insured') }}</label>
                        <input name="name" value="{{$lawsuit->client->name}}" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Cell Phone Number') }}</label>
                        <input type="text" value="{{$lawsuit->client->mobile}}" name="mobile" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('TZ') }}</label>
                        <input type="text" value="{{$lawsuit->client->tz}}" name="tz" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Email') }}</label>
                        <input type="email" value="{{$lawsuit->client->email}}" name="email" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('License Number') }}</label>
                        <input type="text" value="{{$lawsuit->client->dl_number}}" name="dl_number" class="form-control">
                    </div>
                </div>
                {{--  --}}
                <h4>{{ __('Vehicle Details:') }}</h4>
                <hr>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="">{{ __('Vehicle Number') }}</label>
                        <input type="text" value="{{$lawsuit->car->license_plate ?? ''}}" name="license_plate" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Manufacturer') }}</label>
                        <input type="text" value="{{$lawsuit->car->manufacturer ?? ''}}" name="manufacturer" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Year') }}</label>
                        <input type="number" value="{{$lawsuit->car->year ?? ''}}" name="year" class="form-control">
                    </div>
                </div>
                {{--  --}}
                <h4>{{ __('Additional Details:') }}</h4>
                <hr>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="">{{ __('Third Party Vehicle Number') }}</label>
                        <input type="text" value="{{$lawsuit->third_party_plate}}"name="third_party_plate" class="form-control" >
                    </div>
                </div>
                {{--  --}}
                
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inc_company_id">{{ __('Insurance Company Name') }}</label>
                        <select id="inc_company_id" name="inc_company_id" class="form-control select2">
                            <option value="">-- {{ __('Select') }} --</option>
                            @foreach ($companies as $company)
                                <option @if($lawsuit->inc_company_id == $company->id) {{"selected"}} @endif value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="agent_id">{{ __('Agent Name') }} </label>
                        <select id="agent_id" name="agent_id" class="form-control select2" >
                            <option value="">-- {{ __('Select') }} --</option>
                            @foreach ($agents as $agent)
                                <option  @if($lawsuit->agent_id == $agent->id) {{"selected"}} @endif value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="appraiser">{{ __("Appraiser's Name") }}</label>
                        <select id="appraiser" name="appraiser" class="form-control select2" >
                            <option value="">--{{ __('Select') }}  --</option>
                            @foreach ($appraisers as $appraiser)
                                <option @if($lawsuit->appraiser  == $appraiser->id) {{"selected"}} @endif  value="{{ $appraiser->id }}">{{ $appraiser->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{--  --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Date Of Accident') }}</label>
                        <input type="date" value="{{$lawsuit->lawsuit_begin_date_formatted}}" name="lawsuit_begin_date" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Payment date') }}</label>
                        <input type="date" value="{{$lawsuit->payment_date_formatted}}" name="payment_date" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Check Total') }} </label>
                        <input type="text" value="{{$lawsuit->check_total}}" name="check_total" class="form-control" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Deductible') }}</label>
                        <input type="text" value="{{$lawsuit->deductible}}" name="deductible" class="form-control" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('VAT') }}</label>
                        <input type="text" value="{{$lawsuit->vat}}" name="vat" class="form-control" >
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i>{{ __('Submit') }} 
            </button>
        </div>
    </form>

</x-admin.layout>
