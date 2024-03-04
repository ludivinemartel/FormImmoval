<?php

namespace App\Repository;

use App\Entity\FormTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormTemplate>
 *
 * @method FormTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormTemplate[]    findAll()
 * @method FormTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormTemplate::class);
    }

    public function findRequiredQuestionIds(int $formTemplateId): array
    {
        $requiredQuestionIds = [];

        // Récupérez le formulaire associé aux réponses
        $formTemplate = $this->find($formTemplateId);

        // Vérifiez si le formulaire existe
        if ($formTemplate) {
            // Parcourez les questions associées à ce modèle de formulaire
            foreach ($formTemplate->getFormQuestions() as $question) {
                // Vérifiez si la question est marquée comme obligatoire
                if ($question->isIsRequired()) {
                    // Si oui, ajoutez l'identifiant de la question à la liste des questions obligatoires
                    $requiredQuestionIds[] = $question->getId();
                }
            }
        }
        return $requiredQuestionIds;
    }
}
