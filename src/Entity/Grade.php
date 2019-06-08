<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Grade
{
    protected $grades;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
    }

    public function getGrades()
    {
        return $this->grades;
    }
}