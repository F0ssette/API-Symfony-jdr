<?php

namespace App\Controller;

use App\Entity\Nemesis;
use App\Repository\NemesisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/nemesis")
 */
class NemesisController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function api(NemesisRepository $nemesisRepository): Response
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $nemesiss = $nemesisRepository->findAll();
        $nemesiss = $serializer->serialize($nemesiss, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($nemesiss, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/new", methods={"POST"})
     */
    public function apiNew(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $nemesis = new Nemesis($data['name']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($nemesis);
        $entityManager->flush();

        return $this->json($data);
    }

    /**
     * @Route("/{id}",methods={"GET"})
     */
    public function apiDetail(NemesisRepository $nemesisRepository, $id)
    {
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $nemesiss = $nemesisRepository->find($id);
        $nemesiss = $serializer->serialize($nemesiss, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($nemesiss, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"})
     */
    public function delete(NemesisRepository $nemesisRepository, $id)
    {
        $nemesis = $nemesisRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($nemesis);
        $entityManager->flush();
        return $this->json("Nemesis supprime");
    }

    /**
     * @Route("/edit/{id}", name="nemesis", methods={"PUT"})
     */
    public function edit(NemesisRepository $nemesisRepository, Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        $nemesis = $nemesisRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        if (!$nemesis) {
            throw $this->createNotFoundException(
                'No nemesis found for id ' . $id
            );
        }
        $nemesis->setName($data['name']);
        $entityManager->flush();
        return $this->json("Nemesis edite");
    }
}
