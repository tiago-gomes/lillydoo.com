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
    public function index() {
        $address = $this->addressModel->getAllAddresss();
        return new JsonResponse([
            'code' => 200,
            'data' => $address
        ]);
    }

    /**
     * Show address details by ID
     *
     * @Route("/address/{id}", requirements={"id"="\d+"}, name="getAddressById", methods={"GET"})
     * @param \Symfony\Bundle\FrameworkBundle\Controller\string $id
     * @return object|JsonResponse
     * @throws \Exception
     */
    public function getById($id) {
        $address = $this->addressModel->getAddressById($id);
        return new JsonResponse([
            'code' => 200,
            'data' => $address->toArray()
        ]);
    }

    /**
     * @Route("/address", requirements={"id"="\d+"}, name="addAddress", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function post(Request $request) {
        $address = $this->addressModel->addAddress($request->request->all());
        return new JsonResponse([
            'code' => 200,
            'data' => $address->toArray()
        ]);
    }

    /**
     * Update an existing address
     *
     * @Route("/address/{id}", requirements={"id"="\d+"}, name="updateAddress", methods={"PATCH"})
     * @param $id
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function patch($id, Request $request) {
        $address = $this->addressModel->updateAddress($id, $request->query->all());
        return $this->render('worker/dashboard.html.twig', array(
          'address' => $address->toArray()
        ));
    }

    /**
     * Remove an existing address
     *
     * @Route("/address/{id}", requirements={"id"="\d+"}, name="removeAddress", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete($id) {
        $this->addressModel->removeAddress($id);
        return new JsonResponse([
            'code' => 200,
            'message' => 'Address was successfully removed.'
        ]);
    }
}
