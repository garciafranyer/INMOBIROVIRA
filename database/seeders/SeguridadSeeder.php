<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SeguridadSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = config('seguridad.guard');

        $permisoAdmin = Permission::firstOrCreate(
            ['name' => config('seguridad.permiso_admin'), 'guard_name' => $guard],
            ['modulo' => 'seguridad']
        );

        if ($permisoAdmin->modulo === null) {
            $permisoAdmin->update(['modulo' => 'seguridad']);
        }

        $rolAdmin = Role::firstOrCreate(
            ['name' => config('seguridad.rol_admin'), 'guard_name' => $guard],
            ['activo' => true]
        );
        $rolAdmin->update(['activo' => true]);
        $rolAdmin->syncPermissions(Permission::where('guard_name', $guard)->get());

        $modelo = config('auth.providers.users.model');
        $datos = config('seguridad.admin');

        $admin = $modelo::firstOrCreate(
            ['email' => $datos['email']],
            [
                'nombre' => $datos['name'],
                'telefono' => $datos['telefono'] ?? '',
                'direccion' => $datos['direccion'] ?? '',
                'password' => Hash::make($datos['password']),
            ]
        );
        $admin->assignRole($rolAdmin);

        // Crear Rol y Usuario Empresa de prueba
        $rolEmpresa = Role::firstOrCreate(
            ['name' => 'Empresa', 'guard_name' => $guard],
            ['activo' => true]
        );

        $empresa = $modelo::firstOrCreate(
            ['email' => 'empresa@inmobirovira.com'],
            [
                'nombre' => 'Inmobiliaria Los Andes S.A.S.',
                'telefono' => '3103451093',
                'direccion' => 'Carrera 8 # 11-24, Centro, Málaga',
                'password' => Hash::make('12345678'),
            ]
        );
        $empresa->assignRole($rolEmpresa);

        // Crear Rol y Usuario Regular (Propietario Particular) de prueba
        $rolUsuario = Role::firstOrCreate(
            ['name' => 'usuario', 'guard_name' => $guard],
            ['activo' => true]
        );

        $usuarioRegular = $modelo::firstOrCreate(
            ['email' => 'usuario@inmobirovira.com'],
            [
                'nombre' => 'Carlos Rueda (Propietario)',
                'telefono' => '3157891234',
                'direccion' => 'Barrio El Rosal, Málaga',
                'password' => Hash::make('12345678'),
            ]
        );
        $usuarioRegular->assignRole($rolUsuario);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
