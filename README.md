# 🏡 Inmobirovira

> **Plataforma Web Inmobiliaria para la Provincia de García Rovira**  
> Desarrollado en el marco del programa de formación de Análisis y Desarrollo de Software (ADSO)  
> **Centro Agroempresarial y Turístico de los Andes — SENA Regional Santander (Málaga)**

---

[![Laravel](https://img.shields.io/badge/Laravel-11%2F12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white)](https://alpinejs.dev)
[![Leaflet](https://img.shields.io/badge/Leaflet-199900?style=for-the-badge&logo=leaflet&logoColor=white)](https://leafletjs.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge)](LICENSE)

---

## 📌 1. Descripción del Proyecto

**Inmobirovira** es una solución digital integral creada para satisfacer la necesidad de comercialización, visibilidad y gestión inmobiliaria de las **Mipymes y propietarios independientes** del área de influencia del **Centro Agroempresarial y Turístico de los Andes** en la provincia de García Rovira (Málaga, Capitanejo, Concepción, Enciso, San José de Miranda, Cerrito, Carcasí, Macaravita, San Miguel, Guaca, Cepitá y Molagavita).

### 🎯 Problema que resuelve
Históricamente, la oferta de bienes raíces en la provincia se ha gestionado de forma informal o fragmentada a través de grupos de redes sociales, carteles físicos y el voz a voz, dificultando que compradores, arrendatarios e inversionistas encuentren inmuebles verificados con información georreferenciada, fotos reales y precios claros.

**Inmobirovira** centraliza este ecosistema en una plataforma moderna, ágil y adaptable que ofrece:
- **Portal Público de Exploración:** Catálogo con filtros avanzados por municipio, tipo de inmueble, tipo de oferta (Venta / Arriendo), rango de precio y características específicas.
- **Geolocalización Satelital e Interactiva:** Mapas interactivos con Leaflet.js, vista de satélite de alta resolución, pines GPS exactos, cálculo de rutas («Cómo llegar») y vista de calle 360° (Street View).
- **Formularios Dinámicos Inteligentes:** Los campos del inmueble se adaptan automáticamente según la tipología (Lote, Local Comercial, Finca Campestre, Apartamento, Casa), evitando campos innecesarios y garantizando fichas técnicas limpias.
- **Panel Exclusivo para Empresas Inmobiliarias:** Portal privado donde las agencias gestionan su propio inventario, estadísticas de disponibilidad y perfil comercial.
- **Panel Administrativo General:** Métricas inmobiliarias en tiempo real con gráficos estadísticos (Chart.js), auditoría y gestión global de catálogo.
- **Módulo de Seguridad Robusto:** Control de acceso basado en roles y permisos (RBAC) con Spatie Laravel-Permission.
- **Conexión Directa por WhatsApp:** Enlace con un clic para contactar directamente a la empresa o asesor responsable sin intermediarios engorrosos.

---

## 🏗️ 2. Arquitectura de Software

El proyecto sigue una arquitectura por capas desacoplada para garantizar mantenibilidad, testeabilidad y cumplimiento de los estándares de la industria y la rúbrica técnica:

```text
[ Cliente / Navegador ]
         │
         ▼
[ Rutas (routes/web.php & routes/seguridad.php) ]  <─── Protegidas con Middleware (auth, can, throttle)
         │
         ▼
[ Controladores Livianos (app/Http/Controllers) ]  <─── Validación con Form Requests (app/Http/Requests)
         │
         ▼
[ Capa de Servicios (app/Services) ]               <─── Concentra la lógica de negocio
         │
         ▼
[ Capa de Repositorios (app/Repositories) ]        <─── Encapsula el acceso a datos Eloquent
         │
         ▼
[ Modelos Eloquent & Base de Datos SQLite/MySQL ]
```

- **Controladores Livianos:** Reciben las peticiones HTTP, validan a través de `FormRequest` y delegan la lógica en los servicios correspondientes.
- **Vistas con Blade:** Uso de layouts reutilizables (`layouts.publico`, `layouts.empresa`, `seguridad.layout`), componentes Blade (`x-stat-card`, `x-publico.tarjeta-inmueble`) sin lógica de negocio ni consultas directas a base de datos.
- **Estándar de Codificación:** Código estructurado bajo las directrices **PSR-12** y convenciones de Laravel.

---

## 💻 3. Requisitos del Sistema

Antes de iniciar la instalación, asegúrate de tener instalado en tu entorno de desarrollo:

- **PHP:** 8.2 o superior (con extensiones `pdo`, `sqlite3` / `pdo_mysql`, `mbstring`, `openssl`, `curl`)
- **Composer:** 2.x
- **Node.js:** 18.x o superior & **NPM**
- **Servidor Local / Entorno:** Laravel Herd, Laragon, XAMPP o PHP CLI Server
- **Git**

---

## 🚀 4. Guía de Instalación Paso a Paso

Sigue estas instrucciones en tu terminal para poner en marcha el proyecto localmente:

### Paso 1: Clonar el repositorio
```bash
git clone https://github.com/tu-usuario/inmobirovira.git
cd inmobirovira
```

### Paso 2: Instalar dependencias de PHP (Backend)
```bash
composer install
```

### Paso 3: Instalar dependencias de JavaScript y compilar assets (Frontend)
```bash
npm install
npm run build
```
*(Opcional para desarrollo activo: `npm run dev`)*

### Paso 4: Configurar el archivo de entorno (.env)
Copia el archivo de ejemplo y genera la clave de aplicación:
```bash
# En Windows (PowerShell / CMD):
copy .env.example .env

# En Linux / macOS:
cp .env.example .env

# Generar la llave única de cifrado:
php artisan key:generate
```

### Paso 5: Crear el enlace simbólico para imágenes
Permite que las fotos cargadas de los inmuebles sean visibles públicamente en el navegador:
```bash
php artisan storage:link
```

### Paso 6: Ejecutar migraciones y sembrar datos de prueba (Seeders)
Este comando creará todas las tablas en la base de datos (municipios, barrios de Málaga, tipos de inmueble, roles, permisos y el usuario administrador):
```bash
php artisan migrate:fresh --seed
```

### Paso 7: Iniciar el servidor local
```bash
php artisan serve
```
El portal estará disponible inmediatamente en: **`http://127.0.0.1:8000`** (o a través de su dominio virtual de Laravel Herd: `http://inmobirovira.test`).

---

## 🔑 5. Credenciales de Acceso por Defecto

Para que los evaluadores puedan probar todos los módulos y niveles de acceso:

| Rol | Correo Electrónico | Contraseña | URL de Ingreso | Permisos / Alcance |
| :--- | :--- | :--- | :--- | :--- |
| **Administrador del Sistema** | `admin@admin.com` | `12345678` | `/login` | Control total: Dashboard general (`/admin`), Seguridad (`/seguridad/roles`), Gestión de Cuentas, Municipios, Barrios, Tipos e Inmuebles. |
| **Empresa Inmobiliaria** | *Crear o registrar desde panel* | *Asignada en creación* | `/login` | Acceso al Portal Empresa (`/empresa`): gestión exclusiva de sus inmuebles, publicación con GPS, edición y métricas propias. |
| **Usuario Público** | *Sin autenticación* | *N/A* | `/` | Exploración libre, filtros, detalle con satélite y contacto por WhatsApp. |

---

## 🗂️ 6. Estructura de Módulos del Sistema

| Módulo | Ruta Principal | Descripción |
| :--- | :--- | :--- |
| **Portal Público** | `/` | Vista de inicio con buscador, filtros, tarjetas de inmuebles y detalle interactivo con Leaflet. |
| **Dashboard Admin** | `/admin` | Métricas generales, gráficos estadísticos (Chart.js) de publicaciones y distribución municipal. |
| **Gestión de Inmuebles** | `/inmueble` | CRUD administrativo de propiedades con carga múltiple de fotos y geolocalización satelital. |
| **Portal Empresa** | `/empresa` | Panel privado exclusivo para inmobiliarias afiliadas. |
| **Módulo de Seguridad** | `/seguridad/roles` | Control de Roles, Permisos, Cuentas de usuario y asignación RBAC. |
| **Parámetros Geográficos** | `/municipio` y `/barrio` | Catálogo de municipios de Santander y barrios de la provincia. |

---

## 🧪 7. Pruebas y Calidad

Para ejecutar la suite de pruebas automatizadas del proyecto:
```bash
php artisan test
```

Para verificar el cumplimiento del estándar de codificación (PSR-12):
```bash
./vendor/bin/pint --test
```

---

## 👥 8. Equipo de Desarrollo y Créditos

- **Proyecto Formativo:** Inmobirovira
- **Centro:** Centro Agroempresarial y Turístico de los Andes
- **Regional:** SENA Regional Santander — Málaga
- **Programa:** Análisis y Desarrollo de Software (ADSO)

---

## 📄 9. Licencia

Este proyecto está bajo la licencia [MIT](LICENSE).
