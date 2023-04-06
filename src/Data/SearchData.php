<?php

namespace App\Data;

use Doctrine\Common\Collections\Collection;

class SearchData
{
    public ?\DateTime $dateDebut = null;
    public ?\DateTime $dateFin = null;
    public array|Collection $materiels = [];
}