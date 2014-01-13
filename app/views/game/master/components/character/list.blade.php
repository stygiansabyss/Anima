<div class="well">
	<div class="well-title">
		<a class="accordion-toggle" data-toggle="collapse" href="#collapse{{ Str::studly($title) }}" style="color: #000;" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
			{{ $title }} ({{ $characters->count() }}) <i class="fa fa-chevron-down"></i>
		</a>
		@if ($type != 'inactive')
			<div class="well-btn well-btn-right">
				{{ HTML::linkIcon('/game/master/'. $type .'/create/'. $game->id, 'fa fa-plus') }}
			</div>
		@endif
	</div>
	<div id="collapse{{ Str::studly($title) }}" class="accordion-body collapse">
		@if ($type == 'entity')
			<table class="table table-hover table-striped table-condensed text-center">
				<thead>
					<tr>
						<th class="text-center">Name</th>
						<th class="text-center">Hidden</th>
						<th class="text-right">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($characters as $character)
						<tr>
							<td>
								{{ HTML::link('character/sheet/'. $character->id, $character->name, array('target' => '_blank')) }}
							</td>
							<td>{{ $character->hidden }}</td>
							<td class="text-right">
								<div class="btn-group">
									{{ $character->hiddenButton }}
									{{ $character->activeButton }}
									{{ $character->editButton($game->id) }}
									{{ $character->deleteButton }}
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@else
			<table class="table table-hover table-striped table-condensed text-center">
				<thead>
					<tr>
						<th class="text-center">Name</th>
						<th class="text-center">Class</th>
						<th class="text-center">EXP</th>
						<th class="text-center">User</th>
						<th class="text-right">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($characters as $character)
						<tr>
							<td>
								{{ HTML::link('character/sheet/'. $character->id, $character->name, array('target' => '_blank')) }}
								@if ($character->details->hitPoints == 0)
									<small class="text-error">(Desceased)</small>
								@endif
							</td>
							<td>
								{{ $character->className }}
								@if ($character->details->level != 0)
									({{ $character->details->level }})
								@endif
							</td>
							<td>
								@if (!isset($character->noExpFlag) || $character->noExpFlag == 0)
									{{ $character->details->experience }}
								@endif
							</td>
							<td>{{ $character->user->profile }}</td>
							<td class="text-right">
								<div class="btn-group">
									{{ $character->addExpButton }}
									{{ $character->expHistoryButton }}
									{{ $character->hiddenButton }}
									{{ $character->activeButton }}
									{{ $character->editButton($game->id) }}
									{{ $character->deleteButton }}
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endif
	</div>
</div>