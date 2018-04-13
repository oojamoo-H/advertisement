<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;

class SessionStart extends StartSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
//    public function handle($request, Closure $next)
//    {
//        return $next($request);
//    }

    public function getSession(Request $request)
    {
        $session = $this->manager->driver();
        // 判断是否是接口访问并根据实际情况选择 SessionID 的获取方式
        if ($request->headers->has('X-SESSION-TOKEN')) {
            $sessionId = $request->headers->has('X-SESSION-TOKEN');
        } else {
            $sessionId = $request->cookies->get($session->getName());
        }
        print_r($sessionId);
        $session->setId($sessionId);
        return $session;
    }
}
