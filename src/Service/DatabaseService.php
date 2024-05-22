<?php
namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\DBAL\Connection;

class DatabaseService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllTables(): array
    {
        $tables = $this->entityManager->getConnection()->getSchemaManager()->listTableNames();

        return $tables;
    }
    public function listTables()
    {
        $allTables = $this->getAllTables();
        $filteredTables = array_filter($allTables, function ($table) {
            return $table !== 'messenger_messages';
        });

        return 
             $filteredTables ;
    
    }
}
?>
