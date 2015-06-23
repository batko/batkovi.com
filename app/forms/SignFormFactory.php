<?php

namespace App\Forms;

use Nette,
	Nette\Application\UI\Form,
	Nette\Security\User;


class SignFormFactory extends Nette\Object
{
	/** @var User */
	private $user;


	public function __construct(User $user)
	{
		$this->user = $user;
	}


	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form;

		$form->addPassword('password', 'Heslo:')
			->setRequired('Please enter your password.');

		$form->addCheckbox('remember', 'Keep me signed in');

		$form->addSubmit('send', 'Sign in');

		$form->onSuccess[] = array($this, 'formSucceeded');
		return $form;
	}


	public function formSucceeded($form, $values)
	{
	
			$this->user->setExpiration('60 minutes', TRUE);
		

		try {
			$this->user->login($values->password, $values->password);
		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}

}
