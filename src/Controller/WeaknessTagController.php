<?php

namespace App\Controller;

use App\Entity\WeaknessTag;
use App\Repository\WeaknessTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/weaknessTag")
 */
class WeaknessTagController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function api(WeaknessTagRepository $weaknessTagRepository): Response
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $weaknessTags = $weaknessTagRepository->findAll();
        $weaknessTags = $serializer->serialize($weaknessTags, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($weaknessTags, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/new", methods={"POST"})
     */
    public function apiNew(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $weaknessTag = new WeaknessTag($data['name']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($weaknessTag);
        $entityManager->flush();

        return $this->json($data);
    }

    /**
     * @Route("/{id}",methods={"GET"})
     */
    public function apiDetail(WeaknessTagRepository $weaknessTagRepository, $id)
    {
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $weaknessTags = $weaknessTagRepository->find($id);
        $weaknessTags = $serializer->serialize($weaknessTags, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($weaknessTags, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"})
     */
    public function delete(WeaknessTagRepository $weaknessTagRepository, $id)
    {
        $weaknessTag = $weaknessTagRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($weaknessTag);
        $entityManager->flush();
        return $this->json("WeaknessTag supprime");
    }

    /**
     * @Route("/edit/{id}", name="weaknessTag", methods={"PUT"})
     */
    public function edit(WeaknessTagRepository $weaknessTagRepository, Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        $weaknessTag = $weaknessTagRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        if (!$weaknessTag) {
            throw $this->createNotFoundException(
                'No weaknessTag found for id ' . $id
            );
        }
        $weaknessTag->setName($data['name']);
        $entityManager->flush();
        return $this->json("WeaknessTag edite");
    }
}
