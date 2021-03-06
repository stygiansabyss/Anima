<?php

class HomeController extends Core_HomeController {

    public function getIndex()
    {
        $developer = $this->hasPermission('DEVELOPER');

        if ($developer) {
            $this->addSubMenu('Add News', 'news/add');
        }

        $newsItems = Forum_Post::with('author')->where('frontPageFlag', 1)->orderBy('created_at', 'DESC')->get();

        $this->setViewData('newsItems', $newsItems);
        $this->setViewData('developer', $developer);
    }

    public function getHelp()
    {
        LeftTab::
            addPanel()
                ->setTitle('Site Help')
                ->setBasePath('/')
                ->addTab('Character Creation', 'character-creation')
                ->addTab('Reporting problems', 'reporting-problems')
                ->buildPanel()
        ->make();
    }

    public function getCharacterCreation() {}

    public function getReportingProblems()
    {
        $users = User::orderByNameAsc()->get();

        $admins = $users->filter(function ($user) {
            if ($user->is('SITE_ADMIN')) return true;
        });

        $gameMasters = $users->filter(function ($user) {
            if ($user->is('GAME_MASTER') || $user->is('GAME_STORYTELLER')) return true;
        });

        $this->setViewData('admins', $admins);
        $this->setViewData('gameMasters', $gameMasters);
    }

    public function getTest()
    {
        $this->skipView();

        Syntax\Core\Support\Facades\Support::create('4TIa40HLWA')
                                           ->pushToGithub('stygiansabyss', 'Anima', true, 'Enhancement', 1, 'Add more chat color options.');

        ppd(Syntax\Core\Support\Facades\Support::get());

        die;
    }

    public function getDbSeeder()
    {
        $this->skipView();

        $databaseName = Config::get('database.connections')[Config::get('database.default')]['database'];

        $tables = new Utility_Collection(
            DB::select(
                DB::raw('
                    SELECT table_name, engine
                    FROM information_schema.tables
                    WHERE table_type = \'BASE TABLE\'
                        AND table_schema=\''. $databaseName .'\'
                    ORDER BY table_name ASC'
                )
            )
        );
        $tables = $tables->table_name;

        foreach ($tables as $table) {
            ppd($table);
        }

        ppd($tables);
    }
}