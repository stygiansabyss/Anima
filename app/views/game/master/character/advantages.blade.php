{{ bForm::ajaxForm('advantagesForm', 'Advantages updated')->open() }}
	<div class="panel panel-default">
		<div class="panel-heading">Advantages</div>
		<div class="panel-body">
			@foreach ($advantages as $advantage)
				{{ bForm::text('advantages['. $advantage->id .']', $character->getValue('Trait', $advantage->id), array('placeholder' => $advantage->name), $advantage->name) }}
			@endforeach
			{{ bForm::jsonSubmit('Update advantages') }}
		</div>
		<div class="panel-footer">
			<div id="message"></div>
		</div>
	</div>
{{ bForm::close() }}