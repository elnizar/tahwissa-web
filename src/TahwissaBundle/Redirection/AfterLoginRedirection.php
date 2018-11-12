<?php
namespace TahwissaBundle\Redirection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
// Get list of roles for current user

        $roles = $token->getRoles();

// Tranform this list in array
        $rolesTab = array_map(function($role){
            return $role->getRole();
        }, $roles);
// If is a admin or super admin we redirect to the backoffice area
        if ($token->getUser()->getBanned()==1){
            $redirection = new RedirectResponse($this->router->generate('fos_user_security_logout'));
        }
        else{
             if (sizeof($roles)==1 )
            $redirection = new RedirectResponse($this->router->generate('home_member'));
        else
            $redirection = new RedirectResponse($this->router->generate('home_admin'));
// otherwise, if is a commercial user we redirect to the crm area
        }


// otherwise we redirect user to the member area

        $session = $request->getSession();
        $session->set("user",$token->getUser());
        return $redirection;
    }
}
