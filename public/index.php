<?php

    require __DIR__ . '/../vendor/autoload.php';

    // importação de classes
    use Alura\Cursos\Controller\InterfaceControladorRequisicao;
    use Nyholm\Psr7\Factory\Psr17Factory;
    use Nyholm\Psr7Server\ServerRequestCreator;

    $caminho = $_SERVER['PATH_INFO'];//caminho da rota
    $rotas = require __DIR__ . '/../config/routes.php';// array das rotas

    // verifica se a rota existe
    if(!array_key_exists($caminho, $rotas)) {
        header('Location: /404', true, 302);
    };

    //inicia a sessão
    session_start();
    //verifica se na string tem a palavra login
    // $ehRotaDeLogin = str_contains($caminho, 'login');
    // if (!isset($_SESSION['logado']) && !$ehRotaDeLogin) {
    //     header('Location: /login');
    //     // exit();
    // }

    $psr17Factory = new Psr17Factory();
    $creator = new ServerRequestCreator(
        $psr17Factory, // ServerRequestFactory
        $psr17Factory, // UrlFactory
        $psr17Factory, // UploadedFileFactory
        $psr17Factory // StreamFactory
    );

    $request = $creator->fromGlobals();

    $classeControladora = $rotas[$caminho];
    /** @var InterfaceControladorRequisicao $controler */
    $controlador = new $classeControladora();// cria uma classe controladora
    $resposta = $controlador->processaRequisicao($request);

    foreach($resposta->getHeaders() AS $name => $value){
        foreach($value as $value) {
            header(sprintf('%s: %s', $name, $value), false);
        }
    }

    echo $resposta->getBody();

