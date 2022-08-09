<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Helper\EntidadeFactory;
use App\Helper\MedicoFactory;
use App\Repository\MedicosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        MedicoFactory $medicoFactory,
        MedicosRepository $medicosRepository,
    ) {
        parent::__construct($medicosRepository, $entityManager, $medicoFactory);
    }

    /**
     * @param Medico $entidadeExistente
     * @param Medico $entidadeEnviada
     * @return void
     */

    public function atualizarEntidadeExistente(
        $entidadeExistente,
        $entidadeEnviada): void
    {
        $entidadeExistente
            ->setCrm($entidadeEnviada->getCrm())
            ->setNome($entidadeEnviada->getNome())
            ->setEspecialidade($entidadeEnviada->getEspecialidade());
    }

    /**
     * @Route("/especialidades/{especialidadeId}/medicos", methods={"GET"})
     */
    public function buscarPorEspecialidade(int $especialidadeId, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $repositorioMedicos = $entityManager->getRepository(Medico::class);

        $medicos = $repositorioMedicos->findBy([
            'especialidade' => $especialidadeId,
        ]);

        return new JsonResponse($medicos);
    }
}