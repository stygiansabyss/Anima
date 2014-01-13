@include('character.components.breadcrumbs')
{{ bForm::ajaxForm('submitForm', 'New spell submitted for approval.')->open() }}
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Request a spell</div>
				<div class="panel-body">
					{{ bForm::select('type_id', $magicTypes, null, array('id' => 'type_id', 'onChange' => 'getTrees(this)'), 'Magic Type') }}
					{{ bForm::select('tree_id', array(0 => 'Trees require a magic type'), null, array('id' => 'tree_id', 'onChange' => 'getSpells(this)'), 'Magic Tree') }}
					{{ bForm::select('spell_id', array(0 => 'Spells require a magic tree'), null, array('id' => 'spell_id'), 'Spell') }}
					{{ bForm::text('buyCost', null, array('id' => 'buyCost', 'placeholder' => 'Purchase Cost'), 'Purchase Cost') }}
					{{ bForm::textarea('description', null, array('id' => 'description', 'placeholder' => 'Description'), 'Description') }}
					{{ bForm::jsonSubmit('Submit Spell') }}
				</div>
				<div class="panel-footer">
					<div id="message"></div>
				</div>
			</div>
		</div>
	</div>
{{ bForm::close() }}

@section('js')
	<script>
		function getTrees(object) {
			$.ajax({
				url: '/character/spell/check-type/'+ object.value,
				dataType: 'json',
				success: function(data) {
					$.ajax({
						url: '/character/spell/tree-list/'+ object.value,
						dataType: 'json',
						success: function(data) {
							$('#tree_id').children().remove().end()
							$('#tree_id').append(
								'<option value="0">Select a Tree</option>'
							);
							$.each(data, function() {
								$('#tree_id').append(
									'<option value="'
									+ this.uniqueId
									+ '">'
									+ this.name
									+ '</option>'
								);
							});
						}
					});
				}
			});
		}
		function getSpells(object) {
			$.ajax({
				url: '/character/spell/check-tree/'+ object.value,
				dataType: 'json',
				success: function(data) {
					$.ajax({
						url: '/character/spell/spell-list/'+ object.value,
						dataType: 'json',
						success: function(data) {
							$('#spell_id').children().remove().end()
							$('#spell_id').append(
								'<option value="0">Select a Spell</option>'
							);
							$.each(data, function() {
								$('#spell_id').append(
									'<option value="'
									+ this.uniqueId
									+ '">'
									+ this.name
									+ '</option>'
								);
							});
						}
					});
				}
			});
		}
	</script>
@stop