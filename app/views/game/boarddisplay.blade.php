{{ Form::open() }}
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">Characters</div>
				<table class="table table-hover table-condensed">
					<tbody>
						@foreach ($characters as $character)
							<tr>
								<td>{{ $character->name }}</td>
								<td>{{ Form::checkbox('characters[Character][]', $character->id, true) }}
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="panel-footer">
					{{ Form::submit('Submit all selections', array('class' => 'btn btn-xs btn-primary')) }}
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">NPCs</div>
				<table class="table table-hover table-condensed">
					<tbody>
						@foreach ($npcs as $character)
							<tr>
								<td>{{ $character->name }}</td>
								<td>{{ Form::checkbox('characters['. getRootClass($character) .'][]', $character->id, false) }}
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="panel-footer">
					{{ Form::submit('Submit all selections', array('class' => 'btn btn-xs btn-primary')) }}
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">Creatures</div>
				<table class="table table-hover table-condensed">
					<tbody>
						@foreach ($creatures as $character)
							<tr>
								<td>{{ $character->name }}</td>
								<td>{{ Form::checkbox('characters[Creature][]', $character->id, false) }}
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="panel-footer">
					{{ Form::submit('Submit all selections', array('class' => 'btn btn-xs btn-primary')) }}
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">Inactive</div>
				<table class="table table-hover table-condensed">
					<tbody>
						@foreach ($inactive as $character)
							<tr>
								<td>{{ $character->name }}</td>
								<td>{{ Form::checkbox('characters['. getRootClass($character) .'][]', $character->id, false) }}
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="panel-footer">
					{{ Form::submit('Submit all selections', array('class' => 'btn btn-xs btn-primary')) }}
				</div>
			</div>
		</div>
	</div>
{{ Form::close() }}