{{ bForm::ajaxForm('statsForm', 'Stats updated')->open() }}
	<div class="panel panel-default">
		<div class="panel-heading">Stats</div>
		<div class="panel-body">
			@foreach ($stats as $stat)
				{{ bForm::text('stats['. $stat->id .']', $character->getValue('Stat', $stat->id), array('placeholder' => $stat->name), $stat->name) }}
			@endforeach
			{{ bForm::jsonSubmit('Update stats') }}
		</div>
		<div class="panel-footer">
			<div id="message"></div>
		</div>
	</div>
{{ bForm::close() }}