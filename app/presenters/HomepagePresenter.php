<?php

namespace App\Presenters;

use Nette,
    App\Model;

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter {

    /** @var Nette\Mail\IMailer @inject */
    public $mailer;

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

    protected function createComponentContactForm() {
        $form = new Nette\Application\UI\Form();
        $form->addText("name");
        $form->addText("email")->addRule($form::EMAIL, "zadej email ve správném tvaru");
        $form->addText("phone");
        $form->addTextArea("text");

        $form->addSubmit("submit");

        $form->onSuccess[] = $this->formContactSubmitted;
//
//        $form->setValues(
//                [
//                    "name" => "asdasd",
//                    "email" => "pavel@havel.cz",
//                    "phone" => "342344333",
//                    "text" => "texcyxcyxcyxcyxcy"
//                ]
//        );


        return $form;
    }

    public function formContactSubmitted(Nette\Application\UI\Form $form) {
        $fd = $form->getValues();

        $latte = new \Latte\Engine;
        $params = array(
            'text' => $fd->text,
        );

        $mail = new Nette\Mail\Message;
        $mail->setFrom($fd->email)
                ->addTo('svatba@batkovi.com')
                ->setSubject('Svatba ' . $fd->phone)
                ->setHtmlBody($latte->renderToString('../app/presenters/templates/mail.latte', $params));

        $this->mailer->send($mail);
        $this->flashMessage("Email byl odeslán. Ozveme se :-)", "success");
        $this->redirect("this");
    }

}
