<?php

namespace Directus\Custom\Hooks\Users;

use Directus\Hook\HookInterface;
use Directus\Hook\Payload;
use Directus\Services\MailService;

class BeforeInsertUsers implements HookInterface
{
    /**
     * @param Payload $payload
     *
     * @return Payload
     */
    public function handle($payload = null)
    {
        $emailVerificationCode = substr(md5(uniqid(rand(), true)), 8, 8);
        $payload->set('email_verification_code', $emailVerificationCode);

        $container = \Directus\Application\Application::getInstance()->getContainer();
        $mailService = new MailService($container);
        $mailService->send([
            'type' => 'HTML',
            'subject' => 'Glee email verification',
            'body' => "Your verification Code is: <br>$emailVerificationCode",
            'to' => $payload['email'],
            'use_default_email' => true,
            'data' => [],
        ]);

        return $payload;
    }
}
