<?php declare(strict_types=1);

namespace App\Modules\AdSpy\Http\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

/**
 * Class AdvertController
 *
 * @package App\Modules\AdSpy\Http\Controller
 */
class AdvertController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return redirect()->intended(route('subscriptions', absolute: false));
    }
}
