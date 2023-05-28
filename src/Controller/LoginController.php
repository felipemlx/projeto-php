<?php

namespace Felipe\Controller;

use Felipe\Helper\FlashMessageTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Felipe\Repository\UserRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Server\RequestHandlerInterface;
class LoginController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(private UserRepository $userRepository)
    {
        
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $email = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST,'password');
        $userData = $this->userRepository->find($email);
        $correctPassword = password_verify($password,$userData['password'] ?? '');
        $this->userRepository->checkHash($userData['id'],$userData['password']);
        if (!$correctPassword){
            $this->addErrorMessage('Usuário ou senha inválidos');
            return new Response(302,['Location' => '/login']);
        }else{
            $_SESSION['logado'] = true;
            return new Response(302,['Location' => '/']);
        }
    }
}