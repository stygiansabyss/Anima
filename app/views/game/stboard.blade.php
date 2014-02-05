<div class="row">
	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-heading">ST Controls</div>
			<ul class="list-group">
				<li class="list-group-item">
					<a href="javascript: void(0);" class="ajaxLink" id="board" data-location="/game/board/{{ $gameId }}">
						Board
					</a>
				</li>
				<li class="list-group-item">
					<a href="javascript: void(0);" class="ajaxLink" id="display" data-location="/game/board-display/{{ $gameId }}">
						Display on board
					</a>
				</li>
			</ul>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">Modify Character</div>
			<div class="panel-body">
				{{ bForm::setSizes(2, 8)->setType('basic')->open(false, array('id' => 'characterForm')) }}
					{{ form::hidden('morph_type', null, array('id' => 'morph_type')) }}
					{{ form::hidden('morph_id', null, array('id' => 'morph_id')) }}
					{{ form::hidden('type', null, array('id' => 'type')) }}
					{{ bForm::text('name', null, array('id' => 'name', 'readonly' => 'readonly'), 'Name') }}
					{{ bForm::text('dmg', null, array('id' => 'dmg'), 'DMG LP') }}
					{{ bForm::text('use', null, array('id' => 'use'), 'Use Magic') }}
					<div class="form-group">
						<div class="row text-center">
							<div class="col-md-3">
								<i class="fa fa-reply" onClick="formSubmit('resetHit')" title="Reset LP"></i>
							</div>
							<div class="col-md-3">
								<i class="fa fa-reply" onClick="formSubmit('resetMagic')" title="Reset Magic"></i>
							</div>
							<div class="col-md-3">
								<i class="fa fa-plus-circle" onClick="formSubmit('add')"></i>
							</div>
							<div class="col-md-3">
								<i class="fa fa-minus-circle" onClick="formSubmit('sub')"></i>
							</div>
						</div>
					</div>
				{{ bForm::close() }}
			</div>
		</div>
	</div>
	<div class="col-md-10">
		<div id="ajaxContent"><i class="fa fa-spin fa-spinner"></i></div>
	</div>
</div>

@section('js')
	<script>
		// Handle board controls
		function editCharacter(characterId, type, name) {
			$('#morph_id').val(characterId);
			$('#morph_type').val(type);
			$('#name').val(name);
		}

		function formSubmit(type) {
			if ($('#name').val() == '') {
				Messenger().post({message: 'Select a character', type: 'error', showCloseButton: true});
			} else {
				// Send form to node method
				$('#type').val(type);
				$.post('/game/update-character/{{ $gameId }}', $('#characterForm').serialize());
				$('#characterForm').find("input[type=text], input[type=hidden]").val("");
			}
		}

		// Handle the tabs
		var url   = location.href;
		var parts = url.split('#');

		if (parts[1] != null) {
			$('#'+ parts[1]).parent().addClass('active');
			$('#ajaxContent').html('<i class="fa fa-spin fa-spinner"></i>');
			$('#ajaxContent').load($('#'+ parts[1]).attr('data-location'));
		} else {
			$('#board').parent().addClass('active');
			$('#ajaxContent').html('<i class="fa fa-spin fa-spinner"></i>');
			$('#ajaxContent').load($('#board').attr('data-location'));
		}
		$('.ajaxLink').click(function() {

			$('.ajaxLink').parent().removeClass('active');
			$(this).parent().addClass('active');

			var link = $(this).attr('id');
			$('#ajaxContent').html('<i class="fa fa-spin fa-spinner"></i>');
			$('#ajaxContent').load($(this).attr('data-location'));
			$("html, body").animate({ scrollTop: 0 }, "slow");
		});

		function collapse (target) {
			$('#'+ target).toggle();
			$.get('/collapse/'+ target);
		}
	</script>
@stop