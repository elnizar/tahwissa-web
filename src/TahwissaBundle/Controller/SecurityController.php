<?php
/**
 * Created by PhpStorm.
 * User: Meedoch
 * Date: 06/02/2017
 * Time: 09:28
 */

namespace TahwissaBundle\Controller;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
class SecurityController extends BaseController
{
    protected function renderLogin(array $data)
    {
        return $this->render('@Tahwissa/Default/login.html.twig', $data);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/error403", name="403_error")
     */
    public function Error403Action(Request $r){
        return $this->render("@FOSUser/Default/404.html.twig");
    }
}