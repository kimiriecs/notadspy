<?php declare(strict_types=1);

namespace Tests\Unit\Modules\AdSpy\Mail;

use App\Exception\InvalidCurrencyFormatException;
use App\Exception\InvalidNumberFormatException;
use App\Exception\InvalidTitleFormatException;
use App\Exception\InvalidUrlFormatException;
use App\Modules\AdSpy\Dto\PriceActualization\NewPriceMailData;
use App\Modules\AdSpy\Enum\CurrencySymbol;
use App\Modules\AdSpy\Mail\PriceSubscriptionMail;
use App\Modules\User\Entities\User;
use App\ValueObject\ImageUrl;
use App\ValueObject\NotNegativeInteger;
use App\ValueObject\Price;
use App\ValueObject\Title;
use App\ValueObject\Url;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Class NewPriceMailTest
 *
 * @package Tests\Unit\Modules\AdSpy\Mail
 */
class NewPriceMailTest extends TestCase
{
    /**
     * @return array[]
     * @throws InvalidCurrencyFormatException
     * @throws InvalidNumberFormatException
     * @throws InvalidTitleFormatException
     * @throws InvalidUrlFormatException
     */
    public static function contentDataProvider(): array
    {
        return [
            [
                'newPriceData' => new NewPriceMailData(
                    advertId: NotNegativeInteger::fromNumber(1),
                    advertTitle: Title::make('Title'),
                    advertImageUrl: ImageUrl::make('https://image.url'),
                    advertUrl: Url::make('https://advert.url'),
                    oldPrice: new Price(amount: 100, currency: CurrencySymbol::USD->name),
                    newPrice: new Price(amount: 50, currency: CurrencySymbol::USD->name),
                ),
            ]
        ];
    }

    /**
     * @param NewPriceMailData $newPriceData
     * @return void
     */
    #[DataProvider('contentDataProvider')]
    public function test_mailable_content(NewPriceMailData $newPriceData): void
    {
        $user = User::factory()->create();
        $mailable = new PriceSubscriptionMail($user, $newPriceData);
        $mailable->assertFrom(new Address(config('mail.from.address'), config('mail.from.name')));
        $mailable->assertTo($user->email);
        $mailable->assertHasSubject('Price Subscription Mail');

        $mailable->assertSeeInHtml($user->name);
        $mailable->assertSeeInHtml($newPriceData->getAdvertUrl()->value());
        $mailable->assertSeeInHtml($newPriceData->getAdvertImageUrl()->value());
        $mailable->assertSeeInHtml($newPriceData->getAdvertTitle()->value());
        $mailable->assertSeeInOrderInHtml([
            (string) $newPriceData->getOldPrice(),
            (string) $newPriceData->getNewPrice(),
        ]);
    }

    /**
     * @param NewPriceMailData $newPriceData
     * @return void
     */
    #[DataProvider('contentDataProvider')]
    public function test_mails_can_be_sent(NewPriceMailData $newPriceData): void
    {
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();
        $thirdUser = User::factory()->create();
        $mailable = new PriceSubscriptionMail($firstUser, $newPriceData);
        $firstRecipient = new Address($firstUser->email, $firstUser->name);
        $secondRecipient = new Address($secondUser->email, $secondUser->name);
        $thirdRecipient = new Address($thirdUser->email, $thirdUser->name);
        Mail::fake();
        Mail::assertNothingSent();
        Mail::to($firstRecipient)->send($mailable);
        Mail::to($secondRecipient)->send($mailable);
        Mail::to($thirdRecipient)->send($mailable);
        Mail::assertSent(PriceSubscriptionMail::class, [
            $firstUser->email,
            $secondUser->email,
            $thirdUser->email,
        ]);
        Mail::assertSentCount(3);
    }
}
