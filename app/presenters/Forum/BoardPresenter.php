<?php

class Forum_BoardPresenter extends Syntax\Core\Forum_BoardPresenter {

	public function lastPostBlock()
	{
		if ($this->resource->lastUpdate !== false) {
			$lastUpdateType = $this->resource->lastUpdate->type->keyName;
			$lastUpdateUser = ($this->resource->lastUpdate->morph_id == null || $lastUpdateType == 'application'
				? $this->resource->lastUpdate->author : $this->resource->lastUpdate->morph);

			if ($lastUpdateUser instanceof \UserPresenter || $lastUpdateUser instanceof \User) {
				return '<small>
					Last Post by '. \HTML::link('/user/view/'. $lastUpdateUser->id, $lastUpdateUser->username) .'
					<br />
					in '. \HTML::link('forum/post/view/'. $this->resource->lastPost->id .'#reply:'. $this->resource->lastUpdate->id, $this->resource->lastUpdate->name) .'
					<br />
					on '. $this->resource->lastUpdate->created_at .'
				</small>';
			} else {
				return '<small>
					Last Post by '. \HTML::link('/character/sheet/'. $lastUpdateUser->id, $lastUpdateUser->name) .'
					<br />
					in '. \HTML::link('forum/post/view/'. $this->resource->lastPost->id .'#reply:'. $this->resource->lastUpdate->id, $this->resource->lastUpdate->name) .'
					<br />
					on '. $this->resource->lastUpdate->created_at .'
				</small>';
			}
		} else {
			return '<small>
				No posts.
			</small>';
		}
	}
}