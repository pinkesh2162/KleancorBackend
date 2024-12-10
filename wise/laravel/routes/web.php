<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Invoice\InvoiceProController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Bank\BankController;
use App\Http\Controllers\PersonalExpenses\PersonalexpensesController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Projects\ProjectsController;
use App\Http\Controllers\Sales\SalesController;
use App\Http\Controllers\Salary\SalaryController;
use App\Http\Controllers\DalyExpense\DalyexpenseController;
use App\Http\Controllers\Servicemen\ServicemenController;
use App\Http\Controllers\BankDeposit\BankDepositController;
use App\Http\Controllers\Customers\CustomersController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Units\UnitsController;
use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Products\ProductsController;
use App\Http\Controllers\Products\AddproductController;
use App\Http\Controllers\Advances\AdvanceController;
use App\Http\Controllers\Damages\DamageController;
use App\Http\Controllers\Products\StockOutController;


Route::get('/clear', function () {
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    return 'Routes cache has been cleared';
});



Route::get('/', function () {
    if (Auth::check()) {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    } else {
        return redirect('/login'); // Redirect unauthenticated users to login page
    }
});

Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change-password');
Route::post('/update-password', [ChangePasswordController::class, 'update'])->name('update-password');

Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Attendance Management
    Route::prefix('attendance-management')->name('attendance.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::post('/insert', [AttendanceController::class, 'create'])->name('insert');
        Route::get('/active', [AttendanceController::class, 'show'])->name('view');
        Route::get('/edit/{id}', [AttendanceController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AttendanceController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [AttendanceController::class, 'delete'])->name('delete');
    });

    Route::get('/overtime-management', [AttendanceController::class, 'overtime'])->name('attendance.overtime');
    Route::post('/overtime-management', [AttendanceController::class, 'overtimeStore'])->name('attendance.overtimeStore');
    Route::get('/overtime-management/edit/{id}', [AttendanceController::class, 'overtimeEdit'])->name('attendance.overtimeEdit');
    Route::post('/overtime-management/update/{id}', [AttendanceController::class, 'overtimeUpdate'])->name('attendance.overtimeUpdate');

    // Product Management
    Route::prefix('product-management')->name('product.')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('index');
        Route::post('/insert', [ProductsController::class, 'create'])->name('insert');
        Route::get('/active', [ProductsController::class, 'show'])->name('view');
        Route::get('/edit/{id}', [ProductsController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ProductsController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [ProductsController::class, 'delete'])->name('delete');
        Route::get('/frozen', [ProductsController::class, 'frozen'])->name('frozen');
    });

    // Add Product Management
    Route::prefix('add-product-management')->name('addproduct.')->group(function () {
        Route::get('/', [AddproductController::class, 'index'])->name('index');
        Route::post('/insert', [AddproductController::class, 'create'])->name('insert');
        Route::get('/active', [AddproductController::class, 'show'])->name('view');
        Route::get('/edit/{id}', [AddproductController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AddproductController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [AddproductController::class, 'delete'])->name('delete');
        Route::get('/frozen', [AddproductController::class, 'frozen'])->name('frozen');
    });
    Route::get("/add-product-management/status/{id}", "Products\AddproductController@status")->name("addproduct.status");
    Route::post("/add-product-management/status/{id}", "Products\AddproductController@status_store")->name("addproduct.status_store");
    Route::get("/add-product-management/delete-status/{id}", "Products\AddproductController@status_delete")->name("addproduct.status_delete");

    // Advance Management
    Route::prefix('advance-management')->name('advance.')->group(function () {
        Route::get('/', [AdvanceController::class, 'index'])->name('index');
        Route::post('/insert', [AdvanceController::class, 'create'])->name('insert');
        Route::get('/active', [AdvanceController::class, 'show'])->name('view');
    });

    // Damage Management
    Route::prefix('damage-management')->name('damage.')->group(function () {
        Route::get('/', [DamageController::class, 'index'])->name('index');
        Route::post('/insert', [DamageController::class, 'create'])->name('insert');
        Route::get('/active', [DamageController::class, 'show'])->name('view');
        Route::get('/edit/{id}', [DamageController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [DamageController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [DamageController::class, 'delete'])->name('delete');
    });

    // Stock Out Management
    Route::prefix('stock-out-management')->name('stockout.')->group(function () {
        Route::get('/', [StockOutController::class, 'index'])->name('index');
        Route::post('/insert', [StockOutController::class, 'create'])->name('insert');
        Route::get('/active', [StockOutController::class, 'show'])->name('view');
        Route::get('/edit/{id}', [StockOutController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [StockOutController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [StockOutController::class, 'delete'])->name('delete');
    });



    //Invoice
    // Invoice Routes
    Route::prefix('invoice')->name('invoice.')->group(function () {
        Route::get('/all', [InvoiceController::class, 'index'])->name('index');
        Route::get('/all-partial', [InvoiceController::class, 'partial'])->name('partial');
        Route::get('/due', [InvoiceController::class, 'due'])->name('due');
        Route::get('/new', [InvoiceController::class, 'create'])->name('new');
        Route::post('/new', [InvoiceController::class, 'store'])->name('store');
        Route::post('/get-product-description', [InvoiceController::class, 'get_product_description'])->name('get_product_description');
        Route::post('/save-payment', [InvoiceController::class, 'payment_save'])->name('payment_save');
        Route::get('/print-preview/{id}', [InvoiceController::class, 'print_preview'])->name('printPreview');
        Route::get('/print/{id}', [InvoiceController::class, 'print'])->name('print');
        Route::get('/edit/{id}', [InvoiceController::class, 'edit'])->name('edit');
        Route::post('/edit', [InvoiceController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [InvoiceController::class, 'delete'])->name('delete');
        Route::get('/delete-payment/{id}', [InvoiceController::class, 'payment_delete'])->name('payment.delete');
        Route::post('/update-payment', [InvoiceController::class, 'payment_update'])->name('payment_update');

        // Top Sheet Routes
        Route::get('/top-sheet', [InvoiceController::class, 'top_sheet'])->name('top_sheet');
        Route::post('/top-sheet', [InvoiceController::class, 'top_sheet_save'])->name('top_sheet_save');
        Route::post('/top-sheet-search', [InvoiceController::class, 'top_sheet_search'])->name('top_sheet_search');
        Route::get('/top-sheet-print/{id}', [InvoiceController::class, 'top_sheet_print'])->name('top_sheet_print');

        Route::get('/all-top-sheet', [InvoiceController::class, 'top_sheet_all'])->name('top_sheet_all');
        Route::get('/all-top-sheet-delete/{id}', [InvoiceController::class, 'top_sheet_delete'])->name('top_sheet_delete');

        // Custom Top Sheet Routes
        Route::get('/custom-top-sheet', [InvoiceController::class, 'custom_top_sheet'])->name('custom_top_sheet');
        Route::post('/custom-top-sheet', [InvoiceController::class, 'custom_top_sheet_save'])->name('custom_top_sheet_save');
        Route::post('/custom-top-sheet-search', [InvoiceController::class, 'custom_top_sheet_search'])->name('custom_top_sheet_search');
    });

    // Grouped routes for Project Invoice
    Route::prefix('project-invoice')->name('invoice-pro.')->group(function () {
        Route::get('/all', [InvoiceProController::class, 'index'])->name('index');
        Route::get('/due', [InvoiceProController::class, 'due'])->name('due');
        Route::get('/new', [InvoiceProController::class, 'create'])->name('new');
        Route::post('/new', [InvoiceProController::class, 'store'])->name('store');
        Route::post('/save-payment', [InvoiceProController::class, 'payment_save'])->name('payment_save');
        Route::get('/print-preview/{id}', [InvoiceProController::class, 'print_preview'])->name('printPreview');
        Route::get('/print/{id}', [InvoiceProController::class, 'print'])->name('print');
        Route::get('/edit/{id}', [InvoiceProController::class, 'edit'])->name('edit');
        Route::post('/edit', [InvoiceProController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [InvoiceProController::class, 'delete'])->name('delete');
    });

    // Grouped routes for Transactions
    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('/new-deposit', [TransactionController::class, 'new_deposit'])->name('new-deposit');
        Route::post('/new-deposit', [TransactionController::class, 'store_new_deposit'])->name('new-deposit-store');
        Route::get('/new-deposit/edit/{id}', [TransactionController::class, 'edit_deposit'])->name('edit-deposit');
        Route::post('/new-deposit/update', [TransactionController::class, 'update_new_deposit'])->name('new-deposit-update');
        Route::get('/new-deposit/delete/{id}', [TransactionController::class, 'delete_deposit'])->name('delete-deposit');

        Route::get('/new-expense', [TransactionController::class, 'new_expense'])->name('new-expense');
        Route::post('/new-expense', [TransactionController::class, 'store_new_expense'])->name('new-expense-store');
        Route::get('/new-expense/edit/{id}', [TransactionController::class, 'edit_expense'])->name('edit-expense');
        Route::post('/new-expense/update', [TransactionController::class, 'update_new_expense'])->name('new-expense-update');
        Route::get('/new-expense/delete/{id}', [TransactionController::class, 'delete_expense'])->name('delete-expense');

        Route::get('/new-transfer', [TransactionController::class, 'new_transfer'])->name('transfer');
        Route::post('/new-transfer', [TransactionController::class, 'store_new_transfer'])->name('transfer-store');
        Route::get('/new-transfer/edit/{id}', [TransactionController::class, 'edit_transfer'])->name('edit-transfer');
        Route::post('/new-transfer/update', [TransactionController::class, 'update_new_transfer'])->name('transfer-update');
        Route::get('/new-transfer/delete/{id}', [TransactionController::class, 'delete_transfer'])->name('delete-transfer');

        Route::get('/employee-credit', [TransactionController::class, 'employee_credit'])->name('employee-credit');
        Route::post('/employee-credit', [TransactionController::class, 'store_employee_credit'])->name('employee-credit-store');
        Route::get('/employee-credit/edit/{id}', [TransactionController::class, 'edit_employee_credit'])->name('edit-credit');
        Route::post('/employee-credit/update', [TransactionController::class, 'update_employee_credit'])->name('employee-credit-update');
        Route::get('/employee-credit/delete/{id}', [TransactionController::class, 'delete_employee_credit'])->name('delete-credit');

        Route::get('/employee-debit', [TransactionController::class, 'employee_debit'])->name('employee-debit');
        Route::post('/employee-debit', [TransactionController::class, 'store_employee_debit'])->name('employee-debit-store');
        Route::get('/employee-debit/edit/{id}', [TransactionController::class, 'edit_employee_debit'])->name('edit-debit');
        Route::post('/employee-debit/update', [TransactionController::class, 'update_employee_debit'])->name('employee-debit-update');
        Route::get('/employee-debit/delete/{id}', [TransactionController::class, 'delete_debit'])->name('delete-debit');

        Route::get('/employee-balance-sheet', [TransactionController::class, 'employee_balance_sheet'])->name('employee-balance-sheet');
        Route::get('/employee-balance-sheet-details/{id}', [TransactionController::class, 'employee_balance_sheet_details'])->name('employee-balance-sheet-details');
        Route::get('/balance-sheet', [TransactionController::class, 'balancesheet'])->name('balancesheet');
    });



    Route::get('/home', [UserController::class, 'index'])->name('home');
    Route::post('/create-user', [UserController::class, 'create'])->name('user');
    Route::get('/add-new-user', [UserController::class, 'admincontrol'])->name('adminregister');
    Route::get('/active-user', [UserController::class, 'view'])->name('allusers');
    Route::get('/frozen-user', [UserController::class, 'viewFrozen'])->name('frozenuser');
    Route::get('/edit-user/{id}', [UserController::class, 'edit'])->name('edituser');
    Route::post('/update-user/{id}', [UserController::class, 'update'])->name('updateuser');
    Route::get('/fridge-user/{id}', [UserController::class, 'fridge'])->name('fridge-users');
    Route::get('/active-user/{id}', [UserController::class, 'active'])->name('active-users');

    Route::get('/create-bank', [BankController::class, 'index'])->name('createbank');
    Route::post('/add-bank-info', [BankController::class, 'create'])->name('addbank');
    Route::get('/view-all-bank', [BankController::class, 'view'])->name('allviewbank');
    Route::get('/frozen-all-bank', [BankController::class, 'frozen'])->name('frozenviewbank');
    Route::get('/active-all-bank/{id}', [BankController::class, 'active'])->name('activeviewbank');
    Route::get('/edit-bank-info/{id}', [BankController::class, 'edit'])->name('editbank');
    Route::post('/update-bank-info/{id}', [BankController::class, 'update'])->name('updatebank');
    Route::get('/delete-bank-info/{id}', [BankController::class, 'delete'])->name('deletebank');

    // Add other routes that require isAdmin middleware here
    Route::get('/personal-expanse-management-insert', [PersonalexpensesController::class, 'index'])->name('insertexpenses');
    Route::post('/personal-expanse-management-insert', [PersonalexpensesController::class, 'create'])->name('createexpenses');
    Route::get('/personal-expanse-management-view', [PersonalexpensesController::class, 'store'])->name('viewexpenses');
    Route::get('/personal-expanse-management-update/{id}', [PersonalexpensesController::class, 'edit'])->name('editexpenses');
    Route::post('/personal-expanse-management-update/{id}', [PersonalexpensesController::class, 'update'])->name('updateexpenses');
    Route::get('/personal-expanse-management-delete/{id}', [PersonalexpensesController::class, 'destroy'])->name('deleteexpenses');


    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/create', [ProjectsController::class, 'index'])->name('create');
        Route::post('/add', [ProjectsController::class, 'insert'])->name('insert');
        Route::get('/all', [ProjectsController::class, 'view'])->name('view');
        Route::get('/all-frozen', [ProjectsController::class, 'frozen'])->name('viewfrozen');
        Route::get('/edit/{id}', [ProjectsController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ProjectsController::class, 'update'])->name('update');
        Route::get('/fridge/{id}', [ProjectsController::class, 'fridge'])->name('fridge');
        Route::get('/active/{id}', [ProjectsController::class, 'active'])->name('active');
        Route::get('/delete/{id}', [ProjectsController::class, 'delete'])->name('delete');
    });

    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('/create', [SalesController::class, 'index'])->name('create');
        Route::get('/view-all', [SalesController::class, 'view'])->name('viewallsalesproducts');
        Route::get('/edit/{id}', [SalesController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [SalesController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [SalesController::class, 'delete'])->name('delete');
    });

    Route::prefix('salary')->name('salary.')->group(function () {
        Route::get('/add', [SalaryController::class, 'index'])->name('add');
        Route::post('/create', [SalaryController::class, 'create'])->name('create');
        Route::get('/view', [SalaryController::class, 'view'])->name('view');
        Route::get('/view-frozen', [SalaryController::class, 'viewfrozen'])->name('viewfrozen');
        Route::get('/edit/{id}', [SalaryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [SalaryController::class, 'update'])->name('update');
        Route::get('/fridge/{id}', [SalaryController::class, 'fridge'])->name('fridge');
        Route::get('/delete/{id}', [SalaryController::class, 'delete'])->name('delete');
        Route::get('/print', [SalaryController::class, 'print'])->name('print');
    });

    Route::prefix('expenses')->name('expenses.')->group(function () {
        Route::get('/add', [DalyexpenseController::class, 'index'])->name('add');
        Route::post('/create', [DalyexpenseController::class, 'create'])->name('create');
        Route::get('/view', [DalyexpenseController::class, 'view'])->name('view');
        Route::get('/edit/{id}', [DalyexpenseController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [DalyexpenseController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [DalyexpenseController::class, 'delete'])->name('delete');
    });

    Route::prefix('service-men')->name('service-men.')->group(function () {
        Route::get('/add', [ServicemenController::class, 'index'])->name('add');
        Route::post('/create', [ServicemenController::class, 'create'])->name('create');
        Route::get('/view', [ServicemenController::class, 'view'])->name('view');
        Route::get('/frozen', [ServicemenController::class, 'frozen'])->name('frozen');
        Route::get('/edit/{id}', [ServicemenController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ServicemenController::class, 'update'])->name('update');
        Route::get('/fridge/{id}', [ServicemenController::class, 'fridge'])->name('fridge');
        Route::get('/active/{id}', [ServicemenController::class, 'active'])->name('active');
    });

    Route::prefix('bank-deposit')->name('bank-deposit.')->group(function () {
        Route::get('/create', [BankDepositController::class, 'index'])->name('create');
        Route::post('/add', [BankDepositController::class, 'insert'])->name('insert');
        Route::get('/view', [BankDepositController::class, 'view'])->name('view');
        Route::get('/all-frozen', [BankDepositController::class, 'allfrozen'])->name('all-frozen');
        Route::get('/edit/{id}', [BankDepositController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [BankDepositController::class, 'update'])->name('update');
        Route::get('/frozen/{id}', [BankDepositController::class, 'frozen'])->name('frozen');
        Route::get('/unfrozen/{id}', [BankDepositController::class, 'unfrozen'])->name('unfrozen');
        Route::get('/delete/{id}', [BankDepositController::class, 'delete'])->name('delete');
    });

    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/create', [CustomersController::class, 'index'])->name('create');
        Route::post('/add', [CustomersController::class, 'create'])->name('add');
        Route::get('/view', [CustomersController::class, 'view'])->name('view');
        Route::get('/details/{id}', [CustomersController::class, 'details'])->name('details');
        Route::get('/view-details/{id}', [CustomersController::class, 'viewdetails'])->name('view-details');
        Route::get('/all-frozen', [CustomersController::class, 'viewfrozen'])->name('all-frozen');
        Route::get('/edit/{id}', [CustomersController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CustomersController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [CustomersController::class, 'delete'])->name('delete');
        Route::get('/frozen/{id}', [CustomersController::class, 'frozen'])->name('frozen');
        Route::get('/active/{id}', [CustomersController::class, 'active'])->name('active');
    });

    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::post('/inserts', [PaymentController::class, 'create'])->name('inserts');
        Route::get('/view', [PaymentController::class, 'view'])->name('view');
        Route::get('/edit/{id}', [PaymentController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [PaymentController::class, 'delete'])->name('delete');
        Route::post('/update/{id}', [PaymentController::class, 'update'])->name('update');
    });

    Route::prefix('units')->name('units.')->group(function () {
        Route::get('/create', [UnitsController::class, 'index'])->name('create');
        Route::post('/add', [UnitsController::class, 'create'])->name('add');
        Route::get('/all', [UnitsController::class, 'view'])->name('all');
        Route::get('/edit/{id}', [UnitsController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [UnitsController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [UnitsController::class, 'delete'])->name('delete');
    });

    //Employee controller
    Route::get('/create-employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::post('/create-employee', [EmployeeController::class, 'create'])->name('addemployee');
    Route::get('/all-employee', [EmployeeController::class, 'view'])->name('allemployee');
    Route::get('/frozon-employee', [EmployeeController::class, 'frozon'])->name('frozonemployee');
    Route::get('/edit-employee/{id}', [EmployeeController::class, 'edit'])->name('editemployee');
    Route::post('/edit-users/{id}', [EmployeeController::class, 'update'])->name('updateemployee');
    Route::get('/delete-employee/{id}', [EmployeeController::class, 'delete'])->name('deleteemployee');
    Route::get('/frozen-employee/{id}', [EmployeeController::class, 'frozen'])->name('frozenEmployee');
    Route::get('/unfrozen-employee/{id}', [EmployeeController::class, 'unfrozen'])->name('unfrozenEmployee');
    Route::get('/download-employee/{id}', [EmployeeController::class, 'download'])->name('downloademployee');

    // Route::get('/demo-page', [DemoController::class, 'index'])->name('demo');
    // Route::post('/demo-page-2', [DemoController::class, 'create'])->name('sales.create');
});
