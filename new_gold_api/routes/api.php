<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentCashController;
Use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\PaymentGoldController;
use App\Http\Controllers\BillAdjustmentController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PriceCodeController;
use App\Http\Controllers\BillMasterController;
use App\Http\Controllers\JobTaskController;
use App\Http\Controllers\JobMasterController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderMasterController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\CustomerCategoryController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("login",[UserController::class,'login']);



Route::post("register",[UserController::class,'register']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's


    //cash_payment
//    Route::post('/saveCashPayment', 'PaymentCashController@saveCashPayment');
    Route::post('/saveCashPayment', [PaymentCashController::class,'saveCashPayment']);

    //owner_transaction_type
//    Route::get('/getTransactionType', 'TransactionTypeController@getTransactionType');
    Route::get('/getTransactionType', [TransactionTypeController::class,'getTransactionType']);

    //gold_payment
//    Route::post('/saveGoldPayment', 'PaymentGoldController@saveGoldPayment');
    Route::post('/saveGoldPayment', [PaymentGoldController::class,'saveGoldPayment']);

    //bill_adjustment
//    Route::get('/getBillAdjustment', 'BillAdjustmentController@getBillAdjustment');
    Route::get('/getBillAdjustment', [BillAdjustmentController::class,'getBillAdjustment']);

    //agent
//    Route::get('/agents', 'AgentController@index');
//    Route::post('/agents', 'AgentController@saveAgent');
//    Route::delete('/agents/{id}', 'AgentController@deleteAgent');
//    Route::patch('/agents/{id}', 'AgentController@updateAgent');
//    Route::get('/getDueByAgent','AgentController@getDueByAgent');
//    Route::get('/getCustomerUnderAgent/{id}','AgentController@getCustomerUnderAgent');

    Route::get('/agents', [AgentController::class,'index']);
    Route::post('/agents', [AgentController::class,'saveAgent']);
    Route::delete('/agents/{id}', [AgentController::class,'deleteAgent']);
    Route::patch('/agents/{id}', [AgentController::class,'updateAgent']);
    Route::get('/getDueByAgent',[AgentController::class,'getDueByAgent']);
    Route::get('/getCustomerUnderAgent/{id}',[AgentController::class,'getCustomerUnderAgent']);

    //customer_category
//    Route::get('/getCustomerCategory', 'CustomerCategoryController@getCustomerCategory');
    Route::get('/getCustomerCategory', [CustomerCategoryController::class,'getCustomerCategory']);

    //product_category
//    Route::get('/productCategory', 'ProductCategoryController@getProductCategories');
    Route::get('/productCategory', [ProductCategoryController::class,'getProductCategories']);

    //stock_controller
//    Route::get('/getStockRecord','StockController@index');
    Route::get('/getStockRecord',[StockController::class,'index']);

    //price_code
//    Route::get('/priceCodes', 'PriceCodeController@getPriceCodes');
    Route::get('/priceCodes', [PriceCodeController::class,'getPriceCodes']);

    //bill_master
//    Route::post('/saveBillMaster', 'BillMasterController@saveBillMaster');
//    Route::get('/getBilledJobList/{id}', 'BillMasterController@getBilledJobList');

    Route::post('/saveBillMaster', [BillMasterController::class,'saveBillMaster']);
    Route::get('/getBilledJobList/{id}', [BillMasterController::class,'getBilledJobList']);

    //testing for stock bill save
//    Route::post('/testBillSave', 'BillMasterController@testBillSave');
    Route::post('/testBillSave', [BillMasterController::class,'testBillSave']);

    //job_task
//    Route::post('/getTotal', 'JobTaskController@getTotal');
//    Route::get('/getAllTransactions/{id}', 'JobTaskController@getAllTransactions');
//    Route::post('/saveReturn', 'JobTaskController@saveReturn');
//    Route::post('/getJobTaskData', 'JobTaskController@getJobTaskData');
//    Route::get('/savedJobs', 'JobTaskController@getSavedJobs');
//    Route::get('/finishedJobs', 'JobTaskController@getFinishedJobs');
//    Route::get('/getOneJobData/{id}', 'JobTaskController@getOneJobData');
//    Route::get('/countTaskBadgeValue/{id}', 'JobTaskController@countTaskBadgeValue');

    Route::post('/getTotal', [JobTaskController::class,'getTotal']);
    Route::get('/getAllTransactions/{id}', [JobTaskController::class,'getAllTransactions']);
    Route::post('/saveReturn', [JobTaskController::class,'saveReturn']);
    Route::post('/getJobTaskData', [JobTaskController::class,'getJobTaskData']);
    Route::get('/savedJobs', [JobTaskController::class,'getSavedJobs']);
    Route::get('/finishedJobs', [JobTaskController::class,'getFinishedJobs']);
    Route::get('/getOneJobData/{id}', [JobTaskController::class,'getOneJobData']);
    Route::get('/countTaskBadgeValue/{id}', [JobTaskController::class,'countTaskBadgeValue']);

    //job_master
//    Route::post('/jobs', 'JobMasterController@saveJob');
//    Route::post('/finishJob', 'JobMasterController@updateGrossWeight');
//    Route::get('/getBilledJobInfo/{id}', 'JobMasterController@getBilledJobInfo');

    Route::post('/jobs', [JobMasterController::class,'saveJob']);
    Route::post('/finishJob', [JobMasterController::class,'updateGrossWeight']);
    Route::get('/getBilledJobInfo/{id}', [JobMasterController::class,'getBilledJobInfo']);


    //rate
//    Route::get('/getRates', 'RateController@getRates');
//    Route::post('/saveRate', 'RateController@newRate');
//    Route::delete('/deleteRate/{id}', 'RateController@deleteRate');
//    Route::put('/updateRate', 'RateController@updateRate');

    Route::get('/getRates', [RateController::class,'getRates']);
    Route::post('/saveRate', [RateController::class,'newRate']);
    Route::delete('/deleteRate/{id}', [RateController::class,'deleteRate']);
    Route::put('/updateRate', [RateController::class,'updateRate']);

    //product
//    Route::get('/products', 'ProductController@index');
//    Route::post('/products', 'ProductController@saveProduct');
//    Route::patch('/products', 'ProductController@updateProduct');
//    Route::delete('/products/{id}', 'ProductController@deleteProduct');
//    Route::post('/getProductData', 'ProductController@getProductData');

    Route::get('/products', [ProductController::class,'index']);
    Route::post('/products', [ProductController::class,'saveProduct']);
    Route::patch('/products', [ProductController::class,'updateProduct']);
    Route::delete('/products/{id}', [ProductController::class,'deleteProduct']);
    Route::post('/getProductData', [ProductController::class,'getProductData']);

    //materials
//    Route::get('/materials', 'MaterialController@getMaterials');
//    Route::get('/orderMaterials', 'MaterialController@getOrderMaterials');

    Route::get('/materials', [MaterialController::class,'getMaterials']);
    Route::get('/orderMaterials', [MaterialController::class,'getOrderMaterials']);

    //order_master
//    Route::get('/orders', 'OrderMasterController@index');
//    Route::patch('/orders', 'OrderMasterController@updateOrder');
//    Route::patch('/orderMaster', 'OrderMasterController@updateMaster');
//    Route::delete('/orderMasterDelete/{id}', 'OrderMasterController@deleteOrderMaster');
//    Route::post('/orders', 'OrderMasterController@saveOrder');
//    Route::post('/testSaveOrder', 'OrderMasterController@testSaveOrder');

    Route::get('/orders', [OrderMasterController::class,'index']);
    Route::patch('/orders', [OrderMasterController::class,'updateOrder']);
    Route::patch('/orderMaster', [OrderMasterController::class,'updateMaster']);
    Route::delete('/orderMasterDelete/{id}', [OrderMasterController::class,'deleteOrderMaster']);
    Route::post('/orders', [OrderMasterController::class,'saveOrder']);
    Route::post('/testSaveOrder', [OrderMasterController::class,'testSaveOrder']);

    //customer
//    Route::get('/customers', 'CustomerController@index');
//    Route::post('/customers', 'CustomerController@saveCustomer');
//    Route::patch('/customers/{id}', 'CustomerController@updateCustomer');
//    Route::delete('/customers/{id}', 'CustomerController@deleteCustomer');
//    Route::get('/completedBillCustomers', 'CustomerController@completedBillCustomers');
//    Route::post('/getCompletedBIllDetails', 'CustomerController@getCompletedBIllDetails');
//    Route::post('/getFinishedBillData', 'BillMasterController@getFinishedBillData');
//    Route::get('/showCompletedBills/{id}', 'CustomerController@showCompletedBills');
//    Route::get('/finishedJobsCustomers', 'CustomerController@finishedJobsCustomers');
//    Route::post('/fetchingDetails', 'CustomerController@getDetails');
//    Route::post('/getFinishedJobData', 'CustomerController@getFinishedJobData');
//    Route::get('/getGoldquantity/{id}', 'CustomerController@getGoldQuantityBill');
//    Route::get('/karigarhs', 'CustomerController@getkarigarhs');
//    Route::get('/getTotalGoldQuantity/{id}', 'CustomerController@getTotalGoldQuantity');
//    Route::get('/testGetEmployeeMaterial', 'CustomerController@testGetEmployeeMaterial');
//    Route::get('/getEmployeeMaterial', 'CustomerController@getEmployeeMaterial');
//    Route::get('/myTest', 'CustomerController@MyTest');
//    Route::get('/getCustomerPassbook/{id}', 'CustomerController@CustomerTransactionTest');

    Route::get('/customers', [CustomerController::class,'index']);
    Route::post('/customers', [CustomerController::class,'saveCustomer']);
    Route::patch('/customers/{id}', [CustomerController::class,'updateCustomer']);
    Route::delete('/customers/{id}', [CustomerController::class,'deleteCustomer']);
    Route::get('/completedBillCustomers', [CustomerController::class,'completedBillCustomers']);
    Route::post('/getCompletedBIllDetails', [CustomerController::class,'getCompletedBIllDetails']);
    Route::post('/getFinishedBillData', [BillMasterController::class,'getFinishedBillData']);
    Route::get('/showCompletedBills/{id}', [CustomerController::class,'showCompletedBills']);
    Route::get('/finishedJobsCustomers', [CustomerController::class,'finishedJobsCustomers']);
    Route::post('/fetchingDetails', [CustomerController::class,'getDetails']);
    Route::post('/getFinishedJobData', [CustomerController::class,'getFinishedJobData']);
    Route::get('/getGoldquantity/{id}', [CustomerController::class,'getGoldQuantityBill']);
    Route::get('/karigarhs', [CustomerController::class,'getKarigarhs']);
    Route::get('/getTotalGoldQuantity/{id}', [CustomerController::class,'getTotalGoldQuantity']);
    Route::get('/testGetEmployeeMaterial', [CustomerController::class,'testGetEmployeeMaterial']);
    Route::get('/getEmployeeMaterial', [CustomerController::class,'getEmployeeMaterial']);
    Route::get('/myTest', [CustomerController::class,'MyTest']);
    Route::get('/getCustomerPassbook/{id}', [CustomerController::class,'CustomerTransactionTest']);




    //order_detail
//    Route::post('/orderDetails', 'OrderDetailController@fetchingDetails');
//    Route::delete('/ordersDetailsDelete/{id}', 'OrderDetailController@deleteOrder');

    Route::post('/orderDetails', [OrderDetailController::class,'fetchingDetails']);
    Route::delete('/ordersDetailsDelete/{id}', [OrderDetailController::class,'deleteOrder']);

    //gold_receiveds
//    Route::get('/getCompletedBills','GoldReceivedController@getCompletedBills');
//    Route::post('/SaveReceivedGold','GoldReceivedController@SaveReceivedGold');

    //LC received
//    Route::get('/getLCReceived','LCReceivedController@SaveReceivedGold');
//    Route::post('/SaveLCReceived','LCReceivedController@SaveLCReceived');

    //Stock Controller

//    Route::get('/getStockRecord','StockController@index');
//    Route::post('/createStock','StockController@saveStock');
//    Route::get('/getStockCustomer','StockController@getStockCustomer');
//    Route::get('/getRecordByJobMasterId/{id}','StockController@getRecordByJobMasterId');
//    Route::get('/getStockList','StockController@getStockList');
//    Route::post('/updateStockByAgentId','StockController@updateStockByAgentId');
//    Route::post('/updateStockByDefaultAgentId','StockController@updateStockByDefaultAgentId');

    Route::get('/getStockRecord',[StockController::class,'index']);
    Route::post('/createStock',[StockController::class,'saveStock']);
    Route::get('/getStockCustomer',[StockController::class,'getStockCustomer']);
    Route::get('/getRecordByJobMasterId/{id}',[StockController::class,'getRecordByJobMasterId']);
    Route::get('/getStockList',[StockController::class,'getStockList']);
    Route::post('/updateStockByAgentId',[StockController::class,'updateStockByAgentId']);
    Route::post('/updateStockByDefaultAgentId',[StockController::class,'updateStockByDefaultAgentId']);

    //Material TransactionMaster Controller

//    Route::post('/saveTransaction','MaterialTransactionMasterController@saveTransaction');
//    Route::get('/getEmployees','MaterialTransactionMasterController@getEmployees');

    Route::post('/saveTransaction',[MaterialController::class,'saveTransaction']);
    Route::get('/getEmployees',[MaterialController::class,'getEmployees']);

});




Route::group(array('prefix' => 'dev'), function() {
    Route::get('/agents', [AgentController::class,'index']);

});

