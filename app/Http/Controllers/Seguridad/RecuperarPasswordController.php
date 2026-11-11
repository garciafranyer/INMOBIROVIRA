<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RecuperarPasswordController extends Controller
{
    /**
     * Muestra la vista para solicitar el enlace de restablecimiento.
     */
    public function mostrarFormularioSolicitud(): View
    {
        return view('seguridad.recuperar-password');
    }

    /**
     * Envía el enlace de recuperación al correo electrónico del usuario.
     */
    public function enviarEnlaceRecuperacion(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Por favor ingresa tu correo electrónico.',
            'email.email' => 'El correo electrónico ingresado no es válido.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', '¡Hemos enviado un enlace a tu correo para restablecer tu contraseña!');
        }

        return back()->withErrors([
            'email' => 'No encontramos ningún usuario registrado con ese correo electrónico.',
        ])->withInput($request->only('email'));
    }

    /**
     * Muestra el formulario para escribir la nueva contraseña.
     */
    public function mostrarFormularioRestablecer(Request $request, string $token): View
    {
        return view('seguridad.restablecer-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Restablece la contraseña en la base de datos con cifrado seguro.
     */
    public function restablecerPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', '¡Tu contraseña ha sido restablecida exitosamente! Ya puedes iniciar sesión.');
        }

        return back()->withErrors([
            'email' => 'El enlace de recuperación es inválido o ha expirado. Por favor solicita uno nuevo.',
        ])->withInput($request->only('email'));
    }
}
