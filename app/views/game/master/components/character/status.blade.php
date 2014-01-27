<div class="row">
	<div class="col-md-offset-3 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">Update status for {{ $character->name }}</div>
			<div class="panel-body">
				{{ bForm::open() }}
					{{ bForm::select('status[]', $statuses, $characterStatuses, array('multiple', 'style' => 'height: 250px;'), 'Statuses') }}
					{{ bForm::submit() }}
				{{ bForm::close() }}
			</div>
		</div>
	</div>
</div>