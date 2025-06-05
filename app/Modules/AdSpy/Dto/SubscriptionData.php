<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Dto;

use App\Modules\AdSpy\Enum\SubscriptionStatus;
use App\Modules\AdSpy\ValueObject\Email;
use App\Modules\AdSpy\ValueObject\NotNegativeInteger;
use DateTimeImmutable;

/**
 * Class SubscriptionData
 *
 * @package App\Modules\AdSpy\Dto
 */
readonly class SubscriptionData
{
    /**
     * @param NotNegativeInteger $userId
     * @param NotNegativeInteger $advertId
     * @param Email $notificationEmail
     * @param DateTimeImmutable $notificationEmailVerifiedAt
     * @param SubscriptionStatus $status
     * @param NotNegativeInteger|null $id
     */
    public function __construct(
        private NotNegativeInteger $userId,
        private NotNegativeInteger $advertId,
        private Email $notificationEmail,
        private DateTimeImmutable $notificationEmailVerifiedAt,
        private SubscriptionStatus $status,
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
     * @return NotNegativeInteger
     */
    public function getUserId(): NotNegativeInteger
    {
        return $this->userId;
    }

    /**
     * @return NotNegativeInteger
     */
    public function getAdvertId(): NotNegativeInteger
    {
        return $this->advertId;
    }

    /**
     * @return Email
     */
    public function getNotificationEmail(): Email
    {
        return $this->notificationEmail;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getNotificationEmailVerifiedAt(): DateTimeImmutable
    {
        return $this->notificationEmailVerifiedAt;
    }

    /**
     * @return SubscriptionStatus
     */
    public function getStatus(): SubscriptionStatus
    {
        return $this->status;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId()?->asInt(),
            'user_id' => $this->getUserId()->asInt(),
            'advert_id' => $this->getAdvertId()->asInt(),
            'notification_email' => $this->getNotificationEmail()->value(),
            'notification_email_verified_at' => $this->getNotificationEmailVerifiedAt()->format('Y-m-d'),
            'status' => $this->getStatus()->value,
        ];
    }
}
