<div class="row-fluid">
	<div class="col-md-offset-1 col-md-10">
		<div class="well">
			<div class="well-title">
				Current Games
				<div class="well-btn well-btn-right">
					{{ HTML::addButton('/game/master/games/add') }}
				</div>
			</div>
			{{ HTML::table() }}
				<thead>
					<tr>
						<th>Name</th>
						<th>Story-tellers</th>
						<th>Characters</th>
						<th>Forum</th>
						<th class="text-right">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($games as $game)
						<tr>
							<td>{{ $game->name }}</td>
							<td>{{ $game->storytellerLinks }}</td>
							<td>{{ $game->characters->count() }}</td>
							<td>&nbsp;</td>
							<td class="text-right">
								<div class="btn-group">
									{{ HTML::editButton('/game/master/games/edit/'. $game->id) }}
									{{ HTML::deleteButton('/game/master/games/delete/'. $game->id) }}
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div