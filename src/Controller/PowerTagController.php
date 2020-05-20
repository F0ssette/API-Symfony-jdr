<?php

namespace App\Controller;

use App\Entity\PowerTag;
use App\Repository\PowerTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/powerTag")
 */
class PowerTagController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function api(PowerTagRepository $powerTagRepository): Response
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $powerTags = $powerTagRepository->findAll();
        $powerTags = $serializer->serialize($powerTags, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($powerTags, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/new", methods={"POST"})
     */
    public function apiNew(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $powerTag = new PowerTag($data['name']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($powerTag);
        $entityManager->flush();

        return $this->json($data);
    }

    /**
     * @Route("/{id}",methods={"GET"})
     */
    public function apiDetail(PowerTagRepository $powerTagRepository, $id)
    {
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $powerTags = $powerTagRepository->find($id);
        $powerTags = $serializer->serialize($powerTags, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($powerTags, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"})
     */
    public function delete(PowerTagRepository $powerTagRepository, $id)
    {
        $powerTag = $powerTagRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($powerTag);
        $entityManager->flush();
        return $this->json("PowerTag supprime");
    }

    /**
     * @Route("/edit/{id}", name="powerTag", methods={"PUT"})
     */
    public function edit(PowerTagRepository $powerTagRepository, Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        $powerTag = $powerTagRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        if (!$powerTag) {
            throw $this->createNotFoundException(
                'No powerTag found for id ' . $id
            );
        }
        $powerTag->setName($data['name']);
        $entityManager->flush();
        return $this->json("PowerTag edite");
    }
}
