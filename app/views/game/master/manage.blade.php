<div class="row">
	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-heading">Game Master</div>
			<div class="list-glow-sm">
				<ul class="list-glow-group no-header">
					<li id="magicTreesApproval_tab">
						<div class="list-glow-group-item">
							<div class="col-md-12">
								<a href="javascript: void(0);" class="ajaxLink block" id="magicTreesApproval" data-location="/game/master/magic-trees-approval/{{ $game->id }}">
									Magic Trees Awaiting Approval
								</a>
							</div>
						</div>
					</li>
					<li id="magicTreesApproval_tab">
						<div class="list-glow-group-item">
							<div class="col-md-12">
								<a href="javascript: void(0);" class="ajaxLink block" id="magicTreesApproval" data-location="/game/master/magic-trees-approval/{{ $game->id }}">
									Magic Trees Awaiting Approval
								</a>
							</div>
						</div>
					</li>
					<li id="magicTreesApproval_tab">
						<div class="list-glow-group-item">
							<div class="col-md-12">
								<a href="javascript: void(0);" class="ajaxLink block" id="magicTreesApproval" data-location="/game/master/magic-trees-approval/{{ $game->id }}">
									Magic Trees Awaiting Approval
								</a>
							</div>
						</div>
					</li>
					<li id="magicTreesApproval_tab">
						<div class="list-glow-group-item">
							<div class="col-md-12">
								<a href="javascript: void(0);" class="ajaxLink block" id="magicTreesApproval" data-location="/game/master/magic-trees-approval/{{ $game->id }}">
									Magic Trees Awaiting Approval
								</a>
							</div>
						</div>
					</li>
					<li id="magicTreesApproval_tab">
						<div class="list-glow-group-item">
							<div class="col-md-12">
								<a href="javascript: void(0);" class="ajaxLink block" id="magicTreesApproval" data-location="/game/master/magic-trees-approval/{{ $game->id }}">
									Magic Trees Awaiting Approval
								</a>
							</div>
						</div>
					</li>
					<li id="magicTreesApproval_tab">
						<div class="list-glow-group-item">
							<div class="col-md-12">
								<a href="javascript: void(0);" class="ajaxLink block" id="magicTreesApproval" data-location="/game/master/magic-trees-approval/{{ $game->id }}">
									Magic Trees Awaiting Approval
								</a>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div id="ajaxContent">
			<i class="fa fa-spinner fa-spin"></i>
		</div>
	</div>
	<div class="col-md-2">
		RECENT ACTIVITY
	</div>
</div>

@section('js')
	<script>
		var url   = location.href;
		var parts = url.split('#');

		if (parts[1] != null) {
			$('#'+ parts[1] +'_tab').addClass('active');
			$('#ajaxContent').html('<i class="fa fa-spinner fa-spin"></i>');
			$('#ajaxContent').load($('#'+ parts[1]).attr('data-location'));
		} else {
			$('#characters_tab').addClass('active');
			$('#ajaxContent').html('<i class="fa fa-spinner fa-spin"></i>');
			$('#ajaxContent').load($('#characters').attr('data-location'));
		}
		$('.ajaxLink').click(function() {

			$('.ajaxLink').parent().parent().parent().removeClass('active');
			$(this).parent().parent().parent().addClass('active');

			var link = $(this).attr('id');
			$('#ajaxContent').html('<i class="fa fa-spinner fa-spin"></i>');
			$('#ajaxContent').load($(this).attr('data-location'));
			$("html, body").animate({ scrollTop: 0 }, "slow");
		});
	</script>
@stop