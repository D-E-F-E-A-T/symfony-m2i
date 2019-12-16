<?php


namespace App\Form\DataTransformer;


use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Proxies\__CG__\App\Entity\Author;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagCollectionToStringDataTranformer implements DataTransformerInterface
{
    const SEPRATOR = ', ';
    /**
     * @var tagRepository
     */

    private $tagRepository;

    /**
     * TagCollectionToStringDataTranformer constructor.
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }


    /**
     * @param ArrayCollection $tagCollection
     * @return mixed|void
     * @throws TransformationFailedException when the transformation fails
     */
    public function transform($tagCollection)
    {
        $tagArray = $tagCollection->toArray();

        return implode(self::SEPRATOR, $tagArray);
    }

    /**
     * @param mixed  The value in the transformed representation
     *
     * @return mixed The value in the original representation
     *
     * @throws TransformationFailedException when the transformation fails
     * @inheritDoc
     */
    public function reverseTransform($tagString)
    {
        if(empty($tagString)){
            return [];
        }
        $tagNameArray = array_unique(
            array_map(
                'trim',
                explode(self::SEPRATOR, $tagString)
            )
        );

        $tags = [];

        foreach ($tagNameArray as $tagName){

            $tag = $this->tagRepository->findOneBy(['tagName' => $tagName]);

            if($tag == null){
                $tag = new Tag();
                $tag->setTagName($tagName);
            }

            array_push($tags, $tag);
        }
        return $tags;
    }
}