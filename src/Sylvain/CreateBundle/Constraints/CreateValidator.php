<?php


namespace App\Sylvain\CreateBundle\Constraints;


use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CreateValidator extends ConstraintValidator
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var ReCaptcha
     */
    private $reCaptcha;

    /**
     * CreateValidator constructor.
     * @param RequestStack $requestStack
     * @param ReCaptcha $reCaptcha
     */
    public function __construct(RequestStack $requestStack, ReCaptcha $reCaptcha)
    {
        $this->requestStack = $requestStack;
        $this->reCaptcha = $reCaptcha;
    }

    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $recaptchaResponse = $request->request->get(g-recaptcha-response);
        if(empty($recaptchaResponse)){
            $this->addViolation($constraint);
            //$this->context->buildViolation($constraint->message)->addViolation();
            return;
        }
        $response = $this->reCaptcha
            ->setExpectedHostname($request->getHost())
            ->verify($recaptchaResponse, $request->getClientIp())
        ;
        if(!$response->isSuccess()){
            //dump($response->getErrorCodes());
            $this->addViolation($constraint);
        }
    }

    private function addViolation(Constraint $constraint)
    {
        return $this->context->buildViolation($constraint->message)->addViolation();
    }
}
