<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/','/login');

Route::get('/login',function(){
   return view('auth.login'); 
});

Route::get('/register',function(){
   return view('auth.register'); 
});

Route::get('/admin',function(){
   return view('admin.index'); 
});

Route::get('/home',function(){
   return view('page.index'); 
});

