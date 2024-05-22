<?php

namespace App\Entity;

use App\Repository\ServiceAutoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceAutoRepository::class)]
class ServiceAuto extends Service
{





    
}
