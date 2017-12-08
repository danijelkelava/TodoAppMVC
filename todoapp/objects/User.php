<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class User 
{

	private $db;
	private $table_name = "korisnik";

	private $ime;
	private $prezime;
	private $email;
	private $lozinka;

	public function __construct($db){
		$this->db = $db;
	}

	public function setIme($ime){
		$this->ime = $ime;
	}

	public function setPrezime($prezime){
		$this->prezime = $prezime;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function setLozinka($lozinka){
		$this->lozinka = $lozinka;
	}

	public function register(){

		//$password = password_hash($this->lozinka, PASSWORD_DEFAULT);
		$token = bin2hex(mt_rand(10,40000));

		try {
			$q = "SELECT * FROM " . $this->table_name . " WHERE email=:email";
			$result = $this->db->prepare($q);
			$this->email = htmlspecialchars(strip_tags($this->email));
			$result->bindValue(':email', $this->email);
			$result->execute();
		} catch (PDOException $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}

		if ($result->fetchColumn() > 0) {
			//echo "Email exists";
			$_SESSION['error'] = "Email already exists!";
			return;
		} else {
			$q = "INSERT INTO " . $this->table_name . " SET ime=:ime, prezime=:prezime, email=:email, lozinka=:lozinka, token=:token, active=0, datum_registracije=now()";
			$result = $this->db->prepare($q);

			$this->ime = htmlspecialchars(strip_tags($this->ime), ENT_QUOTES, 'UTF-8');
			$this->prezime = htmlspecialchars(strip_tags($this->prezime), ENT_QUOTES, 'UTF-8');
			$this->email = htmlspecialchars(strip_tags($this->email), ENT_QUOTES, 'UTF-8');
            $this->lozinka = htmlspecialchars(strip_tags($this->lozinka), ENT_QUOTES, 'UTF-8');
            $password = password_hash($this->lozinka, PASSWORD_DEFAULT);
            
			$result->bindValue(':ime', $this->ime);
			$result->bindValue(':prezime', $this->prezime);
			$result->bindValue(':email', $this->email);
			$result->bindValue(':lozinka', $password);
			$result->bindValue(':token', $token);
			
			$run = $result->execute();

			if ($run) {
				$user = $this->getUser($this->email);
				$_SESSION['id'] = $user['id'];
				$this->sendMail($user['email'], $user['id'], $token);
				header("Location:http://" . $_SERVER['HTTP_HOST'] . "/todoapp/activation");
			}else{
				$_SESSION['error'] = "Error!";
			}
		}
	}

	private function getUser($email){
		$q = "SELECT * FROM " . $this->table_name . " WHERE email='$email'";
		$result = $this->db->query($q);
		$row = $result->fetch();
		return $row;
	}

	public function sendMail($email, $id, $token){

	$mail = new PHPMailer(true);                           // Passing `true` enables exceptions
	try {
    //Server settings
	$mail->SMTPOptions = array(
	    'ssl' => array(
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
	    )
	);
    $mail->SMTPDebug;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = '';                 // SMTP username
    $mail->Password = '';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $message = '<div>';
    $message .= '<h6>Your activation code</h6>';
    $message .= '<h3>'.$token.'</h3>';
    $message .= '<h1>OR</h1>';
    // get varijabla active u url-u activate.php?active kojom cemo dohvatiti $token
    $message .= '<h3>' . $_SERVER['HTTP_HOST'] . '/todoapp/activation?active='.$token.'&id='.$id.'</h3>';
    $message .= '</div>';

	$mail->Body = $message;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
    $mail->addAddress($email, 'Novi korisnik');
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
	}

    public function activate($id, $tk){
    	//$this->updateLoginTime($id);
    	try {
    		$q = "UPDATE " . $this->table_name . " SET active=1 WHERE id=:id AND token=:token";
    	    $result = $this->db->prepare($q);
    	    $result->bindValue(':id', $id);
    	    $result->bindValue(':token', $tk);
    	    $run = $result->execute();	
    		} catch (PDOException $e) {
    			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
    			return;
    		}	
    	
    	if ($run) {
    		$user = $this->getUserById($id);
			$_SESSION['user'] = $user;
			//$_SESSION['user'] = $this->getUserById($id); npr $_SESSION['user']['id']
			header("Location: http://" . $_SERVER['HTTP_HOST'] . "/todoapp");
    	}else{
    		$_SESSION['error'] = "Wrong activation code.";
    		return;
    	}
    }

    private function getUserById($id){
		$q = "SELECT * FROM " . $this->table_name . " WHERE id='$id'";
		$result = $this->db->query($q);
		$row = $result->fetch();
		return $row;
	}

	public function login(){
        
        try {
			$q = "SELECT * FROM " . $this->table_name . " WHERE email=:email AND active=1";
			$result = $this->db->prepare($q);
			$this->email = htmlspecialchars(strip_tags($this->email), ENT_QUOTES, 'UTF-8');
			$this->lozinka = htmlspecialchars(strip_tags($this->lozinka), ENT_QUOTES, 'UTF-8');
			$result->bindValue(':email', $this->email);
			$result->execute();
		} catch (PDOException $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}


        if (isset($result)) {
	
        	$row = $result->fetch();

            $this->updateLoginTime($row['id']);	

        	$q = "SELECT * FROM " . $this->table_name . " WHERE id='" . $row['id'] . "'";
            $result = $this->db->query($q);
            $row = $result->fetch();

            if ($this->email != $row['email']) {
			$_SESSION['error'] = "Email is not valid!";
			header("Location: http://" . $_SERVER['HTTP_HOST'] . "/todoapp/login");
			return;
		    }

            if (password_verify($this->lozinka, $row['lozinka'])) {				
				$_SESSION['user'] = $row;
			    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/todoapp");
			}else{
			    $_SESSION['error'] = "Password is not valid.";
			    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/todoapp/login");
			    return;	
			}

				
        } 				
	}

	private function updateLoginTime($id){

		try {
			$q = "UPDATE " . $this->table_name . " SET zadnji_login=Now() WHERE id='$id'";
		    $result = $this->db->query($q);
		} catch (PDOException $e) {
			$_SESSION['error'] = "Database connection error: " . $e->getMessage();
            return;
		}
		
	}

}