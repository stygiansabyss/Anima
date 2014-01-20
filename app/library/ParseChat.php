<?php namespace Library;

use BBCode;
use HTML;

class ParseChat {

	public $character;

	public $message;

	public function parse($message, $messageOnly = false)
	{
		$this->message = $message;
		$parsedMessage = BBCode::parse($message->message);
		$parsedMessage = $this->parseCharacterStats($message, $parsedMessage);

		$result = $this->setUpMessageArray($message, $parsedMessage, $messageOnly);

		return $result;
	}

	public function setUpMessageArray($message, $parsedMessage, $messageOnly)
	{
		$newMessage = array();

		// Switch the link based on the type of poster
		if (!is_null($message->morph_id)) {
			$link = HTML::link(
				'/character/sheet/'. $message->morph_id,
				$message->morph->name, 
				array('style' => 'color:'. $message->morph->color, 'target' => '_blank')
			);
		} else {
			$link = HTML::link(
				'/profile/'. $message->user->id,
				$message->user->username,
				array('target' => '_blank')
			);
		}

		$newMessage['text'] = $this->setText($message, $parsedMessage, $link);

		// If we only want the text, send the message now
		if ($messageOnly) return $newMessage;

		$newMessage['room']     = $message->chat_room_id;
		$newMessage['username'] = $message->user->username;
		$newMessage['userId']   = $message->user->uniqueId;

		return $newMessage;
	}

	public function setText($message, $parsedMessage, $link)
	{
		return '
			<small class="muted">
				('. $message->created_at.')
			</small>'.
			$link .': '. $parsedMessage.'
			<br />
		';
	}

	public function parseCharacterStats($message, $parsedMessage)
	{
		if (!is_null($message->morph_id)) {
			$this->character = $message->morph;
			$rootClass       = getRootClass($this->character);

			// Entities have no stats
			if ($rootClass != 'Entity') {

				// Handle the attributes
				$attributes = \Attribute::all();
				if (count($attributes) > 0) {
					$parsedMessage = $this->parseAttributes($attributes, $parsedMessage);
				}

				// Handle the skills
				$skills = \Skill::all();
				if (count($skills) > 0) {
					$parsedMessage = $this->parseSkills($skills, $parsedMessage);
				}

				// Handle secondary attributes
				$secondaryAttributes = \Attribute_Secondary::all();
				if (count($secondaryAttributes) > 0) {
					$parsedMessage = $this->parseSecondaryAttributes($secondaryAttributes, $parsedMessage);
				}

				// Handle spells
				$spells = \Character_Spell::where('morph_id', $this->character->id)->where('morph_type', $rootClass)->get();
				if (count($spells) > 0) {
					$parsedMessage = $this->parseSpells($spells, $parsedMessage);
				}
			}
		}

		return $parsedMessage;
	}

	protected function getStat($type, $id)
	{
		return $this->character->getValue($type, $id);
	}

	protected function statReplace($target, $replaceWith, $parsedMessage, $class)
	{
		return str_ireplace($target, '<small class="text-'. $class .'"><b>'. $replaceWith .'</b></small>', $parsedMessage);
	}

	protected function parseAttributes($attributes, $parsedMessage)
	{
		foreach ($attributes as $attribute) {
			$target        = '/attribute '. $attribute->name;
			$replaceWith   = '['. $attribute->name .':'. $this->getStat('AttributeMod', $attribute->id) .']';
			$parsedMessage = $this->statReplace($target, $replaceWith, $parsedMessage, 'warning');
		}

		return $parsedMessage;
	}

	protected function parseSkills($skills, $parsedMessage)
	{
		foreach ($skills as $skill) {
			$target        = '/'. $skill->name;
			$replaceWith   = '['. $skill->name .':'. (int)$this->getStat('Skill', $skill->id) .' ';
			$replaceWith  .= $skill->attribute->name .':'. $this->getStat('Attribute', $skill->attribute_id) .']';
			$parsedMessage = $this->statReplace($target, $replaceWith, $parsedMessage, 'success');
		}

		return $parsedMessage;
	}

	protected function parseSecondaryAttributes($secondaryAttributes, $parsedMessage)
	{
		foreach ($secondaryAttributes as $attribute) {
			$target        = '/'. $attribute->name;
			$replaceWith   = '['. $attribute->name .':'. (int)$this->getStat('SecondaryAttribute', $attribute->id) .' ';
			$replaceWith  .= $attribute->attribute->name .':'. $this->getStat('Attribute', $attribute->attribute_id) .']';
			$parsedMessage = $this->statReplace($target, $replaceWith, $parsedMessage, 'info');
		}

		return $parsedMessage;
	}

	protected function parseSpells($spells, $parsedMessage)
	{
		foreach ($spells as $spell) {
			$target        = '/spell '. $spell->spell->name;
			$replaceWith   = '['. $spell->spell->name .': Level('. $spell->spell->level .'): Cost('. $spell->spell->useCost .') ';
			$replaceWith  .= 'Attribute: '. $spell->spell->attribute->name .' ('. (int)$this->getStat('Attribute', $spell->spell->attribute_id) .')]';
			$parsedMessage = $this->statReplace($target, $replaceWith, $parsedMessage, 'primary');
		}

		return $parsedMessage;
	}
}