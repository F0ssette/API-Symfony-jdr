<?php

namespace App\Controller;

use App\Entity\Improvement;
use App\Repository\ImprovementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/improvement")
 */
class ImprovementController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function api(ImprovementRepository $improvementRepository): Response
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $improvements = $improvementRepository->findAll();
        $improvements = $serializer->serialize($improvements, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($improvements, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/new", methods={"POST"})
     */
    public function apiNew(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $improvement = new Improvement($data['name'], $data['details']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($improvement);
        $entityManager->flush();

        return $this->json($data);
    }

    /**
     * @Route("/{id}",methods={"GET"})
     */
    public function apiDetail(ImprovementRepository $improvementRepository, $id)
    {
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $improvements = $improvementRepository->find($id);
        $improvements = $serializer->serialize($improvements, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($improvements, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"})
     */
    public function delete(ImprovementRepository $improvementRepository, $id)
    {
        $improvement = $improvementRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($improvement);
        $entityManager->flush();
        return $this->json("Improvement supprime");
    }

    /**
     * @Route("/edit/{id}", name="improvement", methods={"PUT"})
     */
    public function edit(ImprovementRepository $improvementRepository, Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        $improvement = $improvementRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        if (!$improvement) {
            throw $this->createNotFoundException(
                'No improvement found for id ' . $id
            );
        }
        $improvement->setName($data['name']);
        $improvement->setDetails($data['details']);
        $entityManager->flush();
        return $this->json("Improvement edite");
    }
}
