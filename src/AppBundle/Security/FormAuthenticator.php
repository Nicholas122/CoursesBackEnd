<?php

namespace AppBundle\Security;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use AppBundle\Security\Authentication\AppUserProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class FormAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /** @var UserPasswordEncoder $encoder */
    private $encoder;

    /**
     * Default message for authentication failure.
     *
     * @var string
     */
    private $failMessage = 'Invalid credentials';

    /**
     * Creates a new instance of FormAuthenticator.
     */
    public function __construct(RouterInterface $router, UserPasswordEncoderInterface $encoder)
    {
        $this->router = $router;

        $this->encoder = $encoder;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        if ('/login' != $request->getPathInfo() || !$request->isMethod('POST')) {
            return;
        }

        return array(
            'email' => $request->request->get('auth')['email'],
            'password' => $request->request->get('auth')['password'],
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (!$userProvider instanceof AppUserProvider) {
            return;
        }

        try {
            return $userProvider->loadUserByUsername($credentials['email']);
        } catch (UsernameNotFoundException $e) {
            throw new CustomUserMessageAuthenticationException($this->failMessage);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($this->encoder->isPasswordValid($user, $credentials['password'])) {
            return true;
        }
        throw new CustomUserMessageAuthenticationException($this->failMessage);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('homepage'));
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        $url = $this->router->generate('login');

        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $url = $this->router->generate('login');

        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
