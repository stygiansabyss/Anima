<?php

class AdminController extends Core_AdminController {

    public function getIndex()
    {
        // Get the collapse values
        if (!Session::has('COLLAPSE_ADMIN_PERMISSIONS')) {
            Session::put('COLLAPSE_ADMIN_PERMISSIONS', $this->activeUser->getPreferenceValueByKeyName('COLLAPSE_ADMIN_PERMISSIONS'));
        }
        if (!Session::has('COLLAPSE_ADMIN_GENERAL')) {
            Session::put('COLLAPSE_ADMIN_GENERAL', $this->activeUser->getPreferenceValueByKeyName('COLLAPSE_ADMIN_GENERAL'));
        }
        if (!Session::has('COLLAPSE_ADMIN_TYPES')) {
            Session::put('COLLAPSE_ADMIN_TYPES', $this->activeUser->getPreferenceValueByKeyName('COLLAPSE_ADMIN_TYPES'));
        }

        LeftTab::
            addPanel()
                ->setId('ADMIN_PERMISSIONS')
                ->setTitle('Permissions')
                ->setBasePath('admin')
                ->addTab('Users',           'users')
                ->addTab('Role Users',      'role-users')
                ->addTab('Roles',           'roles')
                ->addTab('Action Roles',    'action-roles')
                ->addTab('Actions',         'actions')
                ->buildPanel()
            ->addPanel()
                ->setId('ADMIN_GENERAL')
                ->setTitle('General')
                ->setBasePath('admin')
                ->addTab('User Preferences',    'user-preferences')
                ->addTab('Theme',               'theme')
                ->addTab('Migrations',          'migrations')
                ->addTab('Seeds',               'seeds')
                ->addTab('App Configs',         'app-configs')
                ->addTab('SQL Tables',          'sql-tables')
                ->buildPanel()
            ->addPanel()
                ->setId('ADMIN_TYPES')
                ->setTitle('Class Types')
                ->setBasePath('admin')
                ->addTab('Message',         'message')
                ->addTab('Forum Category',  'forum-category')
                ->addTab('Forum Board',     'forum-board')
                ->addTab('Forum Post',      'forum-post')
                ->addTab('Forum Reply',     'forum-reply')
                ->addTab('Status',          'status')
                ->buildPanel()
            ->setCollapsable(true)
        ->make();
    }

    public function getStatus()
    {
        $statuses = Status::orderByNameAsc()->get();

        // Set up the one page crud
        Crud::setTitle('Status')
                 ->setSortProperty('name')
                 ->setDeleteLink('/admin/statusdelete/')
                 ->setDeleteProperty('id')
                 ->setResources($statuses);

        // Add the display columns
        Crud::addDisplayField('name')
                 ->addDisplayField('keyName');

        // Add the form fields
        Crud::addFormField('name', 'text')
                 ->addFormField('keyName', 'text')
                 ->addFormField('description', 'textarea');

        // Handle the view data
        Crud::make();
    }

    public function postStatus()
    {
        $this->skipView();
        // Set the input data
        $input = e_array(Input::all());

        if ($input != null) {
            // Get the object
            $status              = (isset($input['id']) && $input['id'] != null ? Status::find($input['id']) : new Status);
            $status->name        = $input['name'];
            $status->keyName     = $input['keyName'];
            $status->description = $input['description'];

            // Attempt to save the object
            $this->save($status);

            // Handle errors
            if ($this->errorCount() > 0) {
                Ajax::addErrors($this->getErrors());
            } else {
               Ajax::setStatus('success')->addData('resource', $status->toArray());
            }

            // Send the response
            return Ajax::sendResponse();
        }
    }

    public function getDeletestatus($statusId)
    {
        $this->skipView();

        $status = Status::find($statusId);
        $status->delete();

        $this->redirect('/admin#status', 'Status deleted.');
    }
}