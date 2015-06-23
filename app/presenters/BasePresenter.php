<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    
    
    protected function startup() {
        parent::startup();
      
        if(!$this->user->isLoggedIn() && ($this->name != "Sign")){
            $this->redirect("Sign:in");
        }
    }
}
