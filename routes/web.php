<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/','/login');

Route::get('/login',function(){
   return view('auth.login'); 
});

Route::get('/register',function(){
   return view('auth.register'); 
});

Route::get('/admin/books',function(){
   return view('admin.books'); 
});
Route::get('/admin/borrowings',function(){
   return view('admin.borrowings'); 
});
Route::get('/admin/categories',function(){
   return view('admin.categories'); 
});

Route::get('/home',function(){
   return view('page.index'); 
});

