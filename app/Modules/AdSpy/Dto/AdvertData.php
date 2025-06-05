<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Dto;

use App\Modules\AdSpy\ValueObject\ImageUrl;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;
use App\Modules\AdSpy\ValueObject\Title;
use App\Modules\AdSpy\ValueObject\Url;
use DateTimeImmutable;
use JsonSerializable;

/**
 * Class AdvertData
 *
 * @package App\Modules\AdSpy\Dto
 */
readonly class AdvertData implements JsonSerializable
{
    /**
     * @param Title $title
     * @param Url $url
     * @param ImageUrl $imageUrl
     * @param DateTimeImmutable $postedAt
     * @param PriceData $price
     * @param NotNegativeInteger|null $id
     */
    public function __construct(
        private Title $title,
        private Url $url,
        private ImageUrl $imageUrl,
        private DateTimeImmutable $postedAt,
        private PriceData $price,
        private ?NotNegativeInteger $id = null
    ) {
    }

    /**
     * @return NotNegativeInteger|null
     */
    public function getId(): ?NotNegativeInteger
    {
        return $this->id;
    }

    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }

    /**
     * @return Url
     */
    public function getUrl(): Url
    {
        return $this->url;
    }

    /**
     * @return ImageUrl
     */
    public function getImageUrl(): ImageUrl
    {
        return $this->imageUrl;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getPostedAt(): DateTimeImmutable
    {
        return $this->postedAt;
    }

    /**
     * @return PriceData
     */
    public function getPrice(): PriceData
    {
        return $this->price;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId()->asInt(),
            'title' => $this->getTitle()->value(),
            'url' => $this->getUrl()->value(),
            'image_url' => $this->getImageUrl()->value(),
            'price' => $this->getPrice()->jsonSerialize(),
            'posted_at' => $this->getPostedAt()->format('Y-m-d H:i'),
        ];
    }
}
