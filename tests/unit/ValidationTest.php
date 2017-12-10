<?php

namespace Rv\InputValidation;

use PHPUnit\Framework\TestCase;

/***
 * Class ValidationTest
 * @package Rv\InputValidation
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ValidationTest extends TestCase
{
    /**
     * @var Validation
     */
    private $validation;

    /**
     * stub
     */
    public function setUp()
    {
        $this->validation = new Validation();
        parent::setUp();
    }

    /**
     * @param array $postData
     * @param array $ruleConfig
     * @dataProvider getValidatePostData
     */
    public function testValidatePostData(array $postData, array $ruleConfig)
    {
        $results = $this->validation->validatePostData($postData, $ruleConfig);
        $expected = [
            'email' => [
                'is_valid' => true,
                'message' => 'Valid Email',
            ],
            'age' => [
                'is_valid' => true,
                'message' => 'Legal Age'
            ]
        ];

        $this->assertEquals($expected, $results);
    }

    /**
     * @param array $getData
     * @param array $ruleConfig
     * @dataProvider getValidatePostData
     */
    public function testValidateGetData(array $getData, array $ruleConfig)
    {
        $results = $this->validation->validateGetData($getData, $ruleConfig);
        $expected = [
            'email' => [
                'is_valid' => true,
                'message' => 'Valid Email',
            ],
            'age' => [
                'is_valid' => true,
                'message' => 'Legal Age'
            ]
        ];

        $this->assertEquals($expected, $results);
    }

    /**
     * @param $input
     * @param array $rules
     * @dataProvider getValidateData
     */
    public function testValidate($input, array $rules)
    {
        $this->assertTrue($this->validation->validate($input, $rules));
    }

    /**
     * Test validate on failure
     */
    public function testValidateFail()
    {
        $this->assertFalse($this->validation->validate(
            'Hello world',
            [
                ['class' => 'NotEmpty'],
                ['class' => 'Numeric'],
            ]
        ));
    }

    /**
     * @param $input
     * @param array $rules
     * @dataProvider getValidateInputData
     */
    public function testValidateInput($input, array $rules)
    {
        $this->assertTrue($this->validation->validateInput($input, $rules));
    }

    /**
     * @expectedException \Rv\InputValidation\InputValidationMethodException
     * @expectedExceptionMessage Validation rule class must be provided.
     */
    public function testValidateInputClassNotProvided()
    {
        $this->validation->validateInput('alaa', ['NotEmpy']);
    }

    /**
     * @expectedException \Rv\InputValidation\InputValidationMethodException
     * @expectedExceptionMessage NtEmpty class is not found
     */
    public function testValidateInputClassNotExists()
    {
        $this->validation->validateInput('alaa', ['class' => 'NtEmpty']);
    }

    /**
     * @return array
     */
    public function getValidatePostData()
    {
        return [
            [
                [
                    'email' => 'john.doe@gmail.com',
                    'age' => '19'
                ],
                [
                    'email' => [
                        [
                            'class' => 'StringType',
                            'failure_message' => 'Invalid Email',
                            'success_message' => 'Valid Email'
                        ],
                        [
                            'class' => 'NotEmpty',
                            'failure_message' => 'Invalid Email',
                            'success_message' => 'Valid Email'
                        ],
                        [
                            'class' => 'Email',
                            'failure_message' => 'Invalid Email',
                            'success_message' => 'Valid Email'
                        ]
                    ],
                    'age' => [
                        [
                            'class' => 'Between',
                            'args' => ['min' => '18', 'max' => '22'],
                            'failure_message' => 'Illegal Age',
                            'success_message' => 'Legal Age'
                        ],
                    ]
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    public function getValidateData()
    {
        return [
            [
                'john.doe@gmail.com',
                [
                    ['class' => 'StringType'],
                    ['class' => 'NotEmpty'],
                    ['class' => 'Email']
                ]
            ],
            [
                '12',
                [
                    ['class' => 'Numeric'],
                    ['class' => 'Between', 'args' => ['10', '20']]
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function getValidateInputData()
    {
        return [
            [
                'john.doe@gmail.com',
                ['class' => 'Email']
            ],
            [
                'Hello Work',
                ['class' => 'NotEmpty']
            ],
            [
                'Hello Work',
                ['class' => 'StringType']
            ],
            [
                '12',
                ['class' => 'Between', 'args' => ['10', '20']]
            ],
            [
                [],
                ['class' => 'ArrayType']
            ],
            [
                '12',
                ['class' => 'Numeric']
            ]
        ];
    }
}
