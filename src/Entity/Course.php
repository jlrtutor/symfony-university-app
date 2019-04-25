<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 */
class Course
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentCourse", mappedBy="course")
     */
    private $studentCourses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentSubject", mappedBy="course")
     */
    private $studentSubjects;

    public function __construct()
    {
        $this->studentCourses = new ArrayCollection();
        $this->studentSubjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|StudentCourse[]
     */
    public function getStudentCourses(): Collection
    {
        return $this->studentCourses;
    }

    public function addStudentCourse(StudentCourse $studentCourse): self
    {
        if (!$this->studentCourses->contains($studentCourse)) {
            $this->studentCourses[] = $studentCourse;
            $studentCourse->setCourse($this);
        }

        return $this;
    }

    public function removeStudentCourse(StudentCourse $studentCourse): self
    {
        if ($this->studentCourses->contains($studentCourse)) {
            $this->studentCourses->removeElement($studentCourse);
            // set the owning side to null (unless already changed)
            if ($studentCourse->getCourse() === $this) {
                $studentCourse->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StudentSubject[]
     */
    public function getStudentSubjects(): Collection
    {
        return $this->studentSubjects;
    }

    public function addStudentSubject(StudentSubject $studentSubject): self
    {
        if (!$this->studentSubjects->contains($studentSubject)) {
            $this->studentSubjects[] = $studentSubject;
            $studentSubject->setCourse($this);
        }

        return $this;
    }

    public function removeStudentSubject(StudentSubject $studentSubject): self
    {
        if ($this->studentSubjects->contains($studentSubject)) {
            $this->studentSubjects->removeElement($studentSubject);
            // set the owning side to null (unless already changed)
            if ($studentSubject->getCourse() === $this) {
                $studentSubject->setCourse(null);
            }
        }

        return $this;
    }
}
