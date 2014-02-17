<div class="row-fluid">
	<div class="col-md-offset-4 col-md-4">
		@foreach ($newsItems as $newsItem)
			<div class="well">
				<div class="well-title">
					{{ HTML::link('forum/post/view/'. $newsItem->uniqueId, $newsItem->name) }}
					@if ($developer === true)
						<div class="well-btn well-btn-right">
							{{ HTML::link('forum/post/edit/'. $newsItem->uniqueId,'Edit') }}
						</div>
					@endif
				</div>
				{{ BBCode::parse($newsItem->content) }}
				<hr />
				<div class="pull-left"><small>{{ $newsItem->created_at }}</small></div>
				<div class="pull-right">
					<small>
						By: {{ HTML::link('/user/view/'. $newsItem->author->id, $newsItem->author->username) }}&nbsp;|&nbsp;
						{{ HTML::link('/forum/post/view/'. $newsItem->id, $newsItem->repliesCount .' '. Str::plural('Reply', $newsItem->repliesCount)) }}
					</small>
				</div>
				<div class="clearfix"></div>
			</div>
		@endforeach
	</div>
</div>