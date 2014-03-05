<?php

//
// Accounts & Management
//
Route::resource('accounts', 'AccountsController');
Route::resource('accounts.transactions', 'TransactionsController');