<?php

use Alura\Cursos\Controller\Exclusao;
use Alura\Cursos\Controller\FormularioInsercao;


//  lista de rotas
return [
    '/novo-curso'       =>  FormularioInsercao::class,
    '/excluir-curso'    =>  Exclusao::class
];
