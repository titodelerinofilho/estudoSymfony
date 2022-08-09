<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Helper\EspecialidadeFactory;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadesController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        EspecialidadeRepository $repository,
        EspecialidadeFactory $factory,
    ) {
        parent::__construct($repository, $entityManager, $factory);
        $this->factory = $factory;
    }

    /**
     * @param Especialidade $entidadeExistente
     * @param Especialidade $entidadeEnviada
     * @return void
     */
    public function atualizarEntidadeExistente(
        $entidadeExistente,
        $entidadeEnviada): void
    {
        $entidadeExistente
            ->setDescricao($entidadeEnviada->getDescricao());
    }

    /**
     * @Route("/especialidades/{id}", methods={"DELETE"})
     */
    public function remove(int $id): Response
    {
        $especialidade = $this->repository->find($id);
        $this->entityManager->remove($especialidade);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
