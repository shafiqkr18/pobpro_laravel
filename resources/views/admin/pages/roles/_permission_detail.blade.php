
<div class="{{ count($permission->children) > 0 ? 'role-group' : '' }} {{ $permission->parent_id == 0 ? 'root border-bottom' : '' }}">


	<div class="permission-row">
		
		<div class="name">
			@if ($permission->parent_id == 0)
			<h5 class="m-0 font-weight-bold">
			@endif
			<div class="i-checks">
				<!-- <input name="check_sub" type="checkbox" id="check_sub_{{ $permission->id }}" 
						class="{{ count($permission->children) > 0 ? 'has-children ' : '' }}" 
						data-id="{{ $permission->id }}" 
						data-parent="{{ $permission->parent_id }}"> -->
				<label for="check_sub_{{ $permission->id }}" class="{{ count($permission->children) == 0 && $permission->parent_id > 0 ? 'ml-4' : 'font-weight-bold' }}">
					<i class="fa fa-{{ in_array($permission->id, $role_permissions) ? 'check' : 'times' }} text-{{ in_array($permission->id, $role_permissions) ? 'navy' : 'muted' }} mr-1"></i>
					{{ $permission->display_name }}
				</label>
			</div>
			@if ($permission->parent_id == 0)
			</h5>
			@endif
		</div>

		<div class="function">
			<div class="i-checks">
				<i class="fa fa-{{ in_array($permission->id, $role_permissions) ? 'check' : 'times' }} text-{{ in_array($permission->id, $role_permissions) ? 'navy' : 'muted' }}"></i>
			</div>
		</div>

		<div class="function">
			<div class="i-checks">
				
			</div>
		</div>
		
		<div class="function">
			<div class="i-checks">
				
			</div>
		</div>
		
		<div class="function">
			<div class="i-checks">
				
			</div>
		</div>

	</div>
		
	@if (count($permission->children) > 0)
		@foreach($permission->children as $permission)
		@include('admin/pages/roles/_permission_detail', ['permission' => $permission, 'role_permissions' => $role_permissions ? $role_permissions : []])
		@endforeach
	@endif


</div>




