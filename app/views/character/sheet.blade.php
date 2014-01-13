<div class="row-fluid">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				Details
				@if ($character->user->id == $activeUser->id || $activeUser->checkPermission('GAME_MASTER'))
					<div class="panel-btn">
						<div class="panel-btn-divider"></div>
						{{ HTML::linkIcon('character/update/'. $character->id, 'fa fa-edit') }}
						<div class="panel-btn-divider"></div>
						{{ HTML::linkIcon('character/spellbook/'. $character->id, 'fa fa-book') }}
					</div>
				@endif
			</div>
			<div class="media">
				{{ $character->avatarFull }}
				<div class="media-body">
					<h4 class="media-heading">{{ $character->name }}</h4>
					<table class="table table-hover table-condensed">
						<tbody>
							<tr>
								<td style="font-weight: bold;">User:</td>
								<td>{{ HTML::link('/user/view/'. $character->user->id, $character->user->username) }}</td>
							</tr>
							<tr>
								<td style="font-weight: bold;">Game:</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td style="font-weight: bold">Class:</td>
								<td>{{ $character->class->gameClass->name }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		@if ($character->user->id == $activeUser->id || $activeUser->checkPermission('GAME_MASTER'))
			@if (count($character->inventory) > 0 || count($character->currency) > 0)
				<div class="well">
					<div class="well-title">
						<a class="accordion-toggle" data-toggle="collapse" href="#inventory" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
							Currency/Inventory <i class="fa fa-chevron-down"></i>
						</a>
					</div>
					<div id="inventory" class="accordion-body collapse">
						@foreach ($character->currency as $currency)
							@if ($currency->value != null)
								<table class="table table-condensed table-hover text-center">
									<caption>{{ $currency->gameCurrency->name }}</caption>
									<tbody>
										<tr>
											<td>{{ nl2br($currency->value) }}</td>
										</tr>
									</tbody>
								</table>
							@endif
						@endforeach
						@foreach ($character->inventory as $inventory)
							@if ($inventory->value != null)
								<table class="table table-condensed table-hover text-center">
									<caption>{{ $inventory->gameInventory->name }}</caption>
									<tbody>
										<tr>
											<td>{{ nl2br($inventory->value) }}</td>
										</tr>
									</tbody>
								</table>
							@endif
						@endforeach
					</div>
				</div>
			@endif
		@endif
	</div>
	<div class="col-md-4">
		@if (count($character->appearances) > 0)
			<div class="panel panel-default">
				<div class="panel-heading">Description</div>
				<div class="list-group">
					@foreach ($character->appearances as $appearance)
						@if (!is_null($appearance->value))
							<div class="list-group-item">
								<h5 class="list-group-item-heading">{{ $appearance->appearance->name }}</h5>
								<div class="list-group-item-text">{{ nl2br($appearance->value) }}</div>
							</div>
						@endif
					@endforeach
				</div>
			</div>
		@endif
	</div>
	@if ($character->user->id == $activeUser->id || $activeUser->checkPermission('GAME_MASTER'))
		@if (count($character->attributes) > 0 || count($character->secondaryAttributes) > 0)
			<div class="col-md-4">
				@if (count($character->stats) > 0)
					<div class="panel panel-default">
						<div class="panel-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#baseStats" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
								Base Stats <i class="fa fa-chevron-down"></i>
							</a>
						</div>
						<table id="baseStats" class="table table-condensed table-striped table-hover accordion-body collapse">
							<thead>
								<tr>
									<th>Stat</th>
									<th>Value</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Level</td>
									<td class="text-center">{{ $character->details->level }}</td>
								</tr>
								<tr>
									<td>LP</td>
									<td class="text-center">{{ $character->details->hitPoints }}</td>
								</tr>
								<tr>
									<td>Zeon</td>
									<td class="text-center">{{ $character->details->magicPoints }}</td>
								</tr>
								@foreach ($character->stats as $stat)
									@if (!is_null($stat->value))
										<tr>
											<td>{{ $stat->stat->name }}</td>
											<td class="text-center">{{ $stat->value }}</td>
										</tr>
									@endif
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
				@if (count($character->characterAttributes) > 0)
					<div class="panel panel-default">
						<div class="panel-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#attributes" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
								Attributes <i class="fa fa-chevron-down"></i>
							</a>
						</div>
						<table id="attributes" class="table table-condensed table-striped table-hover accordion-body collapse">
							<thead>
								<tr>
									<th>Attribute</th>
									<th>Value</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($character->characterAttributes as $attribute)
									@if (!is_null($attribute->value))
										<tr>
											<td>{{ $attribute->attribute->name }}</td>
											<td class="text-center">{{ $attribute->value }}</td>
										</tr>
									@endif
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
				@if (count($character->secondaryAttributes) > 0)
					<div class="panel panel-default">
						<div class="panel-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#secondaryAttributes" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
								Secondary Attributes <i class="fa fa-chevron-down"></i>
							</a>
						</div>
						<table id="secondaryAttributes" class="table table-condensed table-striped table-hover accordion-body collapse">
							<thead>
								<tr>
									<th>Attribute</th>
									<th>Value</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($character->secondaryAttributes as $attribute)
									@if (!is_null($attribute->value))
										<tr>
											<td>{{ $attribute->attribute->name }}</td>
											<td class="text-center">{{ $attribute->value }}</td>
										</tr>
									@endif
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
				@if (count($character->skills) > 0)
					<div class="panel panel-default">
						<div class="panel-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#skills" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
								Skills <i class="fa fa-chevron-down"></i>
							</a>
						</div>
						<table id="skills" class="table table-condensed table-striped table-hover accordion-body collapse">
							<thead>
								<tr>
									<th>Skill</th>
									<th>Attribute</th>
									<th>Value</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($character->skills as $skill)
									@if (!is_null($skill->skill) && $skill->value != 0)
										<tr>
											<td>{{ $skill->skill->name }}</td>
											<td>{{ $skill->skill->attribute->name }}</td>
											<td class="text-center">{{ $skill->value }}</td>
										</tr>
									@endif
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
				@if (count($character->advantages) > 0)
					<div class="panel panel-default">
						<div class="panel-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#advantages" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
								Advantages <i class="fa fa-chevron-down"></i>
							</a>
						</div>
						<table id="advantages" class="table table-condensed table-striped table-hover accordion-body collapse">
							<thead>
								<tr>
									<th>Advantage</th>
									<th>Value</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($character->advantages as $advantage)
									<tr>
										<td>{{ $advantage->trait->name }}</td>
										<td class="text-center">{{ $advantage->value }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
				@if (count($character->disadvantages) > 0)
					<div class="panel panel-default">
						<div class="panel-heading">
							<a class="accordion-toggle" data-toggle="collapse" href="#disadvantages" onClick="$(this).children().toggleClass('fa fa-chevron-down').toggleClass('fa fa-chevron-up');">
								Disadvantages <i class="fa fa-chevron-down"></i>
							</a>
						</div>
						<table id="disadvantages" class="table table-condensed table-striped table-hover accordion-body collapse">
							<thead>
								<tr>
									<th>Disadvantage</th>
									<th>Value</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($character->disadvantages as $disadvantage)
									<tr>
										<td>{{ $disadvantage->trait->name }}</td>
										<td class="text-center">{{ $disadvantage->value }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
			</div>
		@endif
	@endif
</div>