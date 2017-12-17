<?php

namespace App\Service;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PersonService
{
    private $personRepository;
    private $personValidator;

    public function __construct(PersonRepository $personRepository, PersonValidator $personValidator)
    {
        $this->personRepository = $personRepository;
        $this->personValidator = $personValidator;
    }

    public function save(Person $person, string $uploadsDirectory, UploadedFile $file)
    {
        $file = $person->getFileName();

        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        // Move the file to the directory where brochures are stored
        $file->move($uploadsDirectory, $fileName);

        // Update the 'brochure' property to store the PDF file name
        // instead of its contents
        $person->setFileName($fileName);


        // todo save in repository

        $this->personValidator->validate($person);

        $this->personRepository->save($person);
    }

    public function list(): array
    {
        return [];
    }
}