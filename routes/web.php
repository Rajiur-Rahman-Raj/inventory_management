<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RolesPermissionController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear', function () {
    $output = new \Symfony\Component\Console\Output\BufferedOutput();
    Artisan::call('optimize:clear', array(), $output);
    return $output->fetch();
})->name('/clear');

Route::get('/user', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/loginModal', 'Auth\LoginController@loginModal')->name('loginModal');

Route::get('queue-work', function () {
    return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');

Route::get('cron', function () {
    return Illuminate\Support\Facades\Artisan::call('schedule:run');
})->name('cron');

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['guest']], function () {
    Route::get('register/{sponsor?}', 'Auth\RegisterController@sponsor')->name('register.sponsor');
});

Route::group(['middleware' => ['auth'], 'as' => 'user.'], function () {
    Route::get('/check', 'User\VerificationController@check')->name('check');
    Route::get('/resend_code', 'User\VerificationController@resendCode')->name('resendCode');
    Route::post('/mail-verify', 'User\VerificationController@mailVerify')->name('mailVerify');
    Route::post('/sms-verify', 'User\VerificationController@smsVerify')->name('smsVerify');
    Route::post('twoFA-Verify', 'User\VerificationController@twoFAverify')->name('twoFA-Verify');

    //Inventory Route Start
    Route::middleware('checkUserType')->group(function () {
        // Company List
        Route::get('company-list', 'User\CompanyController@index')->name('companyList');
        Route::get('create-company', 'User\CompanyController@createCompany')->name('createCompany');
        Route::post('store-company', 'User\CompanyController@companyStore')->name('companyStore');
        Route::get('edit-company/{id}', 'User\CompanyController@companyEdit')->name('companyEdit');
        Route::post('update-company/{id}', 'User\CompanyController@companyUpdate')->name('companyUpdate');
        Route::put('active/company/{id}', 'User\CompanyController@activeCompany')->name('activeCompany');
        Route::get('company/active/{id}', 'User\CompanyController@companyActive')->name('companyActive');
        Route::put('inactive/company/{id}', 'User\CompanyController@inactiveCompany')->name('inactiveCompany');
        Route::delete('delete/company/{id}', 'User\CompanyController@deleteCompany')->name('deleteCompany');

        // Employee List
        Route::get('employee-list', 'User\CompanyController@employeeList')->name('employeeList');
        Route::get('create-employee', 'User\CompanyController@createEmployee')->name('createEmployee');
        Route::post('employee-store', 'User\CompanyController@employeeStore')->name('employeeStore');
        Route::get('employee-details/{id}', 'User\CompanyController@employeeDetails')->name('employeeDetails');
        Route::get('employee-edit/{id}', 'User\CompanyController@employeeEdit')->name('employeeEdit');
        Route::post('employee-update/{id}', 'User\CompanyController@employeeUpdate')->name('employeeUpdate');
        Route::delete('employee-delete/{id}', 'User\CompanyController@employeeDelete')->name('employeeDelete');

        // Employee Salary List
        Route::get('employee-salary-list', 'User\CompanyController@employeeSalaryList')->name('employeeSalaryList');
        Route::post('add-employee-salary', 'User\CompanyController@addEmployeeSalary')->name('addEmployeeSalary');
        Route::post('edit-employee-salary/{id}', 'User\CompanyController@employeeSalaryEdit')->name('employeeSalaryEdit');
        Route::delete('employee-salary-delete/{id}', 'User\CompanyController@employeeSalaryDelete')->name('employeeSalaryDelete');

        Route::post('employee-store', 'User\CompanyController@employeeStore')->name('employeeStore');
        Route::get('employee-details/{id}', 'User\CompanyController@employeeDetails')->name('employeeDetails');
        Route::get('employee-edit/{id}', 'User\CompanyController@employeeEdit')->name('employeeEdit');
        Route::post('employee-update/{id}', 'User\CompanyController@employeeUpdate')->name('employeeUpdate');
        Route::delete('employee-delete/{id}', 'User\CompanyController@employeeDelete')->name('employeeDelete');


        // Sales Center
        Route::get('sales-center-list', 'User\CompanyController@salesCenterList')->name('salesCenterList');
        Route::get('sales-center-create', 'User\CompanyController@createSalesCenter')->name('createSalesCenter');
        Route::post('store-sales-center', 'User\CompanyController@storeSalesCenter')->name('storeSalesCenter');
        Route::get('sales-center-details/{id}', 'User\CompanyController@salesCenterDetails')->name('salesCenterDetails');
        Route::get('sales-center-edit/{id}', 'User\CompanyController@salesCenterEdit')->name('salesCenterEdit');
        Route::post('sales-center-update/{id}', 'User\CompanyController@updateSalesCenter')->name('updateSalesCenter');
        Route::delete('delete/center/{id}', 'User\CompanyController@deleteSalesCenter')->name('deleteSalesCenter');

        // Item List
        Route::get('item-list', 'User\CompanyController@itemList')->name('itemList');
        Route::post('store-item', 'User\CompanyController@itemStore')->name('itemStore');
        Route::put('update-item/{id}', 'User\CompanyController@updateItem')->name('updateItem');
        Route::delete('delete/item/{id}', 'User\CompanyController@deleteItem')->name('deleteItem');

        // Wastage List
        Route::get('wastage-list', 'User\CompanyController@wastageList')->name('wastageList');
        Route::post('wastage-store', 'User\CompanyController@wastageStore')->name('wastageStore');
        Route::delete('delete/wastage/{id}', 'User\CompanyController@deleteWastage')->name('deleteWastage');

        // Stock Missing
        Route::get('stock-missing-list', 'User\CompanyController@stockMissingList')->name('stockMissingList');
        Route::post('stock-missing-store', 'User\CompanyController@stockMissingStore')->name('stockMissingStore');
        Route::delete('stock/missing/delete/{id}', 'User\CompanyController@stockMissingDelete')->name('stockMissingDelete');

        // Affiliate Member
        Route::get('affiliate/member/list', 'User\CompanyController@affiliateMemberList')->name('affiliateMemberList');
        Route::get('affiliate/member/create', 'User\CompanyController@createAffiliateMember')->name('createAffiliateMember');
        Route::post('affiliate/member/store', 'User\CompanyController@affiliateMemberStore')->name('affiliateMemberStore');
        Route::get('affiliate/member/edit/{id}', 'User\CompanyController@affiliateMemberEdit')->name('affiliateMemberEdit');
        Route::post('affiliate/member/update/{id}', 'User\CompanyController@affiliateMemberUpdate')->name('affiliateMemberUpdate');
        Route::delete('affiliate/member/delete/{id}', 'User\CompanyController@affiliateMemberDelete')->name('affiliateMemberDelete');
        Route::get('affiliate/member/details/{id}', 'User\CompanyController@affiliateMemberDetails')->name('affiliateMemberDetails');

        // Company Expenses
        Route::get('expense/category', 'User\CompanyController@expenseCategory')->name('expenseCategory');
        Route::post('expense/category/store', 'User\CompanyController@expenseCategoryStore')->name('expenseCategoryStore');
        Route::put('update-expense-category/{id}', 'User\CompanyController@updateExpenseCategory')->name('updateExpenseCategory');
        Route::delete('delete/expense/category/{id}', 'User\CompanyController@deleteExpenseCategory')->name('deleteExpenseCategory');

        Route::get('expense/list', 'User\CompanyController@expenseList')->name('expenseList');
        Route::post('expense/list/store', 'User\CompanyController@expenseListStore')->name('expenseListStore');
        Route::put('update/expense/list/{id}', 'User\CompanyController@updateExpenseList')->name('updateExpenseList');
        Route::delete('delete/expense/list/{id}', 'User\CompanyController@deleteExpenseList')->name('deleteExpenseList');

        // suppliers
        Route::get('suppliers', 'User\CompanyController@suppliers')->name('suppliers');
        Route::get('supplier/create', 'User\CompanyController@createSupplier')->name('createSupplier');
        Route::post('store/supplier', 'User\CompanyController@supplierStore')->name('supplierStore');
        Route::get('supplier-edit/{id}', 'User\CompanyController@supplierEdit')->name('supplierEdit');
        Route::post('supplier-update/{id}', 'User\CompanyController@supplierUpdate')->name('supplierUpdate');
        Route::get('supplier-details/{id}', 'User\CompanyController@supplierDetails')->name('supplierDetails');
        Route::delete('delete/supplier/{id}', 'User\CompanyController@deleteSupplier')->name('deleteSupplier');

        // Raw Items
        Route::get('raw-item-list', 'User\CompanyController@rawItemList')->name('rawItemList');
        Route::post('raw-item-store', 'User\CompanyController@rawItemStore')->name('rawItemStore');
        Route::put('update-raw-item/{id}', 'User\CompanyController@updateRawItem')->name('updateRawItem');
        Route::delete('delete/raw/item/{id}', 'User\CompanyController@deleteRawItem')->name('deleteRawItem');

        // Purchase Raw Items
        Route::get('purchase-raw-item', 'User\CompanyController@purchaseRawItem')->name('purchaseRawItem');
        Route::post('store-purchase-item', 'User\CompanyController@storePurchaseItem')->name('storePurchaseItem');
        Route::get('purchase-raw-item-list', 'User\CompanyController@purchaseRawItemList')->name('purchaseRawItemList');
        Route::get('purchase-raw-item-details/{id}', 'User\CompanyController@rawItemPurchaseDetails')->name('rawItemPurchaseDetails');

        Route::get('purchase-raw-item-stocks', 'User\CompanyController@purchaseRawItemStocks')->name('purchaseRawItemStocks');

        Route::delete('delete/purchase/raw/item/{id}', 'User\CompanyController@deletePurchaseRawItem')->name('deletePurchaseRawItem');
        Route::post('selected-raw-item-unit', 'User\CompanyController@getSelectedRawItemUnit')->name('getSelectedRawItemUnit');

        // Stock In
        Route::get('add-stock', 'User\CompanyController@addStock')->name('addStock');
        Route::get('stock-transfer', 'User\CompanyController@stockTransfer')->name('stockTransfer');
        Route::post('store/stock-transfer', 'User\CompanyController@storeStockTransfer')->name('storeStockTransfer');
        Route::get('stock/transfer/list', 'User\CompanyController@stockTransferList')->name('stockTransferList');
        Route::get('stock/transfer/details/{item}/{id}', 'User\CompanyController@stockTransferDetails')->name('stockTransferDetails');

        Route::post('/verificationSubmit', 'User\HomeController@verificationSubmit')->name('verificationSubmit');
        Route::post('/addressVerification', 'User\HomeController@addressVerification')->name('addressVerification');
    });

    // Reports
    // Purchase Reports
    Route::get('export/purchase/reports', [ReportController::class, 'exportPurchaseReports'])->name('export.purchaseReports');
    Route::get('purchase/reports', [ReportController::class, 'purchaseReports'])->name('purchaseReports');

    Route::get('purchase/payment/reports', [ReportController::class, 'purchasePaymentReports'])->name('purchasePaymentReports');
    Route::get('export/purchase/payment/reports', [ReportController::class, 'exportPurchasePaymentReports'])->name('export.purchasePaymentReports');

    // Sales Report
    Route::get('sales/reports', [ReportController::class, 'salesReports'])->name('salesReports');
    Route::get('export/sales/reports', [ReportController::class, 'exportSalesReports'])->name('export.salesReports');

    Route::get('sales/payment/reports', [ReportController::class, 'salesPaymentReports'])->name('salesPaymentReports');
    Route::get('export/sales/payment/reports', [ReportController::class, 'exportSalesPaymentReports'])->name('export.salesPaymentReports');

    // Profit & Loss Report
    Route::get('profit/loss/reports', [ReportController::class, 'profitLossReports'])->name('profitLossReports');
    Route::get('export/profit/loss/reports', [ReportController::class, 'exportProfitLossReports'])->name('export.profitLossReports');

    // Roles And Permission
    Route::get('role/list', [RolesPermissionController::class, 'roleList'])->name('role');
    Route::get('create/role', [RolesPermissionController::class, 'createRole'])->name('createRole');
    Route::post('role/store', [RolesPermissionController::class, 'roleStore'])->name('roleStore');
    Route::get('edit/role/{id}', [RolesPermissionController::class, 'editRole'])->name('editRole');
    Route::post('role/update/{id}', [RolesPermissionController::class, 'roleUpdate'])->name('roleUpdate');
    Route::delete('delete/role/{id}', [RolesPermissionController::class, 'deleteRole'])->name('deleteRole');

    Route::get('manage/staffs', [RolesPermissionController::class, 'staffList'])->name('role.staff');
    Route::get('manage/staffs/create', [RolesPermissionController::class, 'staffCreate'])->name('role.staffCreate');
    Route::post('manage/staffs/store', [RolesPermissionController::class, 'staffStore'])->name('role.staffStore');
    Route::get('manage/staffs/edit/{id?}', [RolesPermissionController::class, 'staffEdit'])->name('role.staffEdit');
    Route::post('manage/staffs/update/{id}', [RolesPermissionController::class, 'staffUpdate'])->name('role.staffUpdate');

    //Stock Report
    Route::get('stock/reports', [ReportController::class, 'stockReports'])->name('stockReports');
    Route::get('export/stock/reports', [ReportController::class, 'exportStockReports'])->name('export.stockReports');

    //Wastage Report
    Route::get('wastage/reports', [ReportController::class, 'wastageReports'])->name('wastageReports');
    Route::get('export/wastage/reports', [ReportController::class, 'exportWastageReports'])->name('export.wastageReports');

    //Stock Missing Report
    Route::get('stock/missing/reports', [ReportController::class, 'stockMissingReports'])->name('stockMissingReports');
    Route::get('export/stock/missing/reports', [ReportController::class, 'exportStockMissingReports'])->name('export.stockMissingReports');

    //Expense Report
    Route::get('expense/reports', [ReportController::class, 'expenseReports'])->name('expenseReports');
    Route::get('export/expense/reports', [ReportController::class, 'exportExpenseReports'])->name('export.expenseReports');

    //Salary Report
    Route::get('salary/reports', [ReportController::class, 'salaryReports'])->name('salaryReports');
    Route::get('export/salary/reports', [ReportController::class, 'exportSalaryReports'])->name('export.salaryReports');


    //Affiliation Report
    Route::get('affiliate/reports', [ReportController::class, 'affiliateReports'])->name('affiliateReports');
    Route::get('export/affiliate/reports', [ReportController::class, 'exportAffiliateReports'])->name('export.affiliateReports');

    // old report
    Route::get('stock/sales/reports', 'User\CompanyController@stockExpenseSalesProfitReports')->name('stockExpenseSalesProfitReports');
    Route::get('export-stock-sales-reports', 'User\CompanyController@exportStockExpenseSalesProfitReports')->name('export.stockExpenseSalesProfitReports');

    /* ===== Company Dashbaord data fetch using ajax ===== */
    Route::get('get-sales-stat-records', [HomeController::class, 'getSalesStatRecords'])->name('getSalesStatRecords');
    Route::get('get-item-data', [HomeController::class, 'getItemRecords'])->name('getItemRecords');
    Route::get('get-customer-records', [HomeController::class, 'getCustomerRecords'])->name('getCustomerRecords');
    Route::get('get-raw-item-records', [HomeController::class, 'getRawItemRecords'])->name('getRawItemRecords');
    Route::get('get-affiliate-member-records', [HomeController::class, 'getAffiliateMemberRecords'])->name('getAffiliateMemberRecords');
    Route::get('sales-center-records', [HomeController::class, 'getSalesCenterRecords'])->name('getSalesCenterRecords');
    Route::get('get-supplier-records', [HomeController::class, 'getSupplierRecords'])->name('getSupplierRecords');
    Route::get('get-expense-records', [HomeController::class, 'getExpenseRecords'])->name('getExpenseRecords');

    Route::get('get-year-sales-transaction-chart-records', [HomeController::class, 'getYearSalesTransactionChartRecords'])->name('getYearSalesTransactionChartRecords');
    Route::get('get-year-sales-center-transaction-chart-records', [HomeController::class, 'getSalesCenterYearSalesTransactionChartRecords'])->name('getSalesCenterYearSalesTransactionChartRecords');


    // sales center stock
    Route::get('sales/center/stock/details/{item?}/{id?}', 'User\CompanyController@salesCenterStockDetails')->name('salesCenterStockDetails');

    Route::put('update-item-unit-price/{id}', 'User\CompanyController@updateItemUnitPrice')->name('updateItemUnitPrice');
    Route::put('update-selling-price/{id}', 'User\CompanyController@updateSellingPrice')->name('updateSellingPrice');

    Route::post('store-cart-items', 'User\CompanyController@storeCartItems')->name('storeCartItems');
    Route::post('update-cart-items', 'User\CompanyController@updateCartItems')->name('updateCartItems');

    Route::post('store-sales-cart-items', 'User\CompanyController@storeSalesCartItems')->name('storeSalesCartItems');

    Route::delete('clear-cart-items', 'User\CompanyController@clearCartItems')->name('clearCartItems');
    Route::post('clear-sale-cart-items', 'User\CompanyController@clearSaleCartItems')->name('clearSaleCartItems');
    Route::post('clear-single-cart-item', 'User\CompanyController@clearSingleCartItem')->name('clearSingleCartItem');
    Route::post('clear-single-return-cart-item', 'User\CompanyController@clearSingleReturnCartItem')->name('clearSingleReturnCartItem');


    Route::post('sales-order-store', 'User\CompanyController@salesOrderStore')->name('salesOrderStore');
    Route::put('sales-order-update/{id}', 'User\CompanyController@salesOrderUpdate')->name('salesOrderUpdate');

    Route::post('purchase-item-due-amount-update/{id}', 'User\CompanyController@purchaseRawItemDueAmountUpdate')->name('purchaseRawItemDueAmountUpdate');


    Route::get('sales-invoice/{id}', 'User\CompanyController@salesInvoice')->name('salesInvoice');
    Route::put('sales-invoice-update/{id}', 'User\CompanyController@salesInvoiceUpdate')->name('salesInvoiceUpdate');


    // Profile
    Route::get('/profile', 'User\HomeController@profile')->name('profile');
    Route::post('/updateProfile', 'User\HomeController@updateProfile')->name('updateProfile');
    Route::post('/profileImageUpdate', 'User\HomeController@profileImageUpdate')->name('profileImageUpdate');
    Route::put('/updateInformation', 'User\HomeController@updateInformation')->name('updateInformation');
    Route::post('/updatePassword', 'User\HomeController@updatePassword')->name('updatePassword');

    // Customer List
    Route::get('customer-list', 'User\CompanyController@customerList')->name('customerList');
    Route::get('create-customer', 'User\CompanyController@createCustomer')->name('createCustomer');
    Route::post('store-customer', 'User\CompanyController@customerStore')->name('customerStore');
    Route::get('customer-details/{id}', 'User\CompanyController@customerDetails')->name('customerDetails');
    Route::get('customer-edit/{id}', 'User\CompanyController@customerEdit')->name('customerEdit');
    Route::post('customer-update/{id}', 'User\CompanyController@customerUpdate')->name('customerUpdate');
    Route::delete('delete/customer/{id}', 'User\CompanyController@deleteCustomer')->name('deleteCustomer');

    // Stock In
    Route::get('stock-list', 'User\CompanyController@stockList')->name('stockList');
    Route::post('stock-store', 'User\CompanyController@stockStore')->name('stockStore');
    Route::put('update-stock/{id}', 'User\CompanyController@updateStock')->name('updateStock');
    Route::delete('delete/stock/{id}', 'User\CompanyController@deleteStock')->name('deleteStock');
    Route::get('stock-details/{item?}/{id?}', 'User\CompanyController@stockDetails')->name('stockDetails');
    Route::post('selected-item-unit', 'User\CompanyController@getSelectedItemUnit')->name('getSelectedItemUnit');

    // Manage Sales
    Route::get('sales-items', 'User\CompanyController@salesItem')->name('salesItem');
    Route::get('sales-list', 'User\CompanyController@salesList')->name('salesList');
    Route::get('sales-details/{id}', 'User\CompanyController@salesDetails')->name('salesDetails');

    // Sales Return
    Route::get('sales/return/{id}', 'User\CompanyController@returnSales')->name('returnSales');
    Route::post('return/sales/order/{id}', 'User\CompanyController@returnSalesOrder')->name('returnSalesOrder');

    // inventory ajax route
    Route::post('get-division-district', [LocationController::class, 'getSelectedDivisionDistrict'])->name('getSelectedDivisionDistrict');
    Route::post('get-district-upazila', [LocationController::class, 'getSelectedDistrictUpazila'])->name('getSelectedDistrictUpazila');
    Route::post('get-upazila-union', [LocationController::class, 'getSelectedUpazilaUnion'])->name('getSelectedUpazilaUnion');


    Route::post('get-selected-items', 'User\CompanyController@getSelectedItems')->name('getSelectedItems');
    Route::post('get-selected-customer', 'User\CompanyController@getSelectedCustomer')->name('getSelectedCustomer');
    Route::post('get-selected-sales-center', 'User\CompanyController@getSelectedSalesCenter')->name('getSelectedSalesCenter');

    //Inventory Route End

    Route::get('/dashboard', 'User\HomeController@index')->name('home');

    Route::get('push-notification-show', 'SiteNotificationController@show')->name('push.notification.show');
    Route::get('push.notification.readAll', 'SiteNotificationController@readAll')->name('push.notification.readAll');
    Route::get('push-notification-readAt/{id}', 'SiteNotificationController@readAt')->name('push.notification.readAt');
});

Route::get('/', 'FrontendController@index')->name('home');

Route::group(['middleware' => ['Maintenance']], function () {


});

