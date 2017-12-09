# Input Validation 
 Based on [Respect Validation](https://github.com/Respect/Validation)
 
 See full list of [Validators](http://respect.github.io/Validation/docs/validators.html)
 
# Installation
 Use composer

# Usage
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
var_dump($isValid);
var_dump($isValidEmail);
```

