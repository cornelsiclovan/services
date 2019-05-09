<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.05.2019
 * Time: 11:00
 */

namespace App\Entity;
interface PublishedDateEntityInterface
{
    public function setPublished(\DateTimeInterface $published): PublishedDateEntityInterface;
}