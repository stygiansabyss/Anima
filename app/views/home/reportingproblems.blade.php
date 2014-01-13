<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">How-To Report Problems</div>
			<div class="panel-body">
				<h4>On The Forums</h4>
				<div>
					The first way to submit site wide issues is to do so in the forums.  There are two boards at the bottom, "Bugs" and "Feature Requests".  If you notice a problem with the site, add it to the "Bugs" board.  If you have something you would like to see added, make your post in "Feature Requests".
				</div>
				<br />
				<h4>To Site Admins</h4>
				<div>
					The other option is to directly message a site admin.  You should use this as a last option, but the site admins are listed below.
					<br />
					<br />
					<ul class="list-unstyled">
						@foreach ($admins as $admin)
							<li>{{ HTML::link('/user/view/'. $admin->id, $admin->username, array('target' => '_blank')) }}</li>
						@endforeach
					</ul>
				</div>
				<br />
				<h4>To your GM</h4>
				<div>
					You can also message your GM if the problem is relating to the game itself.  The list of current story-tellers and game masters is detailed below.
					<br />
					<br />
					<ul class="list-unstyled">
						@foreach ($gameMasters as $gameMaster)
							<li>{{ HTML::link('/user/view/'. $gameMaster->id, $gameMaster->username, array('target' => '_blank')) }}</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>