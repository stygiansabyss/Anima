<div class="thumbnail well text-center">
	<div class="well-title">
		{{ HTML::link('/character/sheet/'. $character->id, Str::words($character->name, 2)) }}
	</div>
	@if ($character->details->level != 0)
		Level {{ $character->details->level }}
	@endif
	<div style="width: 64px; height: 64px; margin: 0px auto 5px auto;">
		@if (Request::Ajax())
			<a href="javascript:void(0)" onClick="editCharacter('{{ $character->id }}', '{{ getRootClass($character) }}', '{{ $character->name }}')">
				{{ $character->avatar }}
			</a>
		@else
			{{ $character->avatar }}
		@endif
	</div>
	<div class="row">
		<div class="col-md-1"><strong><small>LP</small></strong></div>
		<div class="col-md-9">
			<div>
				<span id="tempHitPoints_value_{{ $character->id }}">
					{{ $character->details->tempHitPoints }}
				</span>
				&nbsp;/&nbsp;{{ $character->details->hitPoints }}
			</div>
			<div class="progress {{ $character->hitPointsPercent->progressClass }}" style="margin-top: -18px;">
				<div 
					id="tempHitPoints_bar_{{ $character->id }}" 
					role="progressbar" 
					aria-valuenow="{{ $character->details->tempHitPoints }}" 
					class="{{ $character->hitPointsPercent->barClass }}" 
					style="width: {{ $character->hitPointsPercent->percent }}%">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-1"><strong><small>Zeon</small></strong></div>
		<div class="col-md-9">
			<div>
				<span id="tempMagicPoints_value_{{ $character->id }}">
					{{ $character->details->tempMagicPoints }}
				</span>
				&nbsp;/&nbsp;{{ $character->details->magicPoints }}
			</div>
			<div class="progress {{ $character->magicPointsPercent->progressClass }}" style="margin-top: -18px;">
				<div 
					id="tempMagicPoints_bar_{{ $character->id }}" 
					role="progressbar" 
					aria-valuenow="{{ $character->details->tempHitPoints }}" 
					class="{{ $character->magicPointsPercent->barClass }}" 
					style="width: {{ $character->magicPointsPercent->percent }}%">
				</div>
			</div>
		</div>
	</div>
</div>