<x-admin.layout>
    <x-admin.breadcrumb title="{{ __('Insurance claims Show') }}" :links="[
        ['text' => __('Dashboard'), 'url' => route('dashboard')],
        ['text' => __('Insurance Claims'), 'url' => route('insurance-claims.index')],
        ['text' => __('Show')],
    ]" :actions="[
        [
            'text' => __('Create Insurance Claims'),
            'icon' => 'fas fa-plus',
            'url' => route('insurance-claims.create'),
            'permission' => 'insurance_claim_create',
            'class' => 'btn-success ',
        ],
        [
            'text' => __('All Insurance Claims'),
            'icon' => 'fas fa-list',
            'url' => route('insurance-claims.index'),
            'permission' => 'insurance_claim_access',
            'class' => 'btn-danger',
        ],
    ]" />

<div class="card mb-4 shadow-sm">
    <h1 class="text-center text-warning lh-lg">{{ __('Claim No.') }} {{$lawsuit->lawsuit_no}}</h1>
    <div class="row p-3">
        <!-- Client Details -->
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 bg-light p-3">
                <h4 class="fw-bold text-warning">{{ __('Client Details') }}</h4>
                <p><strong>{{ __('Name') }}:</strong> {{ $lawsuit->client->name }}</p>
                <p><strong>{{ __('TZ') }}:</strong> {{ $lawsuit->client->tz }}</p>
                <p><strong>{{ __("Driver's License Number") }}:</strong> {{ $lawsuit->client->dl_number }}</p>
                <p><strong>{{ __('Email') }}:</strong> {{ $lawsuit->client->email }}</p>
                <p><strong>{{ __('Cell Phone Number') }}:</strong> {{ $lawsuit->client->mobile }}</p>
            </div>
        </div>

        <!-- Vehicle Details -->
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 bg-light p-3">
                <h4 class="fw-bold text-warning">{{ __('Vehicle Details') }}</h4>
                <p><strong>{{ __('Vehicle Number') }}:</strong> @isset($lawsuit->car) {{ $lawsuit->car->license_plate }} @endisset</p>
                <p><strong>{{ __('Manufacturer') }}:</strong> @isset($lawsuit->car) {{ $lawsuit->car->manufacturer }} @endisset</p>
                <p><strong>{{ __('Year') }}:</strong> @isset($lawsuit->car) {{ $lawsuit->car->year }} @endisset</p>
            </div>
        </div>

        <!-- Claim Details -->
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 bg-light p-3">
                <h4 class="fw-bold text-warning">{{ __('Claim Details') }}</h4>
                <p><strong>{{ __('Date Of Accident') }}:</strong> {{ $lawsuit->lawsuit_begin_date }}</p>
                <p><strong>{{ __('Third Party Vehicle Number') }}:</strong> {{ $lawsuit->third_party_plate }}</p>
                <p><strong>{{ __('Insurance Company') }}:</strong> @isset($lawsuit->inc_company) {{ $lawsuit->inc_company->name }} @endisset</p>
                <p><strong>{{ __('Handling Agent') }}:</strong> @isset($lawsuit->agent) {{ $lawsuit->agent->name }} @endisset</p>
                <p><strong>{{ __('Appraiser') }}:</strong> @isset($lawsuit->appraiser_data) {{ $lawsuit->appraiser_data->name }} @endisset</p>
                <p><strong>{{ __('Check Payment Date') }}:</strong> {{ $lawsuit->payment_date }}</p>
                <p><strong>{{ __('Check Total') }}:</strong> {{ $lawsuit->check_total }}</p>
                <p><strong>{{ __('Deductible') }}:</strong> {{ $lawsuit->deductible }}</p>
                <p><strong>{{ __('VAT') }}:</strong> {{ $lawsuit->vat }}</p>
                <p><strong>{{ __('Status') }}:</strong> {{ __($lawsuit->status_text) }}</p>
                <p><strong>{{ __('Invoice Number') }}:</strong> {{ __($lawsuit->invoice_no) }}</p>
            </div>
        </div>
    </div>

    <!-- Documents and Comments Sections -->
    <div class="row p-3">
        <!-- Documents -->
        <div class="col-md-6 mb-3">
            <div class="card-body border-0 bg-light p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold text-warning">{{ __('Documents') }}</h4>
                    @can('insurance_claim_document_create')
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#document" class="btn btn-success">
                        <i class="fas fa-plus"></i>
                    </a>
                    @endcan
                </div>

                <!-- Drag & Drop Upload Zone -->
                @can('insurance_claim_document_create')
                <form id="dropzone-upload" method="POST" action="{{ route('document.add') }}" enctype="multipart/form-data" class="mb-3 border rounded p-3 bg-white text-center" style="min-height: 120px;" ondrop="handleDrop(event)" ondragover="event.preventDefault(); this.classList.add('bg-warning');" ondragleave="this.classList.remove('bg-warning');">
                    @csrf
                    <input type="hidden" name="lawsuit_id" value="{{ $lawsuit->id }}">
                    <input type="file" name="doc[]" id="dropzone-input" multiple style="display:none;" onchange="handleFileSelection(event)">
                    <div id="dropzone-label" style="cursor:pointer;">
                        <i class="fas fa-cloud-upload-alt fa-2x text-warning"></i>
                        <div>{{ __('Drag & drop documents here or click to select') }}</div>
                    </div>
                </form>
                <script>
                document.getElementById('dropzone-label').onclick = function() {
                    document.getElementById('dropzone-input').click();
                };

                function handleDrop(e) {
                    e.preventDefault();
                    document.getElementById('dropzone-upload').classList.remove('bg-warning');
                    let input = document.getElementById('dropzone-input');
                    input.files = e.dataTransfer.files;
                    handleFileSelection({target: input});
                }

                function handleFileSelection(event) {
                    let fileCount = document.getElementById('dropzone-input').files.length;
                    if (fileCount === 0) return;

                    let confirmMessage = fileCount === 1 
                        ? `{{ __('You dropped 1 document. Do you want to upload it?') }}`
                        : `{{ __('You dropped') }} ${fileCount} {{ __('documents. Do you want to upload them?') }}`;

                    if (confirm(confirmMessage)) {
                        document.getElementById('dropzone-upload').submit();
                    } else {
                        // Clear the input to allow re-selecting
                        document.getElementById('dropzone-input').value = '';
                    }
                }
                </script>
                @endcan

                <hr>
                <div class="row">
                    @foreach ($lawsuit->documents as $document)
                    <div class="col-sm-8 mb-3">
                        @if (in_array($document->extension, ['JPG','jpg', 'jpeg', 'png', 'webp']))
                        <a href="{{ $document->lawsuit_documents() }}" target="_blank">
                            <img src="{{ $document->lawsuit_documents() }}" alt="media" class="img-fluid">
                        </a>
                        @else
                        <a href="{{ $document->lawsuit_documents() }}" target="_blank">
                            <img src="{{ asset('assets/admin/images/document.svg') }}" class="img-fluid" width="50">
                            <br>{{ $document->real_name }}
                        </a>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        <small>{{ __('Added On') }}: {{ $document->created_at->format('d-m-Y') }}</small>
                        @can('insurance_claim_document_delete')
                        <form action="{{ route('document.delete', [$document]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger mt-2 delete-alert">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Comments -->
        <div class="col-md-6 mb-3">
            <div class="card-body border-0 bg-light p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold text-warning">{{ __('Comments') }}</h4>
                    @can('insurance_claim_comment_create')
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#comment" class="btn btn-success">
                        <i class="fas fa-plus"></i>
                    </a>
                    @endcan
                </div>
                <hr>
                @foreach ($lawsuit->comments as $comment)
                <div class="row mb-3">
                    <div class="col-sm-10">
                        <p>{{ $comment->message }}</p>
                        <small>{{ __('Added On') }}: {{ $comment->created_at->format('d-m-Y') }}</small>
                    </div>
                    <div class="col-sm-2">
                        @can('insurance_claim_comment_delete')
                        <form action="{{ route('comment.delete', [$comment]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger delete-alert">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="card-footer d-flex justify-content-between p-3">
        @can('insurance_claim_update')
        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#statusmodal" class="btn btn-primary">
            <i class="fas fa-tasks"></i> {{ __('Update Status') }}
        </a>
        <a href="{{ route('insurance-claims.edit', [$lawsuit]) }}" class="btn btn-success">
            <i class="fas fa-edit"></i> {{ __('Edit') }}
        </a>
        @endcan
        @can('insurance_claim_delete')
        <form action="{{ route('insurance-claims.destroy', [$lawsuit]) }}" method="POST" class="d-inline-block">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger delete-alert">
                <i class="fas fa-trash"></i> {{ __('Delete') }}
            </button>
        </form>
        @endcan
    </div>
</div>
    <!-- Modal -->
    <div class="modal fade" id="comment" tabindex="-1" aria-labelledby="commentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="commentLabel">{{ __('Add Comment') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('comment.add') }}" class="card shadow-sm mb-0">
                    <div class="modal-body">
                        @csrf
                        <input name="lawsuit_id" type="hidden" value="{{ $lawsuit->id }}">
                        <label for="">{{ __('Comment') }} <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="comment" required></textarea>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> {{ __('Submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusmodal" tabindex="-1" aria-labelledby="statusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="statusLabel">{{ __('Change Status') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('insurance-claims.status',[$lawsuit]) }}" class="card shadow-sm mb-0">
                    <div class="modal-body">
                        @csrf
                        <label for="">{{ __('Statuses') }} <span class="text-danger">*</span></label>
                       <select class="form-select" name="status" id="" >
                        <option {{$lawsuit->status == 1 ? 'selected' : ''}} value="1">{{ __('Active') }} </option>
                        <option {{$lawsuit->status == 2 ? 'selected' : ''}} value="2">{{ __('Repeated claims for settlement/policy') }}  </option>
                        <option {{$lawsuit->status == 3 ? 'selected' : ''}} value="3">{{ __('Under attorney management/handling') }} </option>
                        <option {{$lawsuit->status == 4 ? 'selected' : ''}} value="4">{{ __('Settlement / policy claims') }} </option>
                        <option {{$lawsuit->status == 0 ? 'selected' : ''}} value="0">{{ __('Archive') }} </option>
                       </select>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> {{ __('Submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="document" tabindex="-1" aria-labelledby="documentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="documentLabel">{{ __('Add Document') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('document.add') }}" class="card shadow-sm mb-0"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input name="lawsuit_id" type="hidden" value="{{ $lawsuit->id }}">
                        <label for="">{{ __('Document') }} <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" name="doc[]" multiple >

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> {{ __('Close') }} </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> {{ __('Submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.layout>
