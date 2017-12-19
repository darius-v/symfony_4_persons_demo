<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Service\PersonService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $form = $this->createForm(PersonType::class, $person, [
            'method' => 'POST',
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->personService->save($person);

            return $this->redirectToRoute('personForm');
        }

        return $this->render('persons/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function list(): Response
    {
        $persons = $this->personService->list();

        return $this->render('persons/list.html.twig', ['persons' => $persons]);
    }

    public function details(int $id): Response
    {
        $person = $this->personService->findById($id);

        return $this->render('persons/details.html.twig', ['person' => $person]);
    }

    public function fileDownload(string $fileName): Response
    {
        $filePath = $this->personService->getFilePath($fileName);

        return $this->file($filePath);
    }
}
