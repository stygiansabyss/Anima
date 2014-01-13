	<div class="row">
		<div class="col-md-6">
			<h3 class="text-primary">Secondary Attributes</h3>
			@foreach ($secondaryAttributes as $attribute)
				{{ bForm::text('secondaryAttributes['. $attribute->id .']', Input::old('secondaryAttributes['. $attribute->id .']'), array('id' => 'attribute', 'placeholder' => $attribute->name), $attribute->name) }}
			@endforeach
		</div>
	</div>