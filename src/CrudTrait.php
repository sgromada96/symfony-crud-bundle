<?php

namespace Sgromada\Trait;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function Symfony\Component\Translation\t;

trait CrudTrait
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(Request $request, array $additionals = []): Response
    {
        return $this->render($this->templatePath.'/index.html.twig', [
            'entites' => $this->entityManager->getRepository($this->class)->findAll(),
            'additionals' => $additionals,
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, array $additionals = []): Response
    {
        $entity = new $this->class();
        $form = $this->createForm($this->form, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            $this->addFlash('success', t('Dodano nowy rekord'));

            return $this->index($request);
        }

        return $this->render($this->templatePath.'/create.html.twig', [
            'form' => $form->createView(),
            'additionals' => $additionals,
        ]);
    }

    #[Route('/{id}/update', name: 'update', methods: ['GET', 'POST'])]
    public function update(Request $request, int $id, array $additionals = []): Response
    {
        $entity = $this->entityManager->getRepository($this->class)->find($id);

        $form = $this->createForm($this->form, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', t('Zapisano zmiany'));

            return $this->index($request);
        }

        return $this->render($this->templatePath.'/update.html.twig', [
            'form' => $form->createView(),
            'additionals' => $additionals,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, int $id)
    {
        $entity = $this->entityManager->getRepository($this->class)->find($id);

        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        $this->addFlash('success', t('Usunięto'));

        return $this->index($request);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, array $additionals = []): Response
    {
        return $this->render($this->templatePath.'/show.html.twig', [
            'entity' => $this->entityManager->getRepository($this->class)->find($id),
            'additionals' => $additionals,
        ]);
    }
}
