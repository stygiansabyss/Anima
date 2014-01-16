<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MigrationCommand extends Helper_Game {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'oldsite:convert';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Convert the new.sv.com forums and messages to L4.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// see if we are moving a specifc table
		$table = $this->argument('table');

		if ($table != null) {
			$this->{$table}();
		} else {
			// Get our options
			$all        = $this->option('all');
			$users      = $this->option('users');
			$forums     = $this->option('forums');
			$messages   = $this->option('messages');
			$gameParts  = $this->option('gameParts');
			$characters = $this->option('characters');

			if ($all == 1 || $users == 1) {
				$this->moveUsersTable();
			}
			if ($all == 1 || $gameParts == 1) {
				$this->moveGameParts();
			}
			if ($all == 1 || $characters == 1) {
				$this->moveCharacters();
			}
			if ($all == 1 || $gameParts == 1) {
				$this->moveGamePartsAfterCharacters();
			}
			if ($all == 1 || $forums == 1) {
				$this->moveForums();
			}
			if ($all == 1 || $messages == 1) {
				$this->moveMessages();
			}
		}

		$this->info('Finished with conversion');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('table', InputArgument::OPTIONAL, 'Specify a specific table to move over. (Use tha name of the method to run.)'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('users', 'users', InputOption::VALUE_NONE, 'Moves the users over.'),
			array('forums', 'forums', InputOption::VALUE_NONE, 'Moves all forum tables over. (categories, boards, posts, replies and all satellite tables)'),
			array('messages', 'messages', InputOption::VALUE_NONE, 'Moves all message tables over.  (messages, folders, inboxes)'),
			array('characters', 'characters', InputOption::VALUE_NONE, 'Moves all character tables over.  (characters,details)'),
			array('gameParts', 'gameParts', InputOption::VALUE_NONE, 'Moves all game tables over.  (games,attributes)'),
			array('all', 'all', InputOption::VALUE_NONE, 'Moves every table possible over.'),
		);
	}

	protected function moveGameParts()
	{
		$this->moveGamesTable();
		$this->moveGameStoryTellers();
		$this->moveAttributesTable();
		$this->moveAttributeModifiersTable();
		$this->moveAppearancesTable();
		$this->moveSecondaryAttributesTable();
		$this->moveSkillsTable();
		$this->moveStatsTable();
		$this->moveTraitsTable();
		$this->moveClassesTable();
		$this->moveGameEventsTable();
		$this->moveGameItemRarities();
		$this->moveGameItems();
		$this->moveGameQuests();
		$this->moveGameQuestItems();
		$this->moveMagicTypesTable();
		$this->moveMagicTreesTable();
		$this->moveMagicSpellsTable();
	}

	protected function moveCharacters()
	{
		$this->moveCharactersTable();
		$this->moveCharacterDetailsTable();
		$this->moveCharacterClassesTable();
		$this->moveCharacterAppearancesTable();
		$this->moveCharacterAttributesTable();
		$this->moveCharacterEventsTable();
		$this->moveCharacterExperienceHistoryTable();
		$this->moveCharacterNotesTable();
		$this->moveCharacterQuestsTable();
		$this->moveCharacterSecondaryAttributesTable();
		$this->moveCharacterSkillsTable();
		$this->moveCharacterSpellsTable();
		$this->moveCharacterStatsTable();
		$this->moveCharacterTraitsTable();
	}

	protected function moveGamePartsAfterCharacters()
	{
		$this->moveGameNpcItemsTable();
	}

	protected function moveForums()
	{
		$this->moveForumCategoriestable();
		$this->moveForumBoardstable();
		$this->moveForumPoststable();
		$this->moveForumRepliestable();
		$this->moveForumPostEditsTable();
		$this->moveForumReplyEditsTable();
		$this->moveForumPostStatusesTable();
		$this->moveForumPostViewsTable();
	}

	protected function moveMessages()
	{
		$this->createUserInboxes();
		$this->moveMessagesFoldersTable();
		$this->setMessageTypes();
		$this->moveMessagesTable();
		$this->moveMessageDeletes();
		$this->moveMessagesToInboxes();
	}

}