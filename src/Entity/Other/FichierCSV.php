<?php

namespace App\Entity\Other;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class FichierCSV
{
    /**
     * @Assert\File(mimeTypes={ "text/csv", "application/vnd.ms-excel" })
     * @var File|null
     */
    private $file;

    /**
     * @return File|null
     */
    public function getFile() : ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file): void
    {
        $this->$file = $file;
    }
}