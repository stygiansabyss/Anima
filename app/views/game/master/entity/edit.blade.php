<div class="row">
	<div class="col-md-offset-3 col-md-6">
		{{ bForm::open() }}
			<div class="panel panel-default">
				<div class="panel-heading">Update {{ $entity->name }}</div>
				<div class="panel-body">
					{{ bForm::text('name', $entity->name, array('id' => 'name', 'placeholder' => 'Name'), 'Name') }}
					{{ bForm::color('color', $entity->color, array(), 'Chat Color') }}
					{{ bForm::textarea('description', $entity->description, array('placeholder' => 'Description'), 'Description') }}
					{{ bForm::checkbox('hiddenFlag', 1, $entity->hiddenFlag, array(), 'Hidden') }}
					{{ bForm::checkbox('activeFlag', 1, $entity->activeFlag, array(), 'Active') }}
					{{ bForm::image('avatar', $entity->avatar, 'Avatar') }}
					{{ bForm::submit('Update Entity') }}
				</div>
			</div>
		{{ bForm::close() }}
	</div>
</div>