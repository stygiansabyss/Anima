<?php

class Game extends BaseModel {
	/********************************************************************
	 * Declarations
	 *******************************************************************/
	/**
	 * Table declaration
	 *
	 * @var string $table The table this model uses
	 */
	protected $table      = 'games';
	protected $primaryKey = 'uniqueId';
	public $incrementing  = false;

	/**
	 * Soft Delete users instead of completely removing them
	 *
	 * @var bool $softDelete Whether to delete or soft delete
	 */
	protected $softDelete = true;
	
	/********************************************************************
	 * Aware validation rules
	 *******************************************************************/
	/**
	 * Validation rules
	 *
	 * @static
	 * @var array $rules All rules this model must follow
	 */
	public static $rules = array(
		'name'    => 'required|max:200',
		'keyName' => 'required|max:200',
	);
	
	/********************************************************************
	 * Scopes
	 *******************************************************************/
	
	/********************************************************************
	 * Relationships
	 *******************************************************************/
	public static $relationsData = array(
		'storyTellers' => array('hasMany',	'Game_Storyteller',	'foreignKey' => 'game_id'),
		'characters'   => array('hasMany',	'Game_Character',	'foreignKey' => 'game_id'),
	);
	
	/********************************************************************
	 * Model Events
	 *******************************************************************/
	
	/********************************************************************
	 * Getter and Setter methods
	 *******************************************************************/
	public function getPlayerCharactersAttribute()
	{
		$characters = $this->characters->filter(function ($character) {
			if (!$character->morph->checkStatus(array('APPROVED', 'ACTIVE'), true)) return false;
			if ($character->morph->checkStatus(array('DEAD', 'INACTIVE', 'NPC'))) return false;
			if ($character->morph_type == 'Character') return true;
		})->morph->sortBy(function ($character) {
			return $character->name;
		});

		return $characters;
	}

	public function getAllPlayerCharactersAttribute()
	{
		$characters = $this->characters->filter(function ($character) {
			if ($character->morph_type == 'Character') return true;
		})->morph->sortBy(function ($character) {
			return $character->name;
		});

		return $characters;
	}

	public function getCreaturesAttribute()
	{
		$characters = $this->characters->filter(function ($character) {
			if (!$character->morph->checkStatus('APPROVED')) return false;
			if ($character->morph->checkStatus(array('DEAD', 'INACTIVE', 'NPC'))) return false;
			if ($character->morph_type == 'Creature') return true;
		})->morph->sortBy(function ($character) {
			return $character->name;
		});

		return $characters;
	}

	public function getEnemiesAttribute()
	{
		$characters = $this->characters->filter(function ($character) {
			if (!$character->morph->checkStatus('APPROVED')) return false;
			if ($character->morph->checkStatus(array('DEAD', 'INACTIVE', 'NPC'))) return false;
			if ($character->morph_type == 'Enemy') return true;
		})->morph->sortBy(function ($character) {
			return $character->name;
		});

		return $characters;
	}

	public function getNpcsAttribute()
	{
		$characters = $this->characters->filter(function ($character) {
			if (!$character->morph->checkStatus('APPROVED')) return false;
			if ($character->morph->checkStatus(array('DEAD', 'INACTIVE'))) return false;
			if ($character->morph->checkStatus(array('NPC'))) return true;
		})->morph->sortBy(function ($character) {
			return $character->name;
		});

		return $characters;
	}

	public function getDeadCharactersAttribute()
	{
		$characters = $this->characters->morph->filter(function ($character) {
			if ($character->checkStatus(array('DEAD', 'INACTIVE'))) return true;
			if (!$character->checkStatus('ACTIVE')) return true;
		})->sortBy(function ($character) {
			return $character->name;
		});

		return $characters;
	}

	public function getStorytellerLinksAttribute()
	{
		$storytellers = $this->storyTellers->user;
		$links        = array();

		if ($storytellers->count() > 0) {
			foreach ($storytellers as $storyteller) {
				$links[] = HTML::link('/user/view/'. $storyteller->id, $storyteller->username, array('target' => '_blank'));
			}

			return implode(', ', $links);
		}

		return null;
	}

	/**
	 * Get all unapproved user trees
	 *
	 * @return array
	 */
	public function getUnApprovedTreesAttribute()
	{
		// Get all characters
		$characters = $this->characters->morph;

		if (count($characters) > 0) {
			$characters = $characters->filter(function ($character) {
				if (isset($character->customTrees) && $character->customTrees != null) return true;
			});
			$unapprovedTrees = $characters->customTrees->filter(function ($tree) {
				if ($tree->approvedFlag == 0) {
					return true;
				}
			});

			return $unapprovedTrees;
		}
		return array();
	}

	/**
	 * Get all unapproved user spells
	 *
	 * @return array
	 */
	public function getUnApprovedSpellsAttribute()
	{
		// Get all characters
		$characters = $this->characters->morph;

		if (count($characters) > 0) {
			$characters = $characters->filter(function ($character) {
				if (isset($character->customSpells) && $character->customSpells != null) return true;
			});
			$unapprovedSpells = $characters->customSpells->filter(function ($spell) {
				if ($spell->approvedFlag == 0) {
					return true;
				}
			});

			return $unapprovedSpells;
		}
		return array();
	}

	/**
	 * Get all unapproved character spells
	 *
	 * @return array
	 */
	public function getUnApprovedCharacterSpellsAttribute()
	{
		// Get all characters
		$characters = $this->characters->morph;

		if (count($characters) > 0) {
			$characters = $characters->filter(function ($character) {
				if (isset($character->spells) && $character->spells != null) return true;
			});
			$unapprovedSpells = $characters->spells->filter(function ($spell) {
				if ($spell->approvedFlag == 0) {
					return true;
				}
			});

			return $unapprovedSpells;
		}
		return array();
	}

	/**
	 * Get all unapproved characters
	 *
	 * @return array
	 */
	public function getUnApprovedCharactersAttribute()
	{
		// Get all characters
		$characters = $this->characters->morph;

		if (count($characters) > 0) {
			$unapprovedCharacters = $characters->filter(function ($character) {
				if ($character->checkStatus(array('DEAD', 'INACTIVE'))) return false;
				if (!$character->checkStatus('APPROVED')) return true;
			});

			return $unapprovedCharacters;
		}
		return array();
	}

	/**
	 * Get all in progress characters
	 *
	 * @return array
	 */
	public function getInProgressCharactersAttribute()
	{
		// Get all characters
		$characters = $this->characters->morph;

		if (count($characters) > 0) {
			$unapprovedCharacters = $characters->filter(function ($character) {
				if ($character->checkStatus('IN_PROGRESS')) return true;
			});

			return $unapprovedCharacters;
		}
		return array();
	}

	/********************************************************************
	 * Extra Methods
	 *******************************************************************/
	public function setStoryTellers($userIds)
	{
		$allSTs = Game_Storyteller::where('game_id', $this->id)->get();

		if ($allSTs->count() > 0) {
			foreach ($allSTs as $allST) {
				$allST->delete();
			}
		}

		foreach ($userIds as $userId) {
			$existingST = Game_Storyteller::where('game_id', $this->id)->where('user_id', $userId)->first();
			if ($existingST != null) {
				continue;
			}


			$gameST          = new Game_Storyteller;
			$gameST->user_id = $userId;
			$gameST->game_id = $this->id;

			$gameST->save();
		}
	}

	public function isStoryteller($userId)
	{
		$storyTeller = $this->storyTellers->filter(function ($storyTeller) use ($userId) {
			if ($storyTeller->user_id == $userId) {
				return true;
			}
		});

		if ($storyTeller->count() > 0) {
			return true;
		}

		return false;
	}
}