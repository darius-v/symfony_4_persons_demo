<?php

namespace App\Service;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class PersonService
{
    private $personRepository;
//    private $formFactory;

    public function __construct(PersonRepository $personRepository/*, FormFactoryInterface $formFactory*/)
    {
        $this->personRepository = $personRepository;
        //$this->formFactory = $formFactory;
    }

    public function save(Person $person, string $uploadsDirectory)
    {
        $file = $person->getFileName();

        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        // Move the file to the directory where brochures are stored
        $file->move($uploadsDirectory, $fileName);

        // Update the 'brochure' property to store the PDF file name
        // instead of its contents
        $person->setFileName($fileName);

        $this->personRepository->save($person);
    }

//    public function save(string $uploadsDirectory, Request $request)
//    {
//        $person = new Person();
//
//        $form = $this->formFactory->create(PersonType::class, $person, [
//            'method' => 'POST',
//        ]);
//
//        $form->handleRequest($request);
//
//        $file = $person->getFileName();
//
//        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
//
//        // Move the file to the directory where brochures are stored
//        $file->move($uploadsDirectory, $fileName);
//
//        // Update the 'brochure' property to store the PDF file name
//        // instead of its contents
//        $person->setFileName($fileName);
//
//        $this->personValidator->validate($person);
//
//        $this->personRepository->save($person);
//    }

    public function list(): array
    {
        return [];
    }
}