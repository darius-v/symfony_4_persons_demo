<?php

namespace App\Controller;

use App\Entity\Person;
use App\ExceptionToUser\GeneralException;
use App\Service\PersonService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

    public function form(): Response
    {
        return $this->render('persons/form.html.twig');
    }

    public function postPerson(Request $request): Response
    {
        $person = new Person();
        $person->setFullName($request->get('full-name'));
        $person->setDateOfBirth($request->get('date-of-birth'));
        $person->setEmail($request->get('email'));
        $person->setPhoneNumber($request->get('phone-number'));

        try {
            $this->personService->save($person);
        } catch (GeneralException $e) {
            return new Response($e->getMessage(), 400);
        }

        return $this->redirectToRoute('form');
    }

    public function list(): Response
    {
        $persons = $this->personService->list();

        return $this->render('persons/list.html.twig', $persons);
    }
}
