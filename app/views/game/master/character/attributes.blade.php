{{ bForm::ajaxForm('attributesForm', 'Attributes updated')->open() }}
	<div class="panel panel-default">
		<div class="panel-heading">Attributes</div>
		<div class="panel-body">
			@if ($character->user->rolls->count() > 0)
				<div class="row">
					<div class="col-md-offset-2 col-md-10">
						<ul class="list-inline">
							<li class="text-primary">This users current rolls are:</li>
							@foreach ($character->user->rolls->roll as $roll)
								<li>{{ $roll }}</li>
							@endforeach
						</ul>
					</div>
				</div>
			@endif
			@foreach ($attributes as $attribute)
				{{ bForm::text('attributes['. $attribute->id .']', $character->getValue('Attribute', $attribute->id), array('placeholder' => $attribute->name), $attribute->name) }}
			@endforeach
			{{ bForm::jsonSubmit('Update attributes') }}
		</div>
		<div class="panel-footer">
			<div id="message"></div>
		</div>
	</div>
{{ bForm::close() }}