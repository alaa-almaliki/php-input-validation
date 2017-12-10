# Input Validation 
 Based on [Respect Validation](https://github.com/Respect/Validation)
 
 See full list of [Rule Validators](http://respect.github.io/Validation/docs/validators.html)
 
# Installation
 Use composer

# Example
```
require_once __DIR__ . '/vendor/autoload.php';

$validation = new \Rv\InputValidation\Validation();

$isValid = $validation->validate(
    '21',
    [
        ['class' => 'Between', 'args' => ['min' => 16, 'max' => 22]],
        ['class' => 'NotEmpty']
    ]
);

$isValidEmail = $validation->validate(
    'alaa.almaliki@gmail.com',
    [
        ['class' => 'NotEmpty'],
        ['class' => 'Email'],
    ]
);

$emailPostResults = $validation->validatePostData(
    ['email' => 'alaa.almaliki@gmail.com'],
    [
        'email' => [
            [
                'class' => 'Email',
                'success_message' => 'Valid Email',
                'failure_message' => 'Not Valid Email',
            ],
        ],
    ]
);


$emailParamResults = $validation->validateGetData(
    ['email' => 'alaa.almaliki@gmail.com'],
    [
        'email' => [
            [
                'class' => 'Email',
                'success_message' => 'Valid Email',
                'failure_message' => 'Not Valid Email',
            ],
        ],
    ]
);
var_dump($isValid);
var_dump($isValidEmail);
var_dump($emailPostResults);
var_dump($emailParamResults);
```

