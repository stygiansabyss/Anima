<div class="row" id="ajaxContext_{{ $type }}_{{ time() }}">
	<div class="col-md-12">
		@foreach ($characters as $character)
			<div class="media well">
				<a class="pull-left" href="/character/sheet/{{ $character->id }}">
					{{ $character->avatar }}
				</a>
				<div class="media-body">
					<div class="row">
						<div class="col-md-3">
							@if ($type == 'enemy')
								<h4 class="media-heading">{{ HTML::link('/character/sheet/'. $character->id, $character->name, array('class' => 'text-error')) }}</h4>
							@else
								<h4 class="media-heading">{{ HTML::link('/character/sheet/'. $character->id, $character->name) }}</h4>
							@endif
							<ul class="list-inline">
								<li>Level {{ $character->details->level }} {{ $character->class != null ? $character->class->gameClass->name : 'unknown' }}</li>
							</ul>
						</div>
						<div class="col-md-3">
							<h4 class="media-heading">Games</h4>
							<ul class="list-unstyled">
								@foreach ($character->games as $game)
									<li>{{ $game->game->name }}</li>
								@endforeach
							</ul>
						</div>
						<div class="col-md-3">
							<h4 class="media-heading">Quests</h4>
						</div>
						<div class="col-md-3">
							<h4 class="media-heading">Actions</h4>
							<div class="btn-group">
								@if ($type == 'character')
									{{ HTML::link('/user/characters/games/'. $character->id, 'Request Games', array('class' => 'btn btn-xs btn-info')) }}
								@endif
								{{ HTML::link('/character/sheet/'. $character->id, 'View', array('class' => 'btn btn-xs btn-primary')) }}
								{{ HTML::link('/character/spellbook/'. $character->id, 'Spellbook', array('class' => 'btn btn-xs btn-primary')) }}
								{{ HTML::editButton('user/characters/edit/'. $character->id) }}
								{{ HTML::deleteButton('user/characters/delete/'. $character->id) }}
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
	<div class="text-center" id="{{ $type }}">
		{{ $characters->links() }}
	</div>
</div>

<script>
	@section('onReadyJs')
		// Make twitter paginator ajax
		$('#{{ $type }} .pagination a').on('click', function (event) {
			event.preventDefault();
			if ( $(this).attr('href') != '#') {
				$('#ajaxContext_{{ $type }}_{{ time() }}').load($(this).attr('href'));
			}
		});
	@stop
</script>