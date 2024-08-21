<h1>Middleware</h1>
<h2> What is Middleware?</h2>
<h3>Middleware in Laravel is a mechanism that filters HTTP requests entering your application. It allows you to perform actions on requests before they reach your controllers or after the responses are sent back to the client. Middleware can be used for tasks like authentication, logging, modifying requests, and more.</h3>

<h2> How Does Middleware Work?</h2>
<h3 >When a request is made to a Laravel application, it passes through a series of middleware layers before reaching the route or controller. Each middleware can inspect, modify, or reject the request and/or response. After processing, the middleware can also modify the response before it is sent back to the user.</h3>

<h2>Creating Middleware</h2>

To create a new middleware, use the make:middleware Artisan command:

php artisan make:middleware EnsureTokenIsValid

This command will place a new EnsureTokenIsValid class within your app/Http/Middleware directory. In this middleware, we will only allow access to the route if the supplied token input matches a specified value. Otherwise, we will redirect the users back to the /home URI:

<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->input('token') !== 'my-secret-token') {
            return redirect('/home');
        }
 
        return $next($request);
    }
}

As you can see, if the given token does not match our secret token, the middleware will return an HTTP redirect to the client; otherwise, the request will be passed further into the application. To pass the request deeper into the application (allowing the middleware to "pass"), you should call the $next callback with the $request.

It's best to envision middleware as a series of "layers" HTTP requests must pass through before they hit your application. Each layer can examine the request and even reject it entirely.

<h2>Middleware and Responses</h2>
Of course, a middleware can perform tasks before or after passing the request deeper into the application. For example, the following middleware would perform some task before the request is handled by the application:

<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class BeforeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Perform action
 
        return $next($request);
    }
}

However, this middleware would perform its task after the request is handled by the application:

<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class AfterMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
 
        // Perform action
 
        return $response;
    }
}


<h2>Types of Middleware</h2>
1. Global Middleware
Definition:
Global middleware is applied to all HTTP requests entering your application. It’s a way to ensure that certain processing happens for every request regardless of the route or controller.

Configuration:
You define global middleware in the $middleware property of the app/Http/Kernel.php file.
Example Configuration:

php

protected $middleware = [
    \App\Http\Middleware\CheckForMaintenanceMode::class,
    \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
    \App\Http\Middleware\TrimStrings::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
];
Typical Uses:

Handling maintenance mode
Enforcing HTTPS
Trimming request strings

2. Route Middleware
Definition:
Route middleware is applied to specific routes or route groups. This type of middleware is used when you want to apply certain logic only to particular routes.

Configuration:
You register route middleware in the $routeMiddleware array of the app/Http/Kernel.php file.

Example Configuration:

php

protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'admin' => \App\Http\Middleware\CheckAdmin::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
];

Typical Uses:

Authentication (e.g., auth)
Authorization (e.g., admin)
Rate limiting (e.g., throttle)
Ensuring email verification (e.g., verified)


3. Middleware Groups
Definition:
Middleware groups are a way to bundle multiple middleware into a single group, allowing you to apply multiple middleware to routes more conveniently.

Configuration:
Middleware groups are defined in the $middlewareGroups property of app/Http/Kernel.php.

Example Configuration:

php

protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],

    'api' => [
        'throttle:api',
        'bindings',
    ],
];
Typical Uses:

Web Middleware Group: Includes middleware for session handling, CSRF protection, and more, and is applied to routes defined in web.php.
API Middleware Group: Includes middleware for API rate limiting and other API-specific functionality, and is applied to routes defined in api.php.


4. Custom Middleware
Definition:
Custom middleware refers to any middleware that you create to handle specific logic that isn’t covered by the default middleware.

How to Create:
You can generate custom middleware using the Artisan command:

bash

php artisan make:middleware CustomMiddleware
Configuration:
After creating custom middleware, you need to register it either globally or as route middleware in the app/Http/Kernel.php file.

Example Usage:

php

// In app/Http/Kernel.php
protected $routeMiddleware = [
    'custom' => \App\Http\Middleware\CustomMiddleware::class,
];

// In routes/web.php or routes/api.php
Route::get('/custom-route', 'CustomController@method')->middleware('custom');

<h2>Terminable Middleware</h2>
Sometimes a middleware may need to do some work after the HTTP response has been sent to the browser. If you define a terminate method on your middleware and your web server is using FastCGI, the terminate method will automatically be called after the response is sent to the browser:

<?php
 
namespace Illuminate\Session\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class TerminatingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
 
    /**
     * Handle tasks after the response has been sent to the browser.
     */
    public function terminate(Request $request, Response $response): void
    {
        // ...
    }
}

The terminate method should receive both the request and the response. Once you have defined a terminable middleware, you should add it to the list of routes or global middleware in your application's bootstrap/app.php file.

When calling the terminate method on your middleware, Laravel will resolve a fresh instance of the middleware from the service container. If you would like to use the same middleware instance when the handle and terminate methods are called, register the middleware with the container using the container's singleton method. Typically this should be done in the register method of your AppServiceProvider:

use App\Http\Middleware\TerminatingMiddleware;
 
/**
 * Register any application services.
 */
public function register(): void
{
    $this->app->singleton(TerminatingMiddleware::class);

}

<h2>Middleware Aliases</h2>
You may assign aliases to middleware in your application's bootstrap/app.php file. Middleware aliases allow you to define a short alias for a given middleware class, which can be especially useful for middleware with long class names:

use App\Http\Middleware\EnsureUserIsSubscribed;
 
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'subscribed' => EnsureUserIsSubscribed::class
    ]);
})

Once the middleware alias has been defined in your application's bootstrap/app.php file, you may use the alias when assigning the middleware to routes:

Route::get('/profile', function () {
    // ...
})->middleware('subscribed');

Summary
Middleware in Laravel is a powerful tool for filtering HTTP requests and responses. It allows you to run code before and after requests reach your controllers, making it easier to manage cross-cutting concerns such as authentication, logging, and more. By creating and using middleware, you can keep your application organized and ensure that only authorized users can access specific routes.



