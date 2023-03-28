<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     */

    protected $dontFlash = [
        'current_password',
        'password',
        'phone',
        'email',
        'password_confirmation',
    ];

    function createLog($e) {
        $line = @$e->getTrace()[0]['line'];
      
        $line = @$e->getTrace()[0]['line'];
        $err = "<br/><hr/><ul>\n";
        $err .= "\t<li>date time " . date('Y-M-d H:m', time()) . "</li>\n";
        $err .= "\t<li>error msg: [" . $e->getCode() . '] ' . $e->getMessage() . ' on line ' . $line . ' of file ' . @$e->getTrace()[0]['file'] . "</li>\n";
        $err .= "\t<li>url: " . url()->current() . "</li>\n";
        $err .= "\t<li>Controller route: " . $this->createRoute() . "</li>\n";
        $err .= "\t<li>Error from which host: " . gethostname() . "</li>\n";
        $err .= "\t<li>Error from username: " . session('username') . "</li>\n";
        $err .= "</ul>\n\n";

        $filename ='steam_app' . str_replace('-', '_', date('YM-d')) . '.html';
   // if (!preg_match('/storage/uploads/i', url()->current())){
        error_log($err, 3, dirname(__FILE__) . "/../../storage/logs/" . $filename);
   // }
    }

    /**
     * Report or log an exception.
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     */
    public function report(Throwable $exception) {
        $this->createLog($exception);
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, \Throwable $exception) {
        $this->createLog($exception);
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return redirect()->guest(route('login'));
        }else{
         //  return redirect('error')->with(['error' => 'Error Occured Please Try Again!!', 'urls' => url()->current()]);
        }
       return parent::render($request, $exception);
    }
   
    /**
     * Convert an authentication exception into an unauthenticated response.
     */

    protected function unauthenticated($request, AuthenticationException $exception) {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return redirect()->guest(route('login'));
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

        public function createRoute() {
            $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
            $url_param = explode('/', $url);
            $controller = isset($url_param[1]) && !empty($url_param[1]) ? $url_param[1] : '/';
            $method = isset($url_param[2]) && !empty($url_param[2]) ? $url_param[2] : 'index';
            $view = $method == 'view' ? 'show' : $method;

            return in_array($controller, array('public', 'storage')) ? NULL : $controller . '@' . $view;
        }
}
