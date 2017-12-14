<?php

namespace App\Service;

use App\Entity\Person;
use App\Repository\PersonRepository;

class PersonService
{
    private $personRepository;
    private $personValidator;

    public function __construct(PersonRepository $personRepository, PersonValidator $personValidator)
    {
        $this->personRepository = $personRepository;
        $this->personValidator = $personValidator;
    }

    public function save(Person $person)
    {
        // todo - validate
        // todo - upload file
        // todo save in repository

        $this->personValidator->validate($person);

        $person->setFileName('test');

        $this->personRepository->save($person);
    }
}