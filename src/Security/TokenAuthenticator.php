<?php 

// namespace App\Security;

// use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
// use Symfony\Component\Security\Core\Exception\AuthenticationException;
// use Symfony\Component\Security\Core\User\UserInterface;
// use Symfony\Component\Security\Core\User\UserProviderInterface;
// use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
// use App\Entity\User;
// use Doctrine\ORM\EntityManagerInterface;

// class TokenAuthenticator extends AbstractGuardAuthenticator
// {


//     private $em;

//     public function __construct(EntityManagerInterface $em)
//     {
//         $this->em = $em;
//     }


//     /**
//      * Called on every request to decide if this authenticator should be
//      * used for the request. Returning `false` will cause this authenticator
//      * to be skipped.
//      */
//     public function supports(Request $request)
//     {
//         return $request->headers->has('X-AUTH-TOKEN');
//     }

//     /**
//      * Called on every request. Return whatever credentials you want to
//      * be passed to getUser() as $credentials.
//      */
//     public function getCredentials(Request $request)
//     {
//         return $request->headers->get('X-AUTH-TOKEN');
//     }

//     public function getUser($credentials, UserProviderInterface $userProvider)
//     {
//         if (null === $credentials) {
//             // The token header was empty, authentication fails with HTTP Status
//             // Code 401 "Unauthorized"
//             return null;
//         }

//         // if a User is returned, checkCredentials() is called
//         return $userProvider->loadUserByUsername($credentials);
//     }

//     public function checkCredentials($credentials, UserInterface $user)
//     {
//         // check credentials - e.g. make sure the password is valid
//         // no credential check is needed in this case

//         // return true to cause authentication success
//         return true;
//     }

//     public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
//     {
//         // on success, let the request continue
//         return null;
//     }

//     public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
//     {
//         $data = [
//             // you may want to customize or obfuscate the message first
//             'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

//             // or to translate this message
//             // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
//         ];

//         return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
//     }

//     /**
//      * Called when authentication is needed, but it's not sent
//      */
//     public function start(Request $request, AuthenticationException $authException = null)
//     {
//         $data = [
//             // you might translate this message
//             'message' => 'Authentication Required'
//         ];

//         return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
//     }

//     public function supportsRememberMe()
//     {
//         return false;
//     }
// }