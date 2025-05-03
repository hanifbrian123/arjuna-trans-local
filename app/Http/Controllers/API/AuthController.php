<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Traits\ApiResponser;
use App\Http\Resources\UserResource;
use App\Http\Requests\API\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * @group Autentikasi
 *
 * API untuk autentikasi pengguna
 */
class AuthController extends Controller
{
    use ApiResponser;

    /**
     * Login pengguna dan membuat token
     *
     * Endpoint ini digunakan untuk login pengguna dan membuat token akses.
     * Hanya pengguna dengan role admin yang dapat login melalui API.
     *
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Kredensial yang diberikan tidak valid', 401);
        }

        // Check if user has admin role
        if (!$user->hasRole('admin')) {
            return $this->unauthorizedResponse('Tidak memiliki izin. Akses admin diperlukan.');
        }

        // Revoke all existing tokens
        $user->tokens()->delete();

        // Create new token
        $token = $user->createToken('admin-token')->plainTextToken;

        return $this->successResponse([
            'user' => new UserResource($user),
            'token' => $token,
        ], 'Login berhasil');
    }

    /**
     * Mendapatkan profil pengguna yang terautentikasi
     *
     * Endpoint ini digunakan untuk mendapatkan informasi profil pengguna yang sedang login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        return $this->successResponse(
            new UserResource($request->user()),
            'Profil pengguna berhasil dimuat'
        );
    }

    /**
     * Logout pengguna (mencabut token)
     *
     * Endpoint ini digunakan untuk logout pengguna dan mencabut token akses yang sedang digunakan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'Logout berhasil');
    }

    /**
     * Mengirim link reset password
     *
     * Endpoint ini digunakan untuk mengirim link reset password ke email pengguna.
     * Hanya pengguna dengan role admin yang dapat menggunakan fitur ini.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if user exists and has admin role
        $user = User::where('email', $request->email)->first();
        if (!$user || !$user->hasRole('admin')) {
            return $this->notFoundResponse('Kami tidak dapat menemukan pengguna dengan alamat email tersebut.');
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return $this->successResponse(null, __($status));
        }

        return $this->errorResponse(__($status), 400);
    }

    /**
     * Reset password
     *
     * Endpoint ini digunakan untuk melakukan reset password pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return $this->successResponse(null, __($status));
        }

        return $this->errorResponse(__($status), 400);
    }
}
