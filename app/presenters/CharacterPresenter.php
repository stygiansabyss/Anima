<?php

class CharacterPresenter extends Syntax\Core\CorePresenter {

	public function className()
	{
		if ($this->resource->class != null) {
			return $this->resource->class->gameClass->name;
		}

		return 'Unknown';
	}

	public function classId()
	{
		if ($this->resource->class != null) {
			return $this->resource->class->gameClass->id;
		}

		return 0;
	}

	public function hitPointsPercent()
	{
		$percentObject = new stdClass();
		$percentObject->percent = percent($this->resource->details->tempHitPoints, $this->resource->details->hitPoints);

		if ($percentObject->percent >= 75) {
			$percentObject->progressClass = '';
			$percentObject->barClass      = 'progress-bar progress-bar-info';
		} elseif ($percentObject->percent >= 25) {
			$percentObject->progressClass = '';
			$percentObject->barClass      = 'progress-bar progress-bar-warning';
		} else {
			$percentObject->progressClass = 'progress-striped active';
			$percentObject->barClass      = 'progress-bar progress-bar-danger';
		}

		return $percentObject;
	}

	public function magicPointsPercent()
	{
		$percentObject = new stdClass();
		$percentObject->percent = percent($this->resource->details->tempMagicPoints, $this->resource->details->magicPoints);

		if ($percentObject->percent >= 75) {
			$percentObject->progressClass = '';
			$percentObject->barClass      = 'progress-bar progress-bar-info';
		} elseif ($percentObject->percent >= 25) {
			$percentObject->progressClass = '';
			$percentObject->barClass      = 'progress-bar progress-bar-warning';
		} else {
			$percentObject->progressClass = 'progress-striped active';
			$percentObject->barClass      = 'progress-bar progress-bar-danger';
		}

		return $percentObject;
	}

	public function avatar()
	{
		$class     = getRootClass($this->resource);
		$imagePath = 'img/avatars/'. $class .'/'. Str::studly($this->resource->name) .'.png';

		if (file_exists(public_path() .'/'. $imagePath)) {
			return HTML::image($imagePath, null, array('style' => 'max-width: 64px; max-height: 64px;'));
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

	public function avatarPath()
	{
		$class     = getRootClass($this->resource);
		$imagePath = 'img/avatars/'. $class .'/'. Str::studly($this->resource->name) .'.png';

		if (file_exists(public_path() .'/'. $imagePath)) {
			return '/'. $imagePath;
		}

		return '/img/no_user.png';
	}

	public function hiddenButton()
	{
		return HTML::linkIcon(
			'/game/master/status/'. $this->resource->id .'/'. getRootClass($this->resource) .'/HIDDEN/'. ($this->resource->checkStatus('HIDDEN') ? 0 : 1),
			($this->resource->checkStatus('HIDDEN') ? 'fa fa-eye-slash' : 'fa fa-eye'),
			null,
			array('class' => 'btn btn-xs btn-primary', 'title' => ($this->resource->checkStatus('HIDDEN') ? 'Make Visible' : 'Make Hidden'))
		);
	}

	public function activeButton()
	{
		return HTML::linkIcon(
			'/game/master/status/'. $this->resource->id .'/'. getRootClass($this->resource) .'/ACTIVE/'. ($this->resource->checkStatus('ACTIVE') ? 0 : 1),
			($this->resource->checkStatus('ACTIVE') ? 'fa fa-check' : 'fa fa-times'),
			null,
			array('class' => 'btn btn-xs btn-primary', 'title' => ($this->resource->checkStatus('ACTIVE') ? 'Make Inactive' : 'Make Active'))
		);
	}

	public function statusButton($gameId)
	{
		return HTML::linkIcon(
			'/game/master/character-status/'. $this->resource->id .'/'. getRootClass($this->resource) .'/'. $gameId,
			'fa fa-bars',
			null,
			array('class' => 'btn btn-xs btn-primary', 'title' => 'Set statuses')
		);
	}

	public function editButton($gameId)
	{
		return HTML::linkIcon(
			'/game/master/'. getRootClass($this->resource, true) .'/update/'. $gameId .'/'. $this->resource->id,
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
		$exp = $this->resource->details ? $this->resource->details->experience : 0;
		return '
			<a href="#grantExp"
				onClick="$(\'#exp_character_id\').val(\''. $this->resource->id .'\');$(\'#exp_character_type\').val(\''. getRootClass($this->resource) .'\');$(\'#exp_character_name\').text(\''. str_replace('\'', '\\\'', $this->resource->name) .'\');$(\'#exp_character_exp\').text(\''. $exp .'\');"
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

	public function hair()
	{
		$appearances = Character::find($this->resource->id)->appearances;
		return $appearances->where('appearance->name', 'Hair')->first()->value;
	}

	public function eyes()
	{
		$appearances = Character::find($this->resource->id)->appearances;
		return $appearances->where('appearance->name', 'Eyes')->first()->value;
	}

	public function age()
	{
		$appearances = Character::find($this->resource->id)->appearances;
		return $appearances->where('appearance->name', 'Age')->first()->value;
	}

	public function gender()
	{
		$appearances = Character::find($this->resource->id)->appearances;
		return $appearances->where('appearance->name', 'Gender')->first()->value;
	}
}