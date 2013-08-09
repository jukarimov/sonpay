<?php

require_once('locale.php');

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(

			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/*
	 * Set site locale language
	 */
	public function actionLocale()
	{
		$url = Yii::app()->request->url;
		$lang = split("/", $url);
		$lang =	$lang[count($lang)-1];
		Yii::log($lang, "warning", "locale");

		$app = Yii::app();
		$user = $app->user;

		$app->language = $lang;
		$app->user->setState('_lang', $lang);
		$cookie = new CHttpCookie('_lang', $lang);
		$cookie->expire = time() + (60 * 60 * 24 * 365);
		$app->request->cookies['_lang'] = $cookie;
		
		$this->redirect(Yii::app()->user->returnUrl);
	}

	/*
	 * Manage site admins
	 * */
	public function actionAdmins()
	{
		if (Yii::app()->user->isGuest) {
			// redirect user here after loggin successfully
			Yii::app()->user->returnUrl = $this->createUrl('site/admins');

			$loginUrl = $this->createUrl('site/login');
			$this->redirect($loginUrl);
			return;
		}

		$model = null;

		if (isset($_POST['AdminsForm'])) {
			$model = new AdminsForm();
			$model->attributes=$_POST['AdminsForm'];
			if ($model->validate()) {
				$action = $model->action;
				Yii::log("$action", "warning", "useract");
				if ($action == 'select') {
					$model = new AdminsForm('select');
				}
				else if ($action == 'delete') {
					$model = new AdminsForm('delete');
				}
				else if ($action == 'create') {
					$model = new AdminsForm('create');
				}
			}
		}

		if (!$model) $model = new AdminsForm('select');

		if(isset($_POST['AdminsForm'])) {

			$model->attributes=$_POST['AdminsForm'];

			if($model->validate())
			{
				$action = $model->action;
				$username =   $model->user_name;
				$password =   $model->password;
				$email    =   $model->email;
				Yii::log("$action", "warning", "UsersForm.action");
				Yii::log("$username", "warning", "UsersForm.username");

				$createparams = array(
					"username"=>$username,
				        "password"=>$password,
				        "email"=>$email
				);

				$aman = new AdminManager;

				if ($action === 'create') {
				  $aman->createAdmin($createparams);
				  Yii::app()->user->setFlash('admins', 'User created');
				}
				else if ($action === 'delete') {
				  $aman->deleteAdmin($username);
				  Yii::app()->user->setFlash('admins', 'User deleted');
				} else {
				  Yii::app()->user->setFlash('admins', 'Wrong action');
				}
			}
		}
		$this->render('admins',array('model'=>$model));
	}


	/*
	 * Admin settings page
	 * */
	public function actionSettings()
	{
		if (Yii::app()->user->isGuest) {
			// redirect user to messages after login
			Yii::app()->user->returnUrl = $this->createUrl('site/settings');

			$loginUrl = $this->createUrl('site/login');
			$this->redirect($loginUrl);
			return;
		}

		$model = new SettingsForm;
	
		if(isset($_POST['SettingsForm'])) {

			$model->attributes=$_POST['SettingsForm'];
			if($model->validate())
			{
				$password = $model->password;
				$newpassword = $model->new_password;
				$email = $model->email;

				if ($newpassword != '' || $email != '') {

				  if ($newpassword) {
				  	$model->updatePassword();
				  }
				  if ($email) {
				  	$model->updateEmail();
				  }

				  Yii::app()->user->setFlash('settings','Account updated.');
				}
				$this->refresh();
			}
		}
		$this->render('settings',array('model'=>$model));
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			Yii::log("ContactForm requested", "warning", "DEBUG");
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				Yii::log("ContactForm::TYPE", "warning", $model->message_type);
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);

				$msgman = new MessageManager();

				$msgman->messagePost(
					$model->name,
					$model->email,
					$model->subject,
					$model->body
				);

				Yii::app()->user->setFlash('contact',Yii::t('flash', 'thank_for_contact'));
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
		       	{
				$app = Yii::app();
				$user = $app->user;

				Yii::log($user->name, "warning", "login");

				$app->user->setState('_user', $user->name);
				$cookie = new CHttpCookie('_user', $user->name);
				$cookie->expire = time() + (60 * 60 * 24 * 365);
				$app->request->cookies['_user'] = $cookie;

				$this->redirect(Yii::app()->user->returnUrl);
			}
		}

		// are we in already?
		if (Yii::app()->user->isGuest === false) {
			// go home then
			$this->redirect($this->createUrl('site/index'));
		} else {
		// display the login form
			$this->render('login',array('model'=>$model));
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		$app = Yii::app();
		$cookie = new CHttpCookie('_user', null);
		$cookie->expire = time() - (60 * 60);
		$app->request->cookies['_user'] = $cookie;

		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionRecovery()
	{
		$model = new RecoveryForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='recovery-form')
		{
			Yii::log("RecoverForm posted ajax", "warning", "recovery");
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	
		if(isset($_POST['RecoveryForm'])) {
			Yii::log("RecoveryForm POSTED", "warning", "recover");
			$model->attributes=$_POST['RecoveryForm'];
			if($model->validate())
			{
				$email = $model->email;
				$repeat = $model->repeat;

				Yii::log($email, "warning", "RecoveryForm");
				Yii::log($repeat, "warning", "RecoveryForm");

				$model->setPassword();
				$password = $model->getPassword();
				$model->updatePassword();

				$subject='=?UTF-8?B?'.base64_encode('Recovering password').'?=';
				$headers="From: admin<admin@osonpay.tj>\r\n".
					"Reply-To: admin<admin@osonpay.tj>\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";


				$emailMessage = "Greetings!\r\n".
						"Please use this".
						" new generated for you password: '$password'\r\n".
						"You may want to change it after logging in.\r\n".
						"Contact site admininistration for more help.\r\n".
						"\r\nBest regards!\r\n".
						"Recovery service.\r\n";

				mail($email,"Recovering password",$emailMessage,$headers);
				Yii::log($email, "warning", "RecoveryForm:email");
				Yii::log($emailMessage, "warning", "RecoveryForm:emailMessage");
				Yii::log($headers, "warning", "RecoveryForm:headers");

				$flash= 'The recovery email has been sent.<br>'.
					'Please check your email (might be in spam) '.
					'and <a href="?r=site/login">login</a> back';
				Yii::app()->user->setFlash('recovery', $flash);
				$this->refresh();
			}
		}

		$this->render('recovery',array('model'=>$model));
	}

	public function actionMessages()
	{
		if (Yii::app()->user->isGuest) {
			// redirect user to messages after login
			Yii::app()->user->returnUrl = $this->createUrl('site/messages');

			$loginUrl = $this->createUrl('site/login');
			$this->redirect($loginUrl);

			//throw new CHttpException(404, 'The specified page cannot be found.');
		} else {
			$msgman = new MessageManager();
			$uemail = $msgman->getUserEmail(Yii::app()->user->name);

			if (isset($_POST['submit']) && isset($_POST['checkbox'])) {
				$checked = $_POST['checkbox'];
				$options = $_POST['msgopt'];
				Yii::log("$options", "warning", "chat");
				foreach($checked as $msgid) {
					Yii::log("$msgid", "warning", "chat");
					if ($options == 'read') {
						$msgman->messageMarkRead($msgid);
					}
					else if ($options == 'delete') {
						$msgman->messageDelete($msgid);
					}
				}
			}
			$this->render('messages');
		}
	}
}
