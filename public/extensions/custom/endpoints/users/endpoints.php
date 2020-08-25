<?php

use Directus\Application\Http\Request;
use Directus\Application\Http\Response;

return [
    'email_verification' => [
        'method' => 'POST',
        'handler' => function (Request $request, Response $response) {

            $body = $request->getParsedBody();

            $container = \Directus\Application\Application::getInstance()->getContainer();
            $dbConnection = $container->get('database');
            $tableGateway = new \Zend\Db\TableGateway\TableGateway('directus_users', $dbConnection);
            
            $updated = $tableGateway->update(
            [
                'is_email_verified' => 1,
                'status' => 'active'
            ],
            [
                'email' => $body['email'],
                'email_verification_code' => $body['email_verification_code']
            ]);
            
            if(!$updated){
                return $response->withJson([
                    'message' => 'Failed or already verified'
                ], 400);
            }
            return $response->withJson([
                'message' => 'Success'
            ], 200);
        }
    ],
];
