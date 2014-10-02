<?php
namespace gospelcenter\UserBundle\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;

class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{

    protected $router;

    public function __construct(HttpUtils $httpUtils, array $options, RouterInterface $router)
    {
        parent::__construct($httpUtils, $options);
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {

        var_dump($request);

        if ($request->get('continue') != null) {
            $url = $request->get('continue');
        } else {
            $url = "/";
        }

        var_dump($url);

        die();

        if ($request->get('continue') != null) {
            $url = $request->get('continue');
        } else {
            $url = "/";
        }

        //return new RedirectResponse($this->router->generate('gospelcenter_home'));

        return new RedirectResponse($this->router->generate('admin'));

        return $this->redirect($url);
    }
}