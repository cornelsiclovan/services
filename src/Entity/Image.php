<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.05.2019
 * Time: 11:49
 */

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Controller\UploadImageAction;

/**
 * @ORM\Entity()
 * @Vich\Uploadable()
 * @ApiResource(
 *      collectionOperations={
 *          "get",
 *          "post"={
 *              "moethod"="POST",
 *              "path"="/images",
 *              "controller"=UploadImageAction::class,
 *              "defaults"={"_api_receive"=false}
 *          }
 *     }
 * )
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="url")
     * @Assert\NotNull()
     */
    private $file;

    /**
     * @ORM\Column(nullable=true)
     */
    private $url;

    public function getId()
    {
        return $this->id;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }
}