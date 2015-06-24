<?php

namespace App\Presenters;

use Nette,
    App\Model;

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter {

    /** @var Nette\Mail\IMailer */
    private $mailer;

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

    protected function createComponentFormContact() {
        $form = new Nette\Application\UI\Form();
        $form->addText("name");
        $form->addText("email");
        $form->addText("phone");
        $form->addText("text");

        $form->addSubmit("submit");

        $form->onSuccess[] = $this->formContactSubmitted;

        return $form;
    }

    public function formContactSubmitted(Nette\Application\UI\Form $form, $values) {
        dump($form->getValues());

        $latte = new \Latte\Engine;
        $params = array(
            'text' => $fd->text,
        );

        $mail = new Nette\Mail\Message;
        $mail->setFrom($fd->name . " <" . $fd->email . ">")
                ->addTo('pavel@batko.cz')
                ->setSubject('Svatba ' . $fd->phone)
                ->setHtmlBody($latte->renderToString('../app/presenters/template/email.latte', $params));

        //  $this->mailer->send($mail);
    }

}
