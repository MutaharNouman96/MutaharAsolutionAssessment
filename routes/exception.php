<?php 
// routes/exception.php
use Illuminate\Auth\AuthenticationException;

return [
    AuthenticationException::class => fn ($e) => response()->json(['error' => 'Unauthorized'], 401),
];
