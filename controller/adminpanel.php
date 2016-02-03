<?php

require_once 'controller.php';

// Controller for administration panel:
class AdminPanel extends Controller
{
    protected function __construct()
    {
        parent::__construct();
        
        if (isset($_POST['logout'])) {
            $this->logOut();
        }
        
        if ((isset($_POST['activate'])) && (isset($_POST['poll']))) {
            $this->activatePoll(htmlspecialchars($_POST['poll']));
            $this->showMessage('Poll ' . htmlspecialchars($_POST['poll']) . ' is activated');
        }
        
        if ((isset($_POST['disable'])) && (isset($_POST['poll']))) {
            $this->disablePoll(htmlspecialchars($_POST['poll']));
            $this->showMessage('Poll ' . htmlspecialchars($_POST['poll']) . ' is disabled');
        }
        
        if ((isset($_POST['add'])) && (isset($_POST['poll']))) {
            //$this->addPoll(htmlspecialchars($_POST['poll']));
            $this->showMessage('New poll is added');
        }
        
        if ((isset($_POST['delete'])) && (isset($_POST['poll']))) {
            //$this->detelePoll(htmlspecialchars($_POST['poll']));
            $this->showMessage('Poll ' . htmlspecialchars($_POST['poll']) . ' is deleted');
        }
        
        $poll['date'] = date("H:i:s d.m.Y");
        $poll['list'] = array_unique($this->model->showPolls(), SORT_REGULAR);
        
        $this->generateView('adminpanel', $poll);
    }
    
    /**
     * Logout from administration panel
     */
    protected function logOut()
    {
        session_start();
        session_destroy();
        header("Location: http://poll/");
        exit;
    }
    
    protected function activatePoll($id)
    {
        $this->model->activatePollInDB($id);
    }
    
    protected function disablePoll($id)
    {
        $this->model->disablePollInDB($id);
    }
    
    protected function addPoll()
    {
        $this->model->addPollToDB();
    }
    
    protected function deletePoll($id)
    {
        $this->model->deletePollFromDB($id);
    }
}
