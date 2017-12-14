<?php

namespace App\Service;

use App\Entity\Person;
use App\ExceptionToUser\GeneralException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PersonValidator
{
    private $recursiveValidator;

    public function __construct(ValidatorInterface $recursiveValidator)
    {
        $this->recursiveValidator = $recursiveValidator;
    }

    /**
     * Validates by annotations in Person entity near fields like @Assert\NotBlank()
     * @param Person $person
     * @throws GeneralException
     */
    public function validate(Person $person)
    {
        $errors = $this->recursiveValidator->validate($person);

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;

            throw new GeneralException($errorsString);
        }
    }
}
