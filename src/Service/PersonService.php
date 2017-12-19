<?php

namespace App\Service;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PersonService
{
    private $personRepository;
    private $uploadsDirectory;
    private $phpFunctionsWrapper;

    public function __construct(
        PersonRepository $personRepository,
        string $uploadsDirectory,
        PhpFunctionsWrapper $phpFunctionsWrapper
    ) {
        $this->personRepository = $personRepository;
        $this->uploadsDirectory = $uploadsDirectory;
        $this->phpFunctionsWrapper = $phpFunctionsWrapper;
    }

    public function save(Person $person)
    {
        /** @var UploadedFile $file */
        // $person fileName field is to UploadedFile object by Symfony form handler.
        $file = $person->getFileName();

        $fileName = $this->phpFunctionsWrapper
                ->md5($this->phpFunctionsWrapper->uniqueId()) . '.' . $file->guessExtension();

        $file->move($this->uploadsDirectory, $fileName);

        // Update the person file property to store the file name instead of its contents
        $person->setFileName($fileName);

        $this->personRepository->save($person);
    }

    public function list(): array
    {
        return $this->personRepository->findAll();
    }

    public function findById(int $id): array
    {
        return $this->personRepository->findById($id);
    }

    public function getFilePath(string $fileName): string
    {
        return $this->uploadsDirectory . '/' . $fileName;
    }
}
