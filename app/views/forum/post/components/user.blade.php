							<!-- Start Author/Character Name -->
							@if ($post->morph_id != null)
								{{ HTML::link('/character/sheet/'. $post->morph->id, $post->morph->name, array('class' => 'lead')) }}
								<br />
								<small>User: {{ HTML::link('/user/view/'. $post->author->id, $post->author->username) }}</small>
							@else
								{{ HTML::link('/user/view/'. $post->author->id, $post->author->username, array('class' => 'lead')) }}
							@endif
							<!-- End Author/Character Name -->
							<br />
							@if ($post->morph_id != null)
								<small>Class: {{ $post->morph->className }}</small>
								<br />
								<?php
									$class     = getRootClass($post->morph);
									$imagePath = 'img/avatars/'. $class .'/'. Str::studly($post->morph->name) .'.png';

									if (file_exists(public_path() .'/'. $imagePath)) {
										$avatar = HTML::image($imagePath, null, array('style' => 'width: 100px;', 'class'=> 'img-polaroid'));
									} else {
										$avatar = HTML::image('img/no_user.png', null, array('class'=> 'img-polaroid', 'style' => 'width: 100px;'));
									}
								?>
								{{ $avatar }}
								<br />
								<small>
									Posts: {{ $post->morph->postsCount }}
							@else
								<!-- Start Avatar and Post Count -->
								<small>{{ $post->author->getHighestRole('Forum') }}</small>
								<br />
								{{ HTML::image($post->author->image, null, array('class'=> 'img-polaroid', 'style' => 'width: 100px;')) }}
								<br />
								<small>
									Posts: {{-- $post->author->postsCount --}}
								<!-- End Avatar and Post Count -->
							@endif
							<!-- Start Online Status -->
								<br />
								{{ ($post->author->lastActive >= date('Y-m-d H:i:s', strtotime('-15 minutes'))
									? HTML::image('img/icons/online.png', 'Online', array('title' => 'Online')) .' Online'
									: HTML::image('img/icons/offline.png', 'Offline', array('title' => 'Offline')) .' Offline'
								) }}
							</small>
							<!-- End Online Status -->