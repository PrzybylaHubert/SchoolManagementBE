<?php

namespace App\Tests\Controller;

use App\Utility\ErrorList;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PasswordControllerTest extends WebTestCase
{
    private const ACTIVE_EMAIL = 'active@student.com';
    private const INACTIVE_EMAIL = 'inactive@student.com';
    private const VALID_TOKEN = '8ffe496b573b2ac202f5ce2b8412104737c79fbff6efa707023dab52d406a2152e793c8860c97670';
    private const VALID_PASSWORD = 'testtest';

    public function resetRequestJsonData(): array
    {
        $linkEmpty = 'Field link cannot be empty.';
        $emailEmpty = 'Field email cannot be empty.';
        $emailNotValid = 'Field email not valid.';
        return [
            'link key invalid' => [
                [
                    'email' => static::INACTIVE_EMAIL,
                    'lin' => 'test',
                ],
                [
                    'exception' => [
                        'message' => $linkEmpty,
                        'code' => 400,
                    ],
                ],
            ],
            'link key empty' => [
                [
                    'email' => static::INACTIVE_EMAIL,
                    'link' => '',
                ],
                [
                    'exception' => [
                        'message' => $linkEmpty,
                        'code' => 400,
                    ],
                ],
            ],
            'email key empty' => [
                [
                    'email' => '',
                    'link' => 'test',
                ],
                [
                    'exception' => [
                        'message' => $emailEmpty,
                        'code' => 400,
                    ],
                ],
            ],
            'email key invalid' => [
                [
                    'emal' => static::INACTIVE_EMAIL,
                    'link' => 'test',
                ],
                [
                    'exception' => [
                        'message' => $emailEmpty,
                        'code' => 400,
                    ],
                ],
            ],
            'email key integer' => [
                [
                    'email' => 123,
                    'link' => 'test',
                ],
                [
                    'exception' => [
                        'message' => $emailNotValid,
                        'code' => 400,
                    ],
                ],
            ],
            'email key not email' => [
                [
                    'email' => "123@test",
                    'link' => 'test',
                ],
                [
                    'exception' => [
                        'message' => $emailNotValid,
                        'code' => 400,
                    ],
                ],
            ],
            'success' => [
                [
                    'email' => static::INACTIVE_EMAIL,
                    'link' => 'test',
                ],
                [
                    'status' => 'success',
                ],
            ],
        ];
    }

    /**
     * @dataProvider resetRequestJsonData
     */
    public function testResetPasswordRequestJson($inputData, $expectedData): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/reset', $inputData);
        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);
        $this->assertEqualsCanonicalizing($expectedData, $responseData);
    }
    
    public function resetExecuteJsonData(): array
    {
        $passEmpty = 'Field password cannot be empty.';
        return [
            'password key invalid' => [
                [
                    'passwor' => static::VALID_PASSWORD,
                ],
                [
                    'exception' => [
                        'message' => $passEmpty,
                        'code' => 400
                    ]
                ],
                'token' => static::VALID_TOKEN,
            ],
            'password key empty' => [
                [
                    'password' => '',
                ],
                [
                    'exception' => [
                        'message' => $passEmpty,
                        'code' => 400
                    ]
                ],
                'token' => static::VALID_TOKEN,
            ],
            'invalid first token part' => [
                [
                    'password' => static::VALID_PASSWORD,
                ],
                [
                    'exception' => [
                        'message' => ErrorList::INVALID_TOKEN,
                        'code' => 400,
                    ],
                ],
                'token' => '8fae496b573b2ac202f5ce2b8412104737c79fbff6efa707023dab52d406a2152e793c8860c97670',
            ],
            'invalid second token part' => [
                [
                    'password' => static::VALID_PASSWORD,
                ],
                [
                    'exception' => [
                        'message' => ErrorList::INVALID_TOKEN,
                        'code' => 400,
                    ]
                ],
                'token' => '8ffe496b573b2ac202f5ce2b8412104737c79fbff6efa707023dab52d406a2152e793c8860c9767',
            ],
            'password too short' => [
                [
                    'password' => 'testtes',
                ],
                [
                    'exception' => [
                        'message' => 'Password needs to be at least 8 characters long.',
                        'code' => 400,
                    ]
                ],
                'token' => static::VALID_TOKEN,
            ],
            'resetSuccess' => [
                [
                    'password' => static::VALID_PASSWORD
                ],
                [
                    'status' => 'success'
                ],
                'token' => static::VALID_TOKEN,
            ],
        ];
    }

    /**
     * @dataProvider resetExecuteJsonData
     */
    public function testResetPasswordExecute($inputData, $expectedData, $token): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', sprintf('/api/reset/%s', $token), $inputData);
        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);
        $this->assertEqualsCanonicalizing($expectedData, $responseData);
    }

    public function loginData(): array
    {
        return [
            'loginSuccess' => [
                [
                    'username' => static::ACTIVE_EMAIL,
                    'password' => static::VALID_PASSWORD,
                ],
                [
                    'user' => static::ACTIVE_EMAIL
                ]
            ]
        ];
    }

    /**
     * @dataProvider loginData
     */
    public function testLoginAfterReset($inputData, $expectedData): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/login', $inputData);
        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true);
        $this->assertEqualsCanonicalizing($expectedData, $responseData);
    }
}
