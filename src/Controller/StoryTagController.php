<?php

namespace App\Controller;

use App\Entity\StoryTag;
use App\Repository\StoryTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/storyTag")
 */
class StoryTagController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function api(StoryTagRepository $storyTagRepository): Response
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $storyTags = $storyTagRepository->findAll();
        $storyTags = $serializer->serialize($storyTags, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($storyTags, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/new", methods={"POST"})
     */
    public function apiNew(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $storyTag = new StoryTag($data['name']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($storyTag);
        $entityManager->flush();

        return $this->json($data);
    }

    /**
     * @Route("/{id}",methods={"GET"})
     */
    public function apiDetail(StoryTagRepository $storyTagRepository, $id)
    {
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $storyTags = $storyTagRepository->find($id);
        $storyTags = $serializer->serialize($storyTags, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($storyTags, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"})
     */
    public function delete(StoryTagRepository $storyTagRepository, $id)
    {
        $storyTag = $storyTagRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($storyTag);
        $entityManager->flush();
        return $this->json("StoryTag supprime");
    }

    /**
     * @Route("/edit/{id}", name="storyTag", methods={"PUT"})
     */
    public function edit(StoryTagRepository $storyTagRepository, Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        $storyTag = $storyTagRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        if (!$storyTag) {
            throw $this->createNotFoundException(
                'No storyTag found for id ' . $id
            );
        }
        $storyTag->setName($data['name']);
        $entityManager->flush();
        return $this->json("StoryTag edite");
    }
}
