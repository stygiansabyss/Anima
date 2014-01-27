{{ bForm::setType('basic')->ajaxForm('statusForm', 'Statuses updated')->open() }}
	<div class="panel panel-default">
		<div class="panel-heading">Statuses</div>
		<div class="panel-body">
			@foreach ($statuses as $status)
				{{ bForm::checkbox('status['. $status->id .']', 1, $character->status->status->where('keyName', $status->keyName)->count() > 0, array(), $status->name) }}
			@endforeach
			{{ bForm::jsonSubmit('Update statuses') }}
		</div>
		<div class="panel-footer">
			<div id="message"></div>
		</div>
	</div>
{{ bForm::close() }}