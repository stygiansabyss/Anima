<div class="panel panel-default">
	<div class="panel-heading">
		{{ $title }}
		@if ($type != 'inactive')
			<div class="panel-btn">
				{{ HTML::linkIcon('/game/master/'. $type .'/create/'. $game->id, 'fa fa-plus') }}
			</div>
		@endif
	</div>
	<div>
		@if ($type == 'entity')
			<table class="table table-hover table-striped table-condensed">
				<thead>
					<tr>
						<th>Name</th>
						<th>Hidden</th>
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
			<table class="table table-hover table-striped table-condensed">
				<thead>
					<tr>
						<th>Name</th>
						@if ($type == 'inactive')
							<th>Statuses</th>
						@endif
						<th>Class</th>
						@if ($type == 'npc' || $type == 'inactive')
							<th>Type</th>
						@endif
						<th>EXP</th>
						<th>User</th>
						<th class="text-right">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($characters as $character)
						<tr>
							<td>
								{{ HTML::link('character/sheet/'. $character->id, $character->name, array('target' => '_blank')) }}
								@if ($character->details && $character->details->hitPoints == 0)
									<small class="text-error">(Deceased)</small>
								@elseif ($character->checkStatus('IN_PROGRESS'))
									<small class="text-info">(In Progress)</small>
								@endif
							</td>
							@if ($type == 'inactive')
								<td>
									<small>
										@foreach ($character->status->status as $status)
											<span class="label label-enhancement">{{ $status->name }}</span>
										@endforeach
									</small>
								</td>
							@endif
							<td>
								{{ $character->className }}
								@if ($character->details && $character->details->level != 0)
									({{ $character->details->level }})
								@endif
							</td>
							@if ($type == 'npc' || $type == 'inactive')
								<td>{{ getRootClass($character) }}</td>
							@endif
							<td>
								@if ($character->details && (!isset($character->noExpFlag) || $character->noExpFlag == 0))
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
									{{ $character->statusButton($game->id) }}
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