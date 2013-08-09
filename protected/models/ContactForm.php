<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $message_type;
	public $subject;
	public $body;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name, email, subject, body, verifyCode', 'required',
				'message'=>'{attribute} '.Yii::t('flash','isempty')
			),
			array('message_type', 'required',
				'message'=>'{attribute} '.Yii::t('flash','notselected')
			),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'verifyCode' => Yii::t('pages', 'contactForm.verifyCode'),
			'name' => Yii::t('pages', 'contactForm.name'),
			'email' => Yii::t('pages', 'contactForm.email'),
			'subject' => Yii::t('pages', 'contactForm.subject'),
			'body' => Yii::t('pages', 'contactForm.body'),
			'message_type' => Yii::t('pages', 'contactForm.type'),
		);
	}
}
