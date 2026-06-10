<x-admin.layout>
	<x-admin.breadcrumb 
			title='Change Password'
			:links="[
				['text' => 'Dashboard', 'url' => route('dashboard')],
				['text' => 'Users']
			]"
			:actions="[
				['text' => 'Dashboard', 'url' => route('dashboard') ]
			]"
		/>
	
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<form action="{{ route('password.update') }}" method="POST" class="card shadow-sm">
				@csrf
				<div class="card-body">
					<div class="form-group">
					    <label for="">Old Password <span class="text-danger">*</span></label>
					    <input type="password" name="old_password" required class="form-control">
					</div>
					<div class="form-group">
					    <label for="">New Password <span class="text-danger">*</span></label>
					    <input type="password" name="new_password" required class="form-control">
					</div>
					<div class="form-group">
					    <label for="">Confirm Password <span class="text-danger">*</span></label>
					    <input type="password" name="new_password_confirmation" required class="form-control">
					</div>
				</div>
				<div class="card-body">
					<button type="submit" class="btn btn-success">
						<i class="fas fa-save"></i> Submit
					</button>
				</div>
			</form>
		</div>
		<div class="col-md-3"></div>
	</div>
</x-admin.layout>
