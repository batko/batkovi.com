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
        
        $this->template->photos = \Nette\Utils\Finder::findFiles('*.jpg')->from("data/photo/thumb/");
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
    protected function createComponentFormPhoto() {
        $form = new Nette\Application\UI\Form();
           $form->addMultiUpload('img', 'Soubor:')
                //->addRule(Form::MIME_TYPE, 'Přílohou musí být obrázek formátu .jpg .', 'image/jpeg') ;
                ->addRule($form::IMAGE, 'Soubor musí být JPEG, PNG nebo GIF.');
        $form->addSubmit("submit");

        $form->onSuccess[] = $this->formPhotoSubmitted;



        return $form;
    }

    public function formPhotoSubmitted(Nette\Application\UI\Form $form) {
        $fd = $form->getValues();
        
        foreach ($fd->img as $img) {
            $name = date("Y_m_d_H_i_s_"). Nette\Utils\Random::generate(10);
          $img = \Nette\Utils\Image::fromFile($img);
            $img->save("./data/photo/original/".  $name.".jpg");
            $img->resize(200, 200);
            create_square_image("./data/photo/original/".  $name.".jpg","./data/photo/thumb/".  $name.".jpg",200);
        //    $img->save("./data/photo/thumb/".  $name.".jpg");
             
        }
        $this->flashMessage("Moc děkujem za fotky :-)", "success");
        $this->redirect("this");
    }

}


if(!function_exists("create_square_image")){
	function create_square_image($original_file, $destination_file=NULL, $square_size = 96){
		
//		if(isset($destination_file) and $destination_file!=NULL){
//			if(!is_writable($destination_file)){
//				echo '<p style="color:#FF0000">Oops, the destination path is not writable. Make that file or its parent folder wirtable.</p>'; 
//			}
//		}
		
		// get width and height of original image
		$imagedata = getimagesize($original_file);
		$original_width = $imagedata[0];	
		$original_height = $imagedata[1];
		
		if($original_width > $original_height){
			$new_height = $square_size;
			$new_width = $new_height*($original_width/$original_height);
		}
		if($original_height > $original_width){
			$new_width = $square_size;
			$new_height = $new_width*($original_height/$original_width);
		}
		if($original_height == $original_width){
			$new_width = $square_size;
			$new_height = $square_size;
		}
		
		$new_width = round($new_width);
		$new_height = round($new_height);
		
		// load the image
		if(substr_count(strtolower($original_file), ".jpg") or substr_count(strtolower($original_file), ".jpeg")){
			$original_image = imagecreatefromjpeg($original_file);
		}
		if(substr_count(strtolower($original_file), ".gif")){
			$original_image = imagecreatefromgif($original_file);
		}
		if(substr_count(strtolower($original_file), ".png")){
			$original_image = imagecreatefrompng($original_file);
		}
		
		$smaller_image = imagecreatetruecolor($new_width, $new_height);
		$square_image = imagecreatetruecolor($square_size, $square_size);
		
		imagecopyresampled($smaller_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
		
		if($new_width>$new_height){
			$difference = $new_width-$new_height;
			$half_difference =  round($difference/2);
			imagecopyresampled($square_image, $smaller_image, 0-$half_difference+1, 0, 0, 0, $square_size+$difference, $square_size, $new_width, $new_height);
		}
		if($new_height>$new_width){
			$difference = $new_height-$new_width;
			$half_difference =  round($difference/2);
			imagecopyresampled($square_image, $smaller_image, 0, 0-$half_difference+1, 0, 0, $square_size, $square_size+$difference, $new_width, $new_height);
		}
		if($new_height == $new_width){
			imagecopyresampled($square_image, $smaller_image, 0, 0, 0, 0, $square_size, $square_size, $new_width, $new_height);
		}
		

		// if no destination file was given then display a png		
		if(!$destination_file){
			imagepng($square_image,NULL,9);
		}
		
		// save the smaller image FILE if destination file given
		if(substr_count(strtolower($destination_file), ".jpg")){
			imagejpeg($square_image,$destination_file,100);
		}
		if(substr_count(strtolower($destination_file), ".gif")){
			imagegif($square_image,$destination_file);
		}
		if(substr_count(strtolower($destination_file), ".png")){
			imagepng($square_image,$destination_file,9);
		}

		imagedestroy($original_image);
		imagedestroy($smaller_image);
		imagedestroy($square_image);

	}
}
