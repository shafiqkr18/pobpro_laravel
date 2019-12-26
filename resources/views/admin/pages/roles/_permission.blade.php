
<div class="{{ count($permission->children) > 0 ? 'role-group' : '' }} {{ $permission->parent_id == 0 ? 'root border-bottom' : '' }}">


	<div class="permission-row">
		
		<div class="name">
			@if ($permission->parent_id == 0)
			<h5 class="m-0 font-weight-bold">
			@endif
			<div class="i-checks">
				<input name="check_sub" type="checkbox" id="check_sub_{{ $permission->id }}" 
						class="{{ count($permission->children) > 0 ? 'has-children ' : '' }}" 
						data-id="{{ $permission->id }}" 
						data-parent="{{ $permission->parent_id }}" 
						{{ ($role_permissions && in_array($permission->id, $role_permissions)) ? 'checked' : ''}}>
				<label for="check_sub_{{ $permission->id }}" class="{{ count($permission->children) == 0 && $permission->parent_id > 0 ? 'ml-4' : 'font-weight-bold' }}">{{ $permission->display_name }}</label>
			</div>
			@if ($permission->parent_id == 0)
			</h5>
			@endif
		</div>

		<div class="function">
			{{--@if (count($permission->children) == 0)--}}
			<div class="i-checks {{ count($permission->children) > 0 ? 'hidden' : '' }}">
				<input name="permission[]" type="checkbox" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" {{ $role_permissions && in_array($permission->id, $role_permissions) ? 'checked' : ''}}>
				<label for="permission_{{ $permission->id }}" class=""></label>
			</div>
			{{--@endif--}}
		</div>

		<div class="function">
			{{--@if (count($permission->children) == 0)--}}
			<div class="i-checks {{ count($permission->children) > 0 ? 'hidden' : '' }}">
				<input name="permission_create[]" type="checkbox" value="{{ $permission->id }}" id="permission_create_{{ $permission->id }}">
				<label for="permission_create_{{ $permission->id }}" class=""></label>
			</div>
			{{--@endif--}}
		</div>
		
		<div class="function">
			{{--@if (count($permission->children) == 0)--}}
			<div class="i-checks {{ count($permission->children) > 0 ? 'hidden' : '' }}">
				<input name="permission_update[]" type="checkbox" value="{{ $permission->id }}" id="permission_update_{{ $permission->id }}">
				<label for="permission_update_{{ $permission->id }}" class=""></label>
			</div>
			{{--@endif--}}
		</div>
		
		<div class="function">
			{{--@if (count($permission->children) == 0)--}}
			<div class="i-checks {{ count($permission->children) > 0 ? 'hidden' : '' }}">
				<input name="permission_delete[]" type="checkbox" value="{{ $permission->id }}" id="permission_delete_{{ $permission->id }}">
				<label for="permission_delete_{{ $permission->id }}" class=""></label>
			</div>
			{{--@endif--}}
		</div>

	</div>
		
	@if (count($permission->children) > 0)
		@foreach($permission->children as $permission)
		@include('admin/pages/roles/_permission', ['permission' => $permission, 'role_permissions' => $role_permissions ? $role_permissions : null])
		@endforeach
	@endif


</div>


