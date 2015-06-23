<?php

namespace App\Presenters;

use Nette,
    App\Model;

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter {

    public function renderDefault() {
        $this->template->anyVariable = 'any value';
    }

    public function renderContact() {
        $this->template->anyVariable = 'any value';
    }

    public function renderFaq() {
        $this->template->anyVariable = 'any value';
    }

    public function renderPhoto() {
        $this->template->anyVariable = 'any value';
    }
      public function renderLocation() {
        $this->template->anyVariable = 'any value';
    }

}
