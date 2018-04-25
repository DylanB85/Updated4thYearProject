<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


use AppBundle\Entity\Appointments as Appointment;

class SchedulerController extends Controller
{
    /**
     * View that renders the scheduler
     * @Route("/scheduler", name="scheduler")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repositoryAppointments = $em->getRepository("AppBundle:Appointments");

        $repositoryCategories = $em->getRepository("AppBundle:Categories");

        $appointments = $repositoryAppointments->findAll();

        $formatedAppointments = $this->formatAppointmentsToJson($appointments);

        $categories = $repositoryCategories->findAll();

        $formatedCategories = $this->formatCategoriesToJson($categories);

        return $this->render("scheduler/scheduler.html.twig", [
            'appointments' => $formatedAppointments,
            'categories' => $formatedCategories,
        ]);
    }

    /**
     * Handle the creation of an appointment.
     */
    public function createAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $repositoryAppointments = $em->getRepository("AppBundle:Appointments");

        // Use the same format used by Moment.js in the view
        $format = "d-m-Y H:i:s";

        // Create appointment entity and set fields values
        $appointment = new Appointment();
        $appointment->setTitle($request->request->get("title"));
        $appointment->setDescription($request->request->get("description"));
        $appointment->setStartDate(
            \DateTime::createFromFormat($format, $request->request->get("start_date"))
        );
        $appointment->setEndDate(
            \DateTime::createFromFormat($format, $request->request->get("end_date"))
        );

        $repositoryCategories = $em->getRepository("AppBundle:Categories");

        $appointment->setCategory(
            $repositoryCategories->find(
                $request->request->get("category")
            )
        );

        // Create appointment
        $em->persist($appointment);
        $em->flush();

        return new JsonResponse(array(
            "status" => "success"
        ));
    }

    /**
     * Handle the update of the appointments.
     */
    public function updateAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $repositoryAppointments = $em->getRepository("AppBundle:Appointments");

        $appointmentId = $request->request->get("id");

        $appointment = $repositoryAppointments->find($appointmentId);

        if(!$appointment){
            return new JsonResponse(array(
                "status" => "error",
                "message" => "The appointment to update $appointmentId doesn't exist."
            ));
        }

        // Uses format specified in moment.js
        $format = "d-m-Y H:i:s";

        $appointment->setTitle($request->request->get("title"));
        $appointment->setDescription($request->request->get("description"));
        $appointment->setStartDate(
            \DateTime::createFromFormat($format, $request->request->get("start_date"))
        );
        $appointment->setEndDate(
            \DateTime::createFromFormat($format, $request->request->get("end_date"))
        );

        $repositoryCategories = $em->getRepository("AppBundle:Categories");

        $appointment->setCategory(
            $repositoryCategories->find(
                $request->request->get("category")
            )
        );

        // Update appointment
        $em->persist($appointment);
        $em->flush();

        return new JsonResponse(array(
            "status" => "success"
        ));
    }

    /**
     * Deletes an appointment from the database
     */
    public function deleteAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $repositoryAppointments = $em->getRepository("AppBundle:Appointments");

        $appointmentId = $request->request->get("id");

        $appointment = $repositoryAppointments->find($appointmentId);

        if(!$appointment){
            return new JsonResponse(array(
                "status" => "error",
                "message" => "The given appointment $appointmentId doesn't exist."
            ));
        }

        // Remove appointment from database !
        $em->remove($appointment);
        $em->flush();

        return new JsonResponse(array(
            "status" => "success"
        ));
    }

    private function formatAppointmentsToJson($appointments){
        $formatedAppointments = array();

        foreach($appointments as $appointment){
            array_push($formatedAppointments, array(
                "id" => $appointment->getId(),
                "description" => $appointment->getDescription(),
                "text" => $appointment->getTitle(),
                "start_date" => $appointment->getStartDate()->format("Y-m-d H:i"),
                "end_date" => $appointment->getEndDate()->format("Y-m-d H:i"),
            ));
        }

        return json_encode($formatedAppointments);
    }

    private function formatCategoriesToJson($categories){
        $formatedCategories = array();

        foreach ($categories as $category){
            array_push($formatedCategories, array(
                "key" => $category->getId(),
                "label" => $category->getName()
            ));
        }

        return json_encode($formatedCategories);
    }
}