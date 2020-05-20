<?php

namespace App\Controller;

use App\Entity\Character;
use App\Repository\CardRepository;
use App\Repository\CharacterRepository;
use App\Repository\NemesisRepository;
use App\Repository\StoryTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/character")
 */
class CharacterController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function api(CharacterRepository $characterRepository): Response
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $characters = $characterRepository->findAll();
        $characters = $serializer->serialize($characters, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($characters, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/new", methods={"POST"})
     */
    public function apiNew(Request $request, NemesisRepository $nemesisRepository, StoryTagRepository $storyTagRepository, CardRepository $cardRepository)
    {
        $data = json_decode($request->getContent(), true);
        $character = new Character($data['name'], $data['picture'], $data['buildUp']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($character);
        $entityManager->flush();

        foreach ($data['nemesis'] as $nemesis) {
            $nemesis = $nemesisRepository->find($nemesis);
            $character->addNemesi($nemesis);
            $entityManager->persist($character);
        }
        $entityManager->flush();

        foreach ($data['storyTag'] as $storyTag) {
            $storyTag = $storyTagRepository->find($storyTag);
            $character->addStoryTag($storyTag);
            $entityManager->persist($character);
        }
        $entityManager->flush();

        foreach ($data['card'] as $card) {
            $card = $cardRepository->find($card);
            $character->addCard($card);
            $entityManager->persist($character);
        }
        $entityManager->flush();

        return $this->json($data);
    }

    /**
     * @Route("/{id}",methods={"GET"})
     */
    public function apiDetail(CharacterRepository $characterRepository, $id)
    {
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $characters = $characterRepository->find($id);
        $characters = $serializer->serialize($characters, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($characters, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"})
     */
    public function delete(CharacterRepository $characterRepository, $id)
    {
        $character = $characterRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($character);
        $entityManager->flush();
        return $this->json("Character supprime");
    }

    /**
     * @Route("/edit/{id}", name="character", methods={"PUT"})
     */
    public function edit(CharacterRepository $characterRepository, NemesisRepository $nemesisRepository, StoryTagRepository $storyTagRepository, CardRepository $cardRepository, Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        $character = $characterRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        if (!$character) {
            throw $this->createNotFoundException(
                'No character found for id ' . $id
            );
        }
        $character->setName($data['name']);
        $character->setPicture($data['picture']);
        $character->setBuildUp($data['buildUp']);
        $entityManager->flush();

        foreach ($data['nemesis'] as $nemesis) {
            $nemesis = $nemesisRepository->find($nemesis);
            $character->addNemesi($nemesis);
            $entityManager->persist($character);
        }
        $entityManager->flush();

        foreach ($data['storyTag'] as $storyTag) {
            $storyTag = $storyTagRepository->find($storyTag);
            $character->addStoryTag($storyTag);
            $entityManager->persist($character);
        }
        $entityManager->flush();

        foreach ($data['card'] as $card) {
            $card = $cardRepository->find($card);
            $character->addCard($card);
            $entityManager->persist($character);
        }
        $entityManager->flush();

        return $this->json("Character edite");
    }
}
