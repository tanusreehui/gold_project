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
use App\Http\Controllers\UserTypeController;


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


//Route::get("getAllUsers",[UserController::class,'getAllUsers']);
//Route::group(array('prefix' => 'user'), function() {
//    Route::post("login",[UserController::class,'login']);
//    Route::post("register",[UserController::class,'register']);
//    Route::get('/customers', [CustomerController::class,'index']);
//});


Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/me', function(Request $request) {
        return auth()->user();
    });
    Route::get("user",[UserController::class,'getCurrentUser']);
    Route::put("user",[UserController::class,'updatePassword']);
    Route::get("token",[UserController::class,'getBearerToken']);
    Route::get("actualToken",[UserController::class,'actualToken']);
    Route::get("userHistory",[UserController::class,'getUserHistory']);
    Route::get("logout",[UserController::class,'logout']);
    Route::get("revokeAll",[UserController::class,'revoke_all']);


    //All secure URL's

    //cash_payment
    Route::post('/saveCashPayment', [PaymentCashController::class,'saveCashPayment']);

    //owner_transaction_type
    Route::get('/getTransactionType', [TransactionTypeController::class,'getTransactionType']);

    //gold_payment
    Route::post('/saveGoldPayment', [PaymentGoldController::class,'saveGoldPayment']);

    //bill_adjustment
    Route::get('/getBillAdjustment', [BillAdjustmentController::class,'getBillAdjustment']);

    //agent
    Route::get('/agents', [AgentController::class,'index']);
    Route::post('/agents', [AgentController::class,'saveAgent']);
    Route::delete('/agents/{id}', [AgentController::class,'deleteAgent']);
    Route::patch('/agents/{id}', [AgentController::class,'updateAgent']);
    Route::get('/getDueByAgent',[AgentController::class,'getDueByAgent']);
    Route::get('/getCustomerUnderAgent/{id}',[AgentController::class,'getCustomerUnderAgent']);

    //customer_category
    Route::get('/getCustomerCategory', [CustomerCategoryController::class,'getCustomerCategory']);

    //product_category
    Route::get('/productCategory', [ProductCategoryController::class,'getProductCategories']);

    //stock_controller
    Route::get('/getStockRecord',[StockController::class,'index']);

    //price_code
    Route::get('/priceCodes', [PriceCodeController::class,'getPriceCodes']);

    //bill_master
    Route::post('/saveBillMaster', [BillMasterController::class,'saveBillMaster']);
    Route::get('/getBilledJobList/{id}', [BillMasterController::class,'getBilledJobList']);

    //testing for stock bill save
    Route::post('/testBillSave', [BillMasterController::class,'testBillSave']);

    //job_task
    Route::post('/getTotal', [JobTaskController::class,'getTotal']);
    Route::get('/getAllTransactions/{id}', [JobTaskController::class,'getAllTransactions']);
    Route::post('/saveReturn', [JobTaskController::class,'saveReturn']);
    Route::post('/getJobTaskData', [JobTaskController::class,'getJobTaskData']);
    Route::get('/savedJobs', [JobTaskController::class,'getSavedJobs']);
    Route::get('/finishedJobs', [JobTaskController::class,'getFinishedJobs']);
    Route::get('/getOneJobData/{id}', [JobTaskController::class,'getOneJobData']);
    Route::get('/countTaskBadgeValue/{id}', [JobTaskController::class,'countTaskBadgeValue']);

    //job_master
    Route::post('/jobs', [JobMasterController::class,'saveJob']);
    Route::post('/finishJob', [JobMasterController::class,'updateGrossWeight']);
    Route::get('/getBilledJobInfo/{id}', [JobMasterController::class,'getBilledJobInfo']);

    //rate
    Route::get('/getRates', [RateController::class,'getRates']);
    Route::post('/saveRate', [RateController::class,'newRate']);
    Route::delete('/deleteRate/{id}', [RateController::class,'deleteRate']);
    Route::put('/updateRate', [RateController::class,'updateRate']);

    //product
    Route::get('/products', [ProductController::class,'index']);
    Route::post('/products', [ProductController::class,'saveProduct']);
    Route::patch('/products', [ProductController::class,'updateProduct']);
    Route::delete('/products/{id}', [ProductController::class,'deleteProduct']);
    Route::post('/getProductData', [ProductController::class,'getProductData']);

    //materials
    Route::get('/materials', [MaterialController::class,'getMaterials']);
    Route::get('/orderMaterials', [MaterialController::class,'getOrderMaterials']);

    //order_master
    Route::get('/orders', [OrderMasterController::class,'index']);
    Route::patch('/orders', [OrderMasterController::class,'updateOrder']);
    Route::patch('/orderMaster', [OrderMasterController::class,'updateMaster']);
    Route::delete('/orderMasterDelete/{id}', [OrderMasterController::class,'deleteOrderMaster']);
    Route::post('/orders', [OrderMasterController::class,'saveOrder']);
    Route::post('/testSaveOrder', [OrderMasterController::class,'testSaveOrder']);

    //customer
    Route::get('/customers', [CustomerController::class,'index']);
    Route::get('/customers/{id}', [CustomerController::class,'getCustomer']);
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
//    Route::get('/myTest', [CustomerController::class,'MyTest']);
//    Route::get('/getEmployeeStock', [CustomerController::class,'getEmployeeStock']);
    Route::get('/getEmployeeStock/{id}', [CustomerController::class,'getEmployeeStock']);
    Route::get('/getCustomerPassbook/{id}', [CustomerController::class,'CustomerTransactionTest']);
    Route::get('getEmployees', [CustomerController::class,'getEmployees']);

    //order_detail
    Route::post('/orderDetails', [OrderDetailController::class,'fetchingDetails']);
    Route::delete('/ordersDetailsDelete/{id}', [OrderDetailController::class,'deleteOrder']);

    //Stock Controller
    Route::get('/getStockRecord',[StockController::class,'index']);
    Route::post('/createStock',[StockController::class,'saveStock']);
    Route::get('/getStockCustomer',[StockController::class,'getStockCustomer']);
    Route::get('/getRecordByJobMasterId/{id}',[StockController::class,'getRecordByJobMasterId']);
    Route::get('/getStockList',[StockController::class,'getStockList']);
    Route::post('/updateStockByAgentId',[StockController::class,'updateStockByAgentId']);
    Route::post('/updateStockByDefaultAgentId',[StockController::class,'updateStockByDefaultAgentId']);

    //Material TransactionMaster Controller
    Route::post('/saveTransaction',[MaterialController::class,'saveTransaction']);
//    Route::get('/getEmployees',[MaterialController::class,'getEmployees']);

    //User Types Controller
    Route::get('/getUserTypes',[UserTypeController::class,'index']);

   // User Controller
    Route::get('/getEmployees',[UserController::class,'getEmployees']);
    Route::post('/resetPassword',[UserController::class,'resetPassword']);
    Route::post('/uploadPicture',[UserController::class,'uploadPicture']);

});


Route::group(array('prefix' => 'dev'), function() {
    //cash_payment
    Route::post('/saveCashPayment', [PaymentCashController::class,'saveCashPayment']);

    //owner_transaction_type
    Route::get('/getTransactionType', [TransactionTypeController::class,'getTransactionType']);

    //gold_payment
    Route::post('/saveGoldPayment', [PaymentGoldController::class,'saveGoldPayment']);

    //bill_adjustment
    Route::get('/getBillAdjustment', [BillAdjustmentController::class,'getBillAdjustment']);

    //agent
    Route::get('/agents', [AgentController::class,'index']);
    Route::post('/agents', [AgentController::class,'saveAgent']);
    Route::delete('/agents/{id}', [AgentController::class,'deleteAgent']);
    Route::patch('/agents/{id}', [AgentController::class,'updateAgent']);
    Route::get('/getDueByAgent',[AgentController::class,'getDueByAgent']);
    Route::get('/getCustomerUnderAgent/{id}',[AgentController::class,'getCustomerUnderAgent']);

    //customer_category
    Route::get('/getCustomerCategory', [CustomerCategoryController::class,'getCustomerCategory']);

    //product_category
    Route::get('/productCategory', [ProductCategoryController::class,'getProductCategories']);

    //stock_controller
    Route::get('/getStockRecord',[StockController::class,'index']);

    //price_code
    Route::get('/priceCodes', [PriceCodeController::class,'getPriceCodes']);

    //bill_master
    Route::post('/saveBillMaster', [BillMasterController::class,'saveBillMaster']);
    Route::get('/getBilledJobList/{id}', [BillMasterController::class,'getBilledJobList']);

    //testing for stock bill save
    Route::post('/testBillSave', [BillMasterController::class,'testBillSave']);

    //job_task
    Route::post('/getTotal', [JobTaskController::class,'getTotal']);
    Route::get('/getAllTransactions/{id}', [JobTaskController::class,'getAllTransactions']);
    Route::post('/saveReturn', [JobTaskController::class,'saveReturn']);
    Route::post('/getJobTaskData', [JobTaskController::class,'getJobTaskData']);
    Route::get('/savedJobs', [JobTaskController::class,'getSavedJobs']);
    Route::get('/finishedJobs', [JobTaskController::class,'getFinishedJobs']);
    Route::get('/getOneJobData/{id}', [JobTaskController::class,'getOneJobData']);
    Route::get('/countTaskBadgeValue/{id}', [JobTaskController::class,'countTaskBadgeValue']);

    //job_master
    Route::post('/jobs', [JobMasterController::class,'saveJob']);
    Route::post('/finishJob', [JobMasterController::class,'updateGrossWeight']);
    Route::get('/getBilledJobInfo/{id}', [JobMasterController::class,'getBilledJobInfo']);

    //rate
    Route::get('/getRates', [RateController::class,'getRates']);
    Route::post('/saveRate', [RateController::class,'newRate']);
    Route::delete('/deleteRate/{id}', [RateController::class,'deleteRate']);
    Route::put('/updateRate', [RateController::class,'updateRate']);

    //product
    Route::get('/products', [ProductController::class,'index']);
    Route::post('/products', [ProductController::class,'saveProduct']);
    Route::patch('/products', [ProductController::class,'updateProduct']);
    Route::delete('/products/{id}', [ProductController::class,'deleteProduct']);
    Route::post('/getProductData', [ProductController::class,'getProductData']);

    //materials
    Route::get('/materials', [MaterialController::class,'getMaterials']);
//    Route::get('/orderMaterials', [MaterialController::class,'getOrderMaterials']);

    //order_master
    Route::get('/orders', [OrderMasterController::class,'index']);
    Route::patch('/orders', [OrderMasterController::class,'updateOrder']);
    Route::patch('/orderMaster', [OrderMasterController::class,'updateMaster']);
    Route::delete('/orderMasterDelete/{id}', [OrderMasterController::class,'deleteOrderMaster']);
    Route::post('/orders', [OrderMasterController::class,'saveOrder']);
    Route::post('/testSaveOrder', [OrderMasterController::class,'testSaveOrder']);

    //customer
    Route::get('/customers', [CustomerController::class,'index']);
    Route::get('/customers/{id}', [CustomerController::class,'getCustomer']);
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
    Route::get('/getEmployeeStock', [CustomerController::class,'getEmployeeStock']);
    Route::get('/getCustomerPassbook/{id}', [CustomerController::class,'CustomerTransactionTest']);

    //order_detail
    Route::post('/orderDetails', [OrderDetailController::class,'fetchingDetails']);
    Route::delete('/ordersDetailsDelete/{id}', [OrderDetailController::class,'deleteOrder']);

    //Stock Controller
    Route::get('/getStockRecord',[StockController::class,'index']);
    Route::post('/createStock',[StockController::class,'saveStock']);
    Route::get('/getStockCustomer',[StockController::class,'getStockCustomer']);
    Route::get('/getRecordByJobMasterId/{id}',[StockController::class,'getRecordByJobMasterId']);
    Route::get('/getStockList',[StockController::class,'getStockList']);
    Route::post('/updateStockByAgentId',[StockController::class,'updateStockByAgentId']);
    Route::post('/updateStockByDefaultAgentId',[StockController::class,'updateStockByDefaultAgentId']);

    //Material TransactionMaster Controller
    Route::post('/saveTransaction',[MaterialController::class,'saveTransaction']);
    Route::get('/getEmployees',[MaterialController::class,'getEmployees']);

    //User Types Controller
    Route::get('/showCompletedBills',[UserTypeController::class,'index']);
    Route::post('/uploadPicture',[UserController::class,'uploadPicture']);
});

