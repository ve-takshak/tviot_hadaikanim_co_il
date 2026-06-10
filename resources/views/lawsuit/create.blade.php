<x-admin.layout>
    <x-admin.breadcrumb title="{{ __('Create Insurance Claim') }}" :links="[
        ['text' => __('Dashboard'), 'url' => route('dashboard')],
        ['text' => __('Insurance Claims'), 'url' => route('insurance-claims.index')],
        ['text' => __('Create New')],
    ]" :actions="[
        [
            'text' => __('All Insurance Claims'),
            'icon' => 'fas fa-list',
            'url' => route('insurance-claims.index'),
            'permission' => 'insurance_claim_access',
            'class' => 'btn-danger ',
        ],
    ]" />

    <form method="POST" action="{{ route('insurance-claims.store') }}" class="card shadow-sm" enctype="multipart/form-data">
        @csrf
        <div class="card-body table-responsive">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Claim Number') }}<span class="text-danger">*</span></label>
                        <input type="number" value="{{old('lawsuit_no')}}" name="lawsuit_no" class="form-control"  >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Invoice Number') }}</label>
                        <input type="number" value="{{old('invoice_no')}}" name="invoice_no" class="form-control" >
                    </div>
                </div>
                {{--  --}}
                <h4>{{ __('Customer Details:') }}</h4>
                <hr>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="">{{ __('Name Insured') }} <span class="text-danger">*</span></label>
                        <input name="name" value="{{old('name')}}" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Cell Phone Number') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{old('mobile')}}" name="mobile" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('TZ') }}</label>
                        <input type="text" value="{{old('tz')}}" name="tz" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Email') }}</label>
                        <input type="email" value="{{old('email')}}" name="email" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('License Number') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{old('dl_number')}}" name="dl_number" class="form-control">
                    </div>
                </div>
                {{--  --}}
                <h4>{{ __('Vehicle Details:') }}</h4>
                <hr>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="">{{ __('Vehicle Number') }} </label>
                        <input type="text" value="{{old('license_plate')}}" name="license_plate" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Manufacturer') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{old('manufacturer')}}" name="manufacturer" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Year') }} </label>
                        <input type="number" value="{{old('year')}}" name="year" class="form-control">
                    </div>
                </div>
                {{--  --}}
                <h4>{{ __('Additional Details:') }}</h4>
                <hr>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="">{{ __('Third Party Vehicle Number') }} </label>
                        <input type="text" value="{{old('third_party_plate')}}" name="third_party_plate" class="form-control">
                    </div>
                </div>
                {{--  --}}
                
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inc_company_id">{{ __('Insurance Company Name') }}<span class="text-danger">*</span></label>
                        <select id="inc_company_id" name="inc_company_id" class="form-control select2">
                            <option value="">-- {{ __('Select') }} --</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
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
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="appraiser">{{ __("Appraiser's Name") }}</label>
                        <select id="appraiser" name="appraiser" class="form-control select2" >
                            <option value="">-- {{ __('Select') }} --</option>
                            @foreach ($appraisers as $appraiser)
                                <option value="{{ $appraiser->id }}">{{ $appraiser->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{--  --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Date Of Accident') }} <span class="text-danger">*</span></label>
                        <input type="date" value="{{old('lawsuit_begin_date')}}" name="lawsuit_begin_date" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Payment date') }} <span class="text-danger">*</span></label>
                        <input type="date" value="{{old('payment_date')}}" name="payment_date" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Check Total') }}</label>
                        <input type="text" value="{{old('check_total')}}" name="check_total" class="form-control" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('Deductible') }}</label>
                        <input type="text" value="{{old('deductible')}}" name="deductible" class="form-control" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">{{ __('VAT') }}</label>
                        <input type="text" value="{{old('vat')}}" name="vat" class="form-control" >
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