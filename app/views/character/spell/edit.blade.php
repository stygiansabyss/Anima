{{ bForm::open() }}
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Edit {{ $spell->spell->name }} for {{ $character->name }}</div>
				<table class="table table-condensed">
					<thead></thead>
					<tbody>
						<tr>
							<td style="width: 150px;"><strong class="text-primary">Magic Tree</strong></td>
							<td>{{ $spell->spell->tree->name }}</td>
						</tr>
						<tr>
							<td><strong class="text-primary">Attribute</strong></td>
							<td>{{ $spell->spell->attribute->name }}</td>
						</tr>
						<tr>
							<td><strong class="text-primary">Level</strong></td>
							<td>{{ $spell->spell->level }}</td>
						</tr>
						<tr>
							<td><strong class="text-primary">Use Cost</strong></td>
							<td>{{ $spell->spell->useCost }}</td>
						</tr>
						<tr>
							<td><strong class="text-primary">Stats</strong></td>
							<td>{{ $spell->spell->stats }}</td>
						</tr>
						<tr>
							<td><strong class="text-primary">Extra</strong></td>
							<td>{{ $spell->spell->extra }}</td>
						</tr>
					</tbody>
				</table>
				<hr />
				<div class="panel-body">
					{{ bForm::text('buyCost', $spell->buyCost, array(), 'Purchase Cost') }}
					{{ bForm::textarea('description', $spell->description, array(), 'Description') }}
					{{ bForm::submit('Update') }}
				</div>
			</div>
		</div>
	</div>
{{ bForm::close() }}