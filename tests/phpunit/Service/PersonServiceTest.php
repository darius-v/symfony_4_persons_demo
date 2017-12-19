<?php

use App\Entity\Person;
use App\Repository\PersonRepository;
use App\Service\PersonService;
use App\Service\PhpFunctionsWrapper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PersonServiceTest extends TestCase
{
    private function mockPersonRepository()
    {
        return $this->getMockBuilder(PersonRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testSaveMovesFileWithUniqueFileName()
    {
        $phpFunctionsWrapper = $this->getMockBuilder(PhpFunctionsWrapper::class)
            ->setMethods(['md5', 'uniqueId'])
            ->getMock();

        $phpFunctionsWrapper
            ->expects($this->once())
            ->method('uniqueId')
            ->willReturn('uniqueId');

        /** @var PhpFunctionsWrapper|MockObject $phpFunctionsWrapper */
        $phpFunctionsWrapper
            ->expects($this->once())
            ->method('md5')
            ->with('uniqueId')
            ->willReturn('filenamemd5');

        $personService = new PersonService(
            $this->mockPersonRepository(),
            'uploads',
            $phpFunctionsWrapper
        );

        $uploadedFile = $this->getMockBuilder(UploadedFile::class)
            ->disableOriginalConstructor()
            ->setMethods(['move', 'guessExtension'])
            ->getMock();

        $uploadedFile
            ->expects($this->any())
            ->method('guessExtension')
            ->willReturn('jpg');

        $uploadedFile
            ->expects($this->once())
            ->method('move')
            ->with('uploads', 'filenamemd5.jpg');

        $person = new Person();
        $person->setFileName($uploadedFile);

        $personService->save($person);
    }
}
