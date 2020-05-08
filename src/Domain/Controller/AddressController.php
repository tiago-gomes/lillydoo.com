<?php

namespace App\Domain\Controller;

use App\Domain\Model\AddressModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AddressController
 * @package App\Domain\Controller
 */
class AddressController extends Controller
{
    /**
     * @var AddressModel
     */
    protected $addressModel;

    /**
     * AddressController constructor.
     * @param AddressModel $AddressModel
     */
    public function __construct(AddressModel $AddressModel)
    {
        $this->addressModel = $AddressModel;
    }

    /**
     * @Route("/address", name="getAllAddresss", methods={"GET"})
     * @return JsonResponse
     * @throws \Exception
     */
    public function searchView() {
        $address = $this->addressModel->getAllAddresss();
        return $this->render('address/list.html.twig', array(
          'address' => $address
        ));
    }
    
    /**
     * @Route("/address/add", methods={"GET"})
     * @throws \Exception
     */
    public function addView() {
        return $this->render('address/add.html.twig');
    }

    /**
     * Show address details by ID
     *
     * @Route("/address/view/{id}", requirements={"id"="\d+"}, name="getAddressById", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editView($id) {
        $address = $this->addressModel->getAddressById($id);
        if (empty($address)) {
            throw new \Exception('Address ID does not exist!!!', 412);
        }
        return $this->render('address/edit.html.twig', array(
          'address' => $address->toArray()
        ));
    }

    /**
     * @Route("/address/create", requirements={"id"="\d+"}, name="addAddress", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function addAction(Request $request) {
        $address = $this->addressModel->addAddress($request->request->all());
        $this->addFlash('success', 'Address as been created!!!');
        return $this->redirect('/address', 302);
    }

    /**
     * Update an existing address
     *
     * @Route("/address/update/{id}", requirements={"id"="\d+"}, name="updateAddress", methods={"POST"})
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function updateAction($id, Request $request) {
        $address = $this->addressModel->updateAddress($id, $request->request->all());
        $this->addFlash('success', 'Address as been updated!!!');
        return $this->redirect('/address/view/'. $address->getId(), 302);
    }

    /**
     * Remove an existing address
     *
     * @Route("/address/delete/{id}", requirements={"id"="\d+"}, name="removeAddress", methods={"GET"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function deleteAction($id) {
        $this->addressModel->removeAddress($id);
        $this->addFlash('success', 'Address as been deleted!!!');
        return $this->redirect('/address', 302);
    }
}
