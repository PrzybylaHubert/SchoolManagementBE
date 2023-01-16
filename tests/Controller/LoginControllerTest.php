<?php

namespace App\Tests\Controller;

use App\Utility\ErrorList;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    private const ACTIVE_EMAIL = 'active@student.com';
    private const INACTIVE_EMAIL = 'inactive@student.com';
    private const PASSWORD = 'test';

    public function loginData(): array
    {
        $invalidCredentials = 'Invalid credentials.';
        $keyNotProvided = 'The key "%s" must be provided.';
        $invalidType = 'The key "%s" must be a string.';
        return [
            'emptyInput' => [
                [],
                [
                    'exception' => [
                        'message' => ErrorList::INVALID_JSON,
                        'code' => 400,
                    ],
                ],
            ],
            'invalidUsernameKey' => [
                [
                    'usernam' => '',
                    'password' => '',
                ],
                [
                    'exception' => [
                        'message' => sprintf($keyNotProvided, 'username'),
                        'code' => 400,
                    ],
                ],
            ],
            'invalidPasswordKey' => [
                [
                    'username' => '',
                    'pasword' => '',
                ],
                [
                    'exception' => [
                        'message' => sprintf($keyNotProvided, 'password'),
                        'code' => 400,
                    ],
                ],
            ],
            'emptyInput' => [
                [
                    'username' => '',
                    'password' => '',
                ],
                [
                    'error' => $invalidCredentials,
                ],
            ],
            'nullUsername' => [
                [
                    'username' => null,
                    'password' => 'test',
                ],
                [
                    'exception' => [
                        'message' => sprintf($invalidType, 'username'),
                        'code' => 400,
                    ],
                ],
            ],
            'integerPassword' => [
                [
                    'username' => static::ACTIVE_EMAIL,
                    'password' => 123,
                ],
                [
                    'exception' => [
                        'message' => sprintf($invalidType, 'password'),
                        'code' => 400,
                    ],
                ],
            ],
            'inactiveUser' => [
                [
                    'username' => static::INACTIVE_EMAIL,
                    'password' => static::PASSWORD,
                ],
                [
                    'error' => ErrorList::USER_INACTIVE
                ],
            ],
            'invalidPassword' => [
                [
                    'username' => static::ACTIVE_EMAIL,
                    'password' => 'tes',
                ],
                [
                    'error' => ErrorList::INVALID_CREDENTIALS
                ],
            ],
            'loginSuccess' => [
                [
                    'username' => static::ACTIVE_EMAIL,
                    'password' => static::PASSWORD,
                ],
                [
                    'response' => static::ACTIVE_EMAIL
                ]
            ]
        ];
    }

    /**
     * @dataProvider loginData
     */
    public function testLogin($inputData, $expectedData): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/login', $inputData);
        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);
        $this->assertEqualsCanonicalizing($expectedData, $responseData);
    }

    public function testLogout(): void
    {
        $client = static::createClient();
        
        $client->jsonRequest('GET', '/api/logout');
        $this->assertResponseIsSuccessful();
    }
}
