<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RegistrationController
 * @package App\Controller
 * @Security("!is_granted('IS_AUTHENTICATED_FULLY')")
 */
class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getUserAuthService()->register($user);
            return $this->getAuthSuccessHandler()->handleAuthenticationSuccess($user);
        }

        $errors = $form->getErrors(true, true);
        $errorCollection = [];
        foreach ($errors as $error) {
            $errorCollection[$error->getOrigin()->getConfig()->getName()] = $error->getMessage();
        }
        $array = ['code' => 400, 'message' => $errorCollection];
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    protected function getUserAuthService()
    {
        return $this->get('app.service.user.user_auth_service');
    }

    protected function getAuthSuccessHandler()
    {
        return $this->get('lexik_jwt_authentication.handler.authentication_success');
    }

    private function getErrorMessages(\Symfony\Component\Form\Form $form) {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }
}