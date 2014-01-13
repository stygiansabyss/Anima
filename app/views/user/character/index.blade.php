<div class="row">
	<div class="col-md-12">
		<small>
			<ul class="breadcrumb">
				@if ($rolls->count() > 0)
					<li>
						<div class="btn-group">
							{{ HTML::link('/user/characters/create', 'Create Character', array('class' => 'btn btn-xs btn-primary')) }}
						</div>
					</li>
					<li class="pull-right">Your current stat rolls are: {{ implode(', ', $rolls->roll->toArray()) }}</li>
				@else
					<li>{{ HTML::link('/user/characters/roll', 'Generate Stat Rolls') }}</li>
				@endif
			</ul>
		</small>
	</div>
</div>
<div id="characters"></div>
<div id="enemies"></div>

<script>
	@section('onReadyJs')
		// Load the individual pages
		$('#characters').load('/user/characters/pagination-characters');
		$('#enemies').load('/user/characters/pagination-enemies');
	@stop
</script>