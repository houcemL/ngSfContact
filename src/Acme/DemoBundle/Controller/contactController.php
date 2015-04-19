<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\DemoBundle\Entity\contact;
use Acme\DemoBundle\Form\contactType;

/**
 * contact controller.
 *
 */
class contactController extends Controller {

    /**
     * Lists all contact entities.
     *
     */
    public function jsonAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeDemoBundle:contact')->findAll();
        if (empty($entities)) {
            $res = array();
        } else {
            foreach ($entities as $contact) {
                $res[] = $contact->toArray();
            }
        }

        return $this->render('AcmeDemoBundle:contact:index.json.twig', array(
                    'entities' => $res,
        ));
    }

    /**
     * Lists all contact entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeDemoBundle:contact')->findAll();
        $entity = new contact();
        $newForm = $this->createForm(new contactType(), $entity, array(
            'action' => $this->generateUrl('contact_create'),
            'method' => 'POST',
        ));

        $newForm->add('submit', 'button', array(
            'label' => 'Ajouter',
            'attr' => array('ng-click' => "add(" . '$event' . ")")
        ));
        return $this->render('AcmeDemoBundle:contact:mainAngular.html.twig', array(
                    'entities' => $entities,
                    'new' => $newForm->createView()
        ));
    }

    /**
     * Creates a new contact entity.
     *
     */
    public function ngcreateAction(Request $request) {
        $contact = new contact();
        $name = $request->request->get('name');
        $mail = $request->request->get('mail');
        $message = $request->request->get('message');
        $contact->setMail($mail);
        $contact->setName($name);
        $contact->setMessage($message);
        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();
        $response = new Response();
        return $response->setContent(json_encode($contact->toArray()));
    }

    /**
     * Edits an existing contact entity.
     *
     */
    public function ngupdateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $contact = $em->getRepository('AcmeDemoBundle:contact')->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Unable to find contact entity.');
        }
        $name = $request->request->get('name');
        $mail = $request->request->get('mail');
        $message = $request->request->get('message');
        $contact->setName($name);
        $contact->setMessage($message);
        $contact->setMail($mail);

        $em->persist($contact);
        $em->flush();
        $response = new Response();
        return $response->setContent(json_encode($contact->toArray()));
    }

    /**
     * Deletes a contact entity.
     *
     */
    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AcmeDemoBundle:contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find contact entity.');
        }

        $em->remove($entity);
        $em->flush();
        $response = new Response();
        return $response;
    }

}
