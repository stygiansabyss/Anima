<?php

class CharacterPresenter extends Core\CorePresenter {

	public function className()
	{
		if ($this->resource->class != null) {
			return $this->resource->class->gameClass->name;
		}

		return 'Unknown';
	}

	public function avatar()
	{
		$class     = getRootClass($this->resource);
		$imagePath = 'img/avatars/'. $class .'/'. Str::studly($this->resource->name) .'.png';

		if (file_exists(public_path() .'/'. $imagePath)) {
			return HTML::image($imagePath, null, array('style' => 'width: 64px; max-height: 64px;'));
		}

		return HTML::image('img/no_user.png', null, array('style' => 'width: 64px; max-height: 64px;'));
	}

	public function avatarFull()
	{
		$class     = getRootClass($this->resource);
		$imagePath = 'img/avatars/'. $class .'/'. Str::studly($this->resource->name) .'.png';

		if (file_exists(public_path() .'/'. $imagePath)) {
			return HTML::image($imagePath, null, array('style' => 'width: 100px;', 'class'=> 'media-object img-polaroid pull-left'));
		}

		return HTML::image('img/no_user.png', null, array('class'=> 'media-object pull-left', 'style' => 'width: 100px;'));
	}

	public function hiddenButton()
	{
		return HTML::linkIcon(
			'/game/master/update/'. $this->resource->id .'/hiddenFlag/'. ($this->resource->hiddenFlag == 1 ? 0 : 1) .'/'. getRootClass($this->resource),
			($this->resource->hiddenFlag == 1 ? 'fa fa-eye-slash' : 'fa fa-eye'),
			null,
			array('class' => 'btn btn-xs btn-primary', 'title' => ($this->resource->hiddenFlag == 1 ? 'Make Visible' : 'Make Hidden'))
		);
	}

	public function activeButton()
	{
		return HTML::linkIcon(
			'/game/master/update/'. $this->resource->id .'/activeFlag/'. ($this->resource->activeFlag == 1 ? 0 : 1) .'/'. getRootClass($this->resource),
			($this->resource->activeFlag == 1 ? 'fa fa-check' : 'fa fa-times'),
			null,
			array('class' => 'btn btn-xs btn-primary', 'title' => ($this->resource->activeFlag == 1 ? 'Make Inactive' : 'Make Active'))
		);
	}

	public function editButton($gameId)
	{
		return HTML::linkIcon(
			'/game/master/'. getRootClass($this->resource, true) .'/edit/'. $this->resource->id .'/'. $gameId,
			'fa fa-edit',
			null,
			array('class' => 'btn btn-xs btn-primary', 'title' => 'Edit')
		);
	}

	public function deleteButton()
	{
		return HTML::linkIcon(
			'/game/master/character-delete/'. getRootClass($this->resource) .'/'. $this->resource->id,
			'fa fa-trash-o',
			null,
			array('class' => 'confirm-times btn btn-xs btn-danger')
		);
	}

	public function addExpButton()
	{
		return '
			<a href="#grantExp"
				onClick="$(\'#exp_character_id\').val(\''. $this->resource->id .'\');$(\'#exp_character_type\').val(\''. getRootClass($this->resource) .'\');$(\'#exp_character_name\').text(\''. $this->resource->name .'\');$(\'#exp_character_exp\').text(\''. $this->resource->details->experience .'\');"
				role="button"
				data-toggle="modal"
				class="btn btn-xs btn-primary"
				title="Add Experience">
					<i class="fa fa-plus"></i>
			</a>
		';
	}

	public function expHistoryButton()
	{
		return '
			<a href="#modal" role="button" class="btn btn-xs btn-primary" data-toggle="modal" data-remote="/game/master/character-exp-history/'. getRootClass($this->resource) .'/'. $this->resource->id .'">
				<i class="fa fa-book" title="Experience History"></i>
			</a>
		';
	}
}