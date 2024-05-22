<?php

namespace App\Entity;

use App\Repository\ServiceLifeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceLifeRepository::class)]
class ServiceLife extends Service
{



}
