	<h3 class="text-primary">Basics</h3>
	{{ bForm::text('name', Input::old('name'), array('id' => 'name', 'placeholder' => 'Name', 'required' => 'required'), 'Name') }}
	{{ bForm::color('color', (Input::old('color') != null ? Input::old('color') : '#ffffff'), array(), 'Chat Color') }}
	{{ bForm::select('magic_type_id', $magicTypeArray, Input::old('magic_type_id'), array('id' => 'magic_type_id', 'placeholder' => 'Magic Type'), 'Magic Type') }}
	{{ bForm::text('level', (!is_null(Input::old('level')) ? Input::old('level') : 3), array('id' => 'level', 'placeholder' => 'Level'), 'Level') }}
	{{ bForm::text('experience', Input::old('experience'), array('id' => 'experience', 'placeholder' => 'Experience'), 'Experience') }}
	{{ bForm::text('hitPoints', Input::old('hitPoints'), array('id' => 'hitPoints', 'placeholder' => 'LP', 'required' => 'required'), 'LP') }}
	{{ bForm::text('magicPoints', Input::old('magicPoints'), array('id' => 'magicPoints', 'placeholder' => 'Zeon/Ki'), 'Zeon/Ki') }}
	{{ bForm::image('avatar', null, 'Avatar') }}

@section('js')
	@parent
	<script>
		$('#MyWizard').on('finished', function(e, data) {
			$('#submitForm').submit();
		});
	</script>
@stop