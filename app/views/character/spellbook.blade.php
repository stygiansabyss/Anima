<div class="row" id="ajaxContent">
	<div class="col-md-12">
		@include('character.components.breadcrumbs')
		<div class="well">
			<?php
				$spellCount = count($characterSpells);
				$index = 0;
			?>
			<div class="well-title">{{ $character->name }}'s  SpellBook</div>
			<table class="table table-hover table-striped table-condensed text-center">
				<thead>
					<tr>
						<th class="text-left">Name</th>
						<th class="text-center">Tree</th>
						<th class="text-center">Attribute</th>
						<th class="text-center">Level</th>
						<th class="text-center">Use Cost</th>
						<th class="text-center">Buy Cost</th>
						<th class="text-center">Details</th>
						<th class="text-right">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($characterSpells as $spell)
						<?php
							$index++;
							if ($index < 10) {
								$popOver = 'bottom';
							} elseif ($index > $spellCount - 10) {
								$popOver = 'top';
							} else {
								$popOver = 'bottom';
							}
						?>
						<tr>
							<td class="text-left">
								@if ($spell->approvedFlag == 0)
									<span class="label label-important">Unapproved</span>&nbsp;&nbsp;&nbsp;
								@endif
								{{ $spell->spell->name }}
							</td>
							<td>{{ $spell->spell->tree->name }}</td>
							<td>{{ $spell->spell->attribute->name }}</td>
							<td>{{ $spell->spell->level }}</td>
							<td>{{ $spell->spell->useCost }}</td>
							<td>{{ $spell->buyCost }}</td>
							<td>
								<div class="btn-group">
									<a href="javascript: void();" data-trigger="{{ $activeUser->popover }}" rel="popover" class="btn btn-xs btn-inverse" data-toggle="popover" data-placement="{{ $popOver }}" data-content="{{ nl2br($spell->description) }}" data-html="true" title data-original-title="Description">Description</a>
									@if ($spell->spell->stats != null)
										<a href="javascript: void();" data-trigger="{{ $activeUser->popover }}" rel="popover" class="btn btn-xs btn-inverse" data-toggle="popover" data-placement="{{ $popOver }}" data-content="{{ nl2br($spell->spell->stats) }}" data-html="true" title data-original-title="Stats">Stats</a>
									@endif
									@if ($spell->spell->extra != null)
										<a href="javascript: void();" data-trigger="{{ $activeUser->popover }}" rel="popover" class="btn btn-xs btn-inverse" data-toggle="popover" data-placement="{{ $popOver }}" data-content="{{ nl2br($spell->spell->extra) }}" data-html="true" title data-original-title="Extra Details">Extra Details</a>
									@endif
								</div>
							</td>
							<td class="text-right">
								<div class="btn-group">
									{{ HTML::editButton('/character/spell/edit/'. $spell->id .'/'. $character->id) }}
									{{ HTML::deleteButton('/character/spell/delete/'. $spell->id .'/'. $character->id) }}
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{{ $characterSpells->links() }}
			</div>
		</div>
	</div>
</div>

<script>
	@section('onReadyJs')
		// Make twitter paginator ajax
		$('.pagination a').on('click', function (event) {
			event.preventDefault();
			if ( $(this).attr('href') != '#') {
				$('#ajaxContent').load($(this).attr('href'));
			}
		});
	@stop
</script>