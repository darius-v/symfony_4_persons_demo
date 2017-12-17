<?php

namespace App\Controller;

use App\Entity\Person;
use App\ExceptionToUser\GeneralException;
use App\Form\PersonType;
use App\Service\PersonService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends Controller
{
    private $personService;

    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    public function person(Request $request): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person, array(
            'method' => 'POST',
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $person->getFileName();

            $this->personService->save($person, $this->getParameter('uploads_directory'), $file);

            return $this->redirectToRoute('person');
        }

        return $this->render('persons/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function list(): Response
    {
        $persons = $this->personService->list();

        return $this->render('persons/list.html.twig', $persons);
    }
}
