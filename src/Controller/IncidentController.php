<?php

namespace App\Controller;

use App\Entity\Incident;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class IncidentController extends AbstractController
{
    private $entityManager;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @Route("/send-incident", name="send_incident", methods={"POST"})
     */
    public function sendIncident(HubInterface $hub): JsonResponse
    {
        // Données à envoyer
        $incidentData = [
            'id' => 1,
            'title' => 'New Incident',
            'description' => 'An incident has occurred.',
            'timestamp' => time(),
        ];

        // Créer une mise à jour Mercure
        $update = new Update(
            'https://example.com/incidents', // Topic (sujet)
            json_encode($incidentData)       // Données à publier
        );

        // Publier la mise à jour via Mercure
        $hub->publish($update);

        return new JsonResponse(['status' => 'Data sent to Mercure']);
    }

    /**
     * Poster un nouvel incident.
     */
    #[Route('/api/incidents/post', name: 'post', methods: ['POST'])]
    public function postIncident(Request $request, HubInterface $hub): JsonResponse
    {
        // Récupérer les données de la requête
        $data = json_decode($request->getContent(), true);

        // Valider les données
        if (!isset($data['temp']) || !isset($data['humedite'])) {
            return new JsonResponse(['error' => 'Temp and humedite are required'], 400);
        }

        // Créer un nouvel incident
        $incident = new Incident();
        $incident->setTemp($data['temp']);
        $incident->setHumedite($data['humedite']);
        $incident->setDateTime(new \DateTime());

        // Valider l'entité Incident
        $errors = $this->validator->validate($incident);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['error' => 'Validation failed', 'messages' => $errorMessages], 400);
        }

        // Enregistrer l'incident en base de données
        try {
            $this->entityManager->persist($incident);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Failed to save incident', 'message' => $e->getMessage()], 500);
        }

        // Publier l'incident via Mercure
        $update = new Update(
            'https://example.com/incidents', // Topic (sujet)
            json_encode([
                'id' => $incident->getId(),
                'temp' => $incident->getTemp(),
                'humedite' => $incident->getHumedite(),
                'dateTime' => $incident->getDateTime()->format('Y-m-d H:i:s'),
            ])
        );

        $hub->publish($update);

        return new JsonResponse(['status' => 'Incident created', 'id' => $incident->getId()], 201);
    }

    /**
     * Récupérer la liste des incidents.
     */
    #[Route('/api/incidents/list', name: 'list', methods: ['GET'])]
    public function listIncidents(): JsonResponse
    {
        // Récupérer tous les incidents depuis la base de données
        $incidents = $this->entityManager->getRepository(Incident::class)->findAll();

        // Formater les données pour la réponse
        $data = [];
        foreach ($incidents as $incident) {
            $data[] = [
                'id' => $incident->getId(),
                'temp' => $incident->getTemp(),
                'humedite' => $incident->getHumedite(),
                'dateTime' => $incident->getDateTime()->format('Y-m-d H:i:s'),
            ];
        }

        return new JsonResponse($data);
    }
}