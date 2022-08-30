<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\DefaultController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\InvoiceController;
use App\Http\Controllers\Backend\PurchaseController;
use App\Http\Controllers\Backend\VetementController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function(){
    
    Route::resource('roles',RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('category/categories', CategoryController::class);
    Route::resource('products',ProductController::class);
    Route::resource('customer/customers',CustomerController::class);
    Route::get('customer/credit',[CustomerController::class, 'creditcustomer'])->name('customers.credit');
    Route::get('customer/paid',[CustomerController::class, 'paidcustomer'])->name('customers.paid');
    Route::get('customer/credit/pdf',[CustomerController::class, 'creditcustomerpdf'])->name('customers.credit.pdf');
    Route::get('customer/paid/pdf',[CustomerController::class, 'paidcustomerpdf'])->name('customers.paid.pdf');
    Route::get('customer/edit_invoice/{invoice_id}',[CustomerController::class, 'edit_invoice'])->name('customers.edit.invoice');
    Route::post('customer/update_invoice/{invoice_id}',[CustomerController::class, 'update_invoice'])->name('customers.update.invoice');
    Route::get('customer/invoice/details/pdf/{invoice_id}',[CustomerController::class,'invoiceDetailsPdf'])->name('invoices.details.pdf');
    Route::get('customer/wise/report',[CustomerController::class, 'wiseReport'])->name('customers.wise.report');
    Route::get('customer/wise/credit/report',[CustomerController::class, 'wiseCredit'])->name('customers.wise.credit.report');
    Route::get('customer/wise/paid/report',[CustomerController::class, 'wisePaid'])->name('customers.wise.paid.report');
    Route::get('customer/disponible&status',[CustomerController::class, 'disponible_status'])->name('customers.disponible.status');
    Route::get('customer/disponible&status/{id}',[CustomerController::class, 'disponible_status_edit'])->name('customers.disponible.status.edit');
    Route::Put('customer/disponible_status/update/{id}',[CustomerController::class , 'update_disponible_status'])->name('customers.disponible.status.update');
   
   
    Route::resource('unit/units',UnitController::class);
    Route::get('master/vetements',[VetementController::class, 'index'])->name('vetements.index');
    Route::get('get-product',[DefaultController::class, 'getProduct'])->name('get-product');

    Route::prefix('invoice')->group(function(){
       Route::get('view',[InvoiceController::class , 'index'])->name('invoices.index');
       Route::get('create',[InvoiceController::class , 'create'])->name('invoices.create');
       Route::post('store',[InvoiceController::class , 'store'])->name('invoices.store');
    //    Route::post('edit/{id}',[InvoiceController::class , 'edit'])->name('invoices.edit');
       Route::get('pending',[InvoiceController::class , 'pendingList'])->name('invoices.pendind.list.index');
       Route::get('approve/{id}',[InvoiceController::class ,'approvedInvoice'])->name('invoices.approve');
       Route::delete('delete/{id}',[InvoiceController::class , 'destroy'])->name('invoices.destroy');
       Route::post('approve/store/{id}',[InvoiceController::class , 'approvedStore'])->name('invoices.approve.store');
       Route::get('print/list',[InvoiceController::class , 'printInvoiceList'])->name('invoices.print.list');
       Route::get('print/{id}',[InvoiceController::class , 'printInvoice'])->name('invoices.print');
       Route::get('generate/report',[InvoiceController::class , 'report'])->name('invoices.report');
       Route::get('generate/report/pdf',[InvoiceController::class , 'reportpdf'])->name('invoices.report.pdf');
    });
}); 