<?php


namespace App\Sylvain\CreateBundle\Constraints;


use Symfony\Component\Validator\Constraint;

class Create extends Constraint
{
    public $message = 'Invalid captcha';
}
