<div id="ajaxContent">
	<div class="row">
		<div class="col-md-12">
			<small>
				<ul class="breadcrumb">
					@if ($rolls->count() > 0)
						<li>Your current stat rolls are: {{ implode(', ', $rolls->roll->toArray()) }}</li>
					@else
						<li>{{ HTML::link('/user/characters/roll', 'Generate Stat Rolls') }}</li>
					@endif
				</ul>
			</small>
		</div>
	</div>
	@include('user.character.paginationcharacters')
</div>