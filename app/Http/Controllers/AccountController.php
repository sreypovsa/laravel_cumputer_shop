<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Guest: login & register
    |--------------------------------------------------------------------------
    */

    public function showLogin(Request $request): View
    {
        $this->rememberRedirect($request);

        return view('frontend.account.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'These credentials do not match our records.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('account.index'))
            ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
    }

    public function showRegister(Request $request): View
    {
        $this->rememberRedirect($request);

        return view('frontend.account.register');
    }

    /**
     * Send the customer back to a page on this site (e.g. ?redirect=/checkout) after signing in.
     * Only local paths are accepted so the parameter cannot be used as an open redirect.
     */
    private function rememberRedirect(Request $request): void
    {
        $to = (string) $request->query('redirect', '');

        if ($to !== '' && str_starts_with($to, '/') && !str_starts_with($to, '//') && !str_contains($to, '\\')) {
            $request->session()->put('url.intended', url($to));
        }
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'phone' => 'nullable|string|max:50',
            'password' => ['required', 'confirmed', Password::min(8)],
            'terms' => 'accepted',
        ], [
            'terms.accepted' => 'Please accept the terms to create an account.',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
            'is_admin' => false,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('account.index'))
            ->with('success', 'Your account has been created. Welcome to QuickTech!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been signed out.');
    }

    /*
    |--------------------------------------------------------------------------
    | Authenticated: account area
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $user = $request->user();
        $orders = $user->orders()->withCount('items')->latest()->paginate(10);

        $stats = [
            'total' => $user->orders()->count(),
            'active' => $user->orders()->whereNotIn('order_status', ['delivered', 'cancelled'])->count(),
            'spent' => $user->orders()->where('payment_status', 'paid')->sum('total'),
        ];

        return view('frontend.account.index', compact('user', 'orders', 'stats'));
    }

    public function showOrder(Request $request, string $orderNumber): View
    {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return view('frontend.account.order', compact('order'));
    }

    public function profile(Request $request): View
    {
        return view('frontend.account.profile', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:191',
            'email' => ['required', 'email', 'max:191', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => 'nullable|string|max:50',
        ]);

        $user->update($data);

        return back()->with('success', 'Your profile has been updated.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Your current password is incorrect.',
        ]);

        $request->user()->update(['password' => $request->password]);

        return back()->with('success', 'Your password has been changed.');
    }
}
