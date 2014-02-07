<?php

class Forum_PostPresenter extends Syntax\Core\Forum_PostPresenter {

	public function startedBy()
	{
		$label = null;
		if ($this->resource->forum_post_type_id == \Forum_Post::TYPE_ANNOUNCEMENT) {
			$label = '<span class="label label-default">Announcement</span>';
		} elseif ($this->resource->forum_post_type_id == \Forum_Post::TYPE_STICKY) {
			$label = '<span class="label label-default">Sticky</span>';
		} elseif ($this->resource->forum_post_type_id == \Forum_Post::TYPE_APPLICATION) {
			$label = '<span class="label label-default">Application</span>';
		}

		$block = '<small>';

		if ($label != null) {
			$block .= $label .' ';
		}

		if ($this->resource->morph_id == null) {
			$block .= 'Started by '. \HTML::link('/user/view/'. $this->resource->author->id, $this->resource->author->username);
		} else {
			$block .= 'Started by '. \HTML::link('/character/sheet/'. $this->resource->morph->id, $this->resource->morph->name);
		}
		$block .= '</small>';

		return $block;
	}

	public function lastPostBlock()
	{
		$lastUpdateType = $this->resource->lastUpdate->type->keyName;
		$lastUpdateUser = ($this->resource->lastUpdate->morph_id == null || $lastUpdateType == 'application'
			? $this->resource->lastUpdate->author : $this->resource->lastUpdate->morph);

		if ($lastUpdateUser instanceof \UserPresenter || $lastUpdateUser instanceof \User) {
			return '<small>
				'. $this->resource->lastUpdate->created_at .'
				<br />
				by '. \HTML::link('/user/view/'. $lastUpdateUser->id, $lastUpdateUser->username) .'
			</small>';
		} else {
			return '<small>
				'. $this->resource->lastUpdate->created_at .'
				<br />
				by '. \HTML::link('/character/sheet/'. $lastUpdateUser->id, $lastUpdateUser->name) .'
			</small>';
		}

	}
}