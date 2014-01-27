<div class="row">
	<div class="col-md-6">
		@foreach (array_chunk($characters->toArray(), 4) as $characterGroup)
			<div class="row">
				@foreach ($characterGroup as $character)
					<div class="col-md-3">
						@include('game.master.components.character.thumbnail')
					</div>
				@endforeach
			</div>
		@endforeach
	</div>
</div>