<?php

namespace App\Entity;

use App\Repository\ServicePropertyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicePropertyRepository::class)]
class ServiceProperty extends Service
{



}
