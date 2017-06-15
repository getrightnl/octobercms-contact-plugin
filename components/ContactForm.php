<?php

namespace GetRight\Contact\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Validator;
use October\Rain\Exception\ValidationException;
use GetRight\Contact\Models\Settings;
use System\Models\MailSetting;
use Illuminate\Support\Facades\Mail;

/**
 * Class ContactForm
 * @package GetRight\Contact\Components
 */
class ContactForm extends ComponentBase
{
    /**
     * App configs.
     *
     * @var $config
     */
    private $config;

    /**
     * @var $email
     */
    private $email;

    /**
     * @var $sender_name
     */
    private $sender_name;

    /**
     * TODO: make this dynamic from settings. So you can build own form.
     *
     * @var array $validationRules
     */
    private $validationRules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'phone' => 'string',
        'body' => 'required|string'
    ];

    /**
     * Define component details.
     *
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'ContactForm Component',
            'description' => 'Creates contactform'
        ];
    }

    /**
     * Define properties of component.
     *
     * @return array
     */
    public function defineProperties()
    {
        return [];
    }

    public function onRun() {
        $pathToLess = plugins_path('getright/contact/assets/less');
        $this->email = MailSetting::get('sender_email');
        $this->sender_name = MailSetting::get('sender_name');

        $this->addCss(["$pathToLess/style.less"]);
    }

    /**
     * Ajax call for form.
     */
    public function onSubmitForm()
    {

        $this->validateInput(post());

        Mail::send('getright.contact::emails.message', post(), function($message)
        {
           $message->replyTo(post('email'), post('name'))
                   ->to(MailSetting::get('sender_email'), MailSetting::get('sender_name'));

        });

        $this->page['confirmation'] = Settings::get('confirmation_text');
    }

    /**
     * Validate input.
     *
     * @param $input
     */
    private function validateInput($input)
    {
        $validator = Validator::make($input, $this->validationRules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
