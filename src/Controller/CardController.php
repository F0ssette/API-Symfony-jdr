<?php

namespace App\Controller;

use App\Entity\Card;
use App\Repository\CardRepository;
use App\Repository\ImprovementRepository;
use App\Repository\PowerTagRepository;
use App\Repository\WeaknessTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/card")
 */
class CardController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function api(CardRepository $cardRepository): Response
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $cards = $cardRepository->findAll();
        $cards = $serializer->serialize($cards, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($cards, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/new", methods={"POST"})
     */
    public function apiNew(Request $request, PowerTagRepository $powerTagRepository, WeaknessTagRepository $weaknessTagRepository, ImprovementRepository $improvementRepository)
    {
        $data = json_decode($request->getContent(), true);
        $card = new Card($data['type'], $data['theme'], $data['title'], $data['misteryIdentity'], $data['attention'], $data['crack']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($card);
        $entityManager->flush();

        foreach ($data['powerTag'] as $powerTag) {
            $powerTag = $powerTagRepository->find($powerTag);
            $card->addPowerTag($powerTag);
            $entityManager->persist($card);
        }
        $entityManager->flush();

        foreach ($data['weaknessTag'] as $weaknessTag) {
            $weaknessTag = $weaknessTagRepository->find($weaknessTag);
            $card->addWeaknessTag($weaknessTag);
            $entityManager->persist($card);
        }
        $entityManager->flush();

        foreach ($data['improvement'] as $improvement) {
            $improvement = $improvementRepository->find($improvement);
            $card->addImprovement($improvement);
            $entityManager->persist($card);
        }
        $entityManager->flush();

        return $this->json($data);
    }

    /**
     * @Route("/{id}",methods={"GET"})
     */
    public function apiDetail(CardRepository $cardRepository, $id)
    {
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $cards = $cardRepository->find($id);
        $cards = $serializer->serialize($cards, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($cards, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"})
     */
    public function delete(CardRepository $cardRepository, $id)
    {
        $card = $cardRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($card);
        $entityManager->flush();
        return $this->json("Card supprime");
    }

    /**
     * @Route("/edit/{id}", name="card", methods={"PUT"})
     */
    public function edit(CardRepository $cardRepository, PowerTagRepository $powerTagRepository, WeaknessTagRepository $weaknessTagRepository, ImprovementRepository $improvementRepository, Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        $card = $cardRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        if (!$card) {
            throw $this->createNotFoundException(
                'No card found for id ' . $id
            );
        }
        $card->setType($data['type']);
        $card->setTheme($data['theme']);
        $card->setTitle($data['title']);
        $card->setMisteryIdentity($data['misteryIdentity']);
        $card->setAttention($data['attention']);
        $card->setCrack($data['crack']);
        $entityManager->flush();

        foreach ($data['powerTag'] as $powerTag) {
            $powerTag = $powerTagRepository->find($powerTag);
            $card->addPowerTag($powerTag);
            $entityManager->persist($card);
        }
        $entityManager->flush();

        foreach ($data['weaknessTag'] as $weaknessTag) {
            $weaknessTag = $weaknessTagRepository->find($weaknessTag);
            $card->addWeaknessTag($weaknessTag);
            $entityManager->persist($card);
        }
        $entityManager->flush();

        foreach ($data['improvement'] as $improvement) {
            $improvement = $improvementRepository->find($improvement);
            $card->addImprovement($improvement);
            $entityManager->persist($card);
        }
        $entityManager->flush();

        return $this->json("Card edite");
    }
}
