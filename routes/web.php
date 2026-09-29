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
   return view('books.index'); 
});
Route::get('/admin/borrowings',function(){
   return view('borrowings.index'); 
});
Route::get('/admin/categories',function(){
   return view('categories.index'); 
});

Route::get('/home',function(){
   return view('page.index'); 
});

