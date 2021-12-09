<?php

namespace Database\Seeders;

//use App\Models\ExtraItem;
//use App\Models\Ledger;
//use App\Models\Unit;
//use App\Models\VoucherType;
use App\Models\Person;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserType;
//use App\Models\ProductCategory;
//use App\Models\TransactionType;
//use App\Models\LedgerGroup;
use App\Models\CustomerCategory;
//use App\Models\State;
use App\Models\statusType;
use App\Models\PriceCode;
use App\Models\JobTask;
use App\Models\MaterialCategory;
use App\Models\Material;
use App\Models\Rate;
use App\Models\ProductCategory;
use App\Models\BillAdjustment;
use App\Models\TransactionType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //customer_categories table data
        CustomerCategory::create(['customer_category_name'=>'Base']);
        CustomerCategory::create(['customer_category_name'=>'Base-50']);
        CustomerCategory::create(['customer_category_name'=>'Base-100']);
        CustomerCategory::create(['customer_category_name'=>'Base-150']);
        CustomerCategory::create(['customer_category_name'=>'Not Applicable']);

        StatusType::create(['id'=>1, 'name'=>'Started']);
        StatusType::create(['id'=>40, 'name'=>'Not Started']);
        StatusType::create(['id'=>100, 'name'=>'Finished']);
//        StatusType::create(['id'=>101, 'name'=>'Bill Created']);
        StatusType::create(['id'=>102, 'name'=>'Stock Created']);


        //bill_adjustments  table data
        BillAdjustment::create(['name'=>'pan', 'value'=>40,'comment'=>'40% of pan value taken']);
        BillAdjustment::create(['name'=>'nitric', 'value'=>96,'comment'=>'96% of nitric value taken']);

        //job_tasks table data
        JobTask::create(['task_name'=>'Gold Submit']);
        JobTask::create(['task_name'=>'Gold Return']);
        JobTask::create(['task_name'=>'Dal Submit']);
        JobTask::create(['task_name'=>'Dal Return']);
        JobTask::create(['task_name'=>'Pan Submit']);
        JobTask::create(['task_name'=>'Pan Return']);
        JobTask::create(['task_name'=>'Nitric Return']);
        JobTask::create(['task_name'=>'Bronze Submit']);
        JobTask::create(['task_name'=>'Bronze Return']);

        //material_categories table data
        MaterialCategory::create(['mc_name' => 'Gold']);
        MaterialCategory::create(['mc_name' => 'Silver']);
        MaterialCategory::create(['mc_name' => 'Copper']);
        MaterialCategory::create(['mc_name' => 'Bronze']);
        MaterialCategory::create(['mc_name' => 'Zinc']);
        MaterialCategory::create(['mc_name' => 'Dal']);

        //materials  table data
        Material::create(['material_name' => 'Pure Gold','material_category_id'=>1,'gold'=>100,'silver'=>0,'is_main_production_material'=>0,'is_base_material'=>0,'main_material_id'=>0,'bill_percentage'=>1]);
        Material::create(['material_name' => 'Pure Silver','material_category_id'=>2,'gold'=>0,'silver'=>100,'is_main_production_material'=>0,'is_base_material'=>0,'main_material_id'=>0,'bill_percentage'=>1]);
        Material::create(['material_name' => '92 Ginnie','material_category_id'=>1,'gold'=>92,'silver'=>0,'is_main_production_material'=>1,'is_base_material'=>1,'main_material_id'=>0,'is_order_material'=>1,'bill_percentage'=>1]);
        Material::create(['material_name' => 'Pan','material_category_id'=>1,'gold'=>40,'silver'=>20,'is_main_production_material'=>1,'is_base_material'=>0,'main_material_id'=>0,'bill_percentage'=>0.4]);
        Material::create(['material_name' => '90 Ginnie','material_category_id'=>1,'gold'=>90,'silver'=>0,'is_main_production_material'=>1,'is_base_material'=>0,'main_material_id'=>0,'bill_percentage'=>1]);
        Material::create(['material_name' => 'Dal','material_category_id'=>6,'gold'=>10,'silver'=>70,'is_main_production_material'=>1,'is_base_material'=>0,'main_material_id'=>0,'bill_percentage'=>1]);
        Material::create(['material_name' => 'Nitric','material_category_id'=>1,'gold'=>88,'silver'=>0,'is_main_production_material'=>0,'is_base_material'=>0,'main_material_id'=>0,'bill_percentage'=>0.96]);
        Material::create(['material_name' => 'Production_dust ','material_category_id'=>1,'gold'=>20,'silver'=>0,'is_main_production_material'=>0,'is_base_material'=>0,'main_material_id'=>0,'bill_percentage'=>1]);
        Material::create(['material_name' => '92 Ginnie Return ','material_category_id'=>1,'gold'=>92,'silver'=>0,'is_main_production_material'=>1,'is_base_material'=>1,'main_material_id'=>3,'bill_percentage'=>1]);
        Material::create(['material_name' => 'Dal Return','material_category_id'=>6,'gold'=>10,'silver'=>70,'is_main_production_material'=>1,'is_base_material'=>0,'main_material_id'=>6,'bill_percentage'=>1]);
        Material::create(['material_name' => 'Pan Return','material_category_id'=>1,'gold'=>40,'silver'=>20,'is_main_production_material'=>1,'is_base_material'=>0,'main_material_id'=>4,'bill_percentage'=>0.4]);
        Material::create(['material_name' => 'Bronze','material_category_id'=>4,'gold'=>0,'silver'=>0,'is_main_production_material'=>1,'is_base_material'=>0,'main_material_id'=>0,'bill_percentage'=>0]);
        Material::create(['material_name' => 'Bronze Return','material_category_id'=>4,'gold'=>0,'silver'=>0,'is_main_production_material'=>1,'is_base_material'=>0,'main_material_id'=>13,'bill_percentage'=>0.4]);
       // Material::create(['material_name' => 'Nitric Return','material_category_id'=>1,'gold'=>88,'silver'=>0,'is_main_production_material'=>0,'is_base_material'=>0,'main_material_id'=>7,'bill_percentage'=>1]);


        //price_code table data
        PriceCode::create(['price_code_name'=>'A']);
        PriceCode::create(['price_code_name'=>'B']);
        PriceCode::create(['price_code_name'=>'C']);
        PriceCode::create(['price_code_name'=>'D']);
        PriceCode::create(['price_code_name'=>'E']);
        PriceCode::create(['price_code_name'=>'F']);
        PriceCode::create(['price_code_name'=>'G']);
        PriceCode::create(['price_code_name'=>'H']);
        PriceCode::create(['price_code_name'=>'I']);
        PriceCode::create(['price_code_name'=>'J']);
        PriceCode::create(['price_code_name'=>'K']);
        PriceCode::create(['price_code_name'=>'L']);
        PriceCode::create(['price_code_name'=>'M']);
        PriceCode::create(['price_code_name'=>'N']);
        PriceCode::create(['price_code_name'=>'O']);
        PriceCode::create(['price_code_name'=>'P']);
        PriceCode::create(['price_code_name'=>'Q']);
        PriceCode::create(['price_code_name'=>'R']);
        PriceCode::create(['price_code_name'=>'S']);
        PriceCode::create(['price_code_name'=>'T']);
        PriceCode::create(['price_code_name'=>'U']);
        PriceCode::create(['price_code_name'=>'V']);
        PriceCode::create(['price_code_name'=>'W']);
        PriceCode::create(['price_code_name'=>'X']);
        PriceCode::create(['price_code_name'=>'Y']);
        PriceCode::create(['price_code_name'=>'Z']);
        PriceCode::create(['price_code_name'=>'AA']);
        PriceCode::create(['price_code_name'=>'FI']);
        PriceCode::create(['price_code_name'=>'FJ']);
        PriceCode::create(['price_code_name'=>'FK']);
        PriceCode::create(['price_code_name'=>'FL']);
        PriceCode::create(['price_code_name'=>'FM']);
        PriceCode::create(['price_code_name'=>'FN']);
        PriceCode::create(['price_code_name'=>'FO']);


        //product_categories table data
        ProductCategory::create(['category_name'=>'Baby']);
        ProductCategory::create(['category_name'=>'churi']);
        ProductCategory::create(['category_name'=>'solid churi']);
        ProductCategory::create(['category_name'=>'Mina Thokai patla']);
        ProductCategory::create(['category_name'=>'Thokai Churi']);
        ProductCategory::create(['category_name'=>'Bouty']);
        ProductCategory::create(['category_name'=>'Thokai Patla']);
        ProductCategory::create(['category_name'=>'Kankan']);
        ProductCategory::create(['category_name'=>'Xsample']);
        ProductCategory::create(['category_name'=>'Mima Churi']);
        ProductCategory::create(['category_name'=>'Holo Churi']);
        ProductCategory::create(['category_name'=>'Holo']);

        // \App\Models\User::factory(10)->create();
        //person_types table data
//        UserType::create(['user_type_name' => 'Owner']);
//        UserType::create(['user_type_name' => 'Manager']);
//        UserType::create(['user_type_name' => 'Manager Sales']);
//        UserType::create(['user_type_name' => 'Manager Accounts']);
//        UserType::create(['user_type_name' => 'Office Staff']);
//        UserType::create(['user_type_name' => 'Worker']);
//        UserType::create(['user_type_name' => 'Developer']);
//        UserType::create(['user_type_name' => 'Customer']);

        UserType::create(['user_type_name' => 'Owner']);
        UserType::create(['user_type_name' => 'Manager']);
        UserType::create(['user_type_name' => 'Manager Workshop']);
        UserType::create(['user_type_name' => 'Manager Sales']);
        UserType::create(['user_type_name' => 'Manager Accounts']);
        UserType::create(['user_type_name' => 'Office Staff']);
        UserType::create(['user_type_name' => 'Agent']);
        UserType::create(['user_type_name' => 'Worker']);
        UserType::create(['user_type_name' => 'Developer']);
        UserType::create(['user_type_name' => 'Customer']);
        UserType::create(['user_type_name' => 'Karigarh']);

        TransactionType::create(['transaction_type'=>'Inward']);
        TransactionType::create(['transaction_type'=>'Outward']);
        TransactionType::create(['transaction_type'=>'Transferred']);
        TransactionType::create(['transaction_type'=>'Withdrawal']);

        //rates  table data
        //base Rate
        Rate::create(['price_code_id'=>1,'price'=>'280','p_loss'=>'0.129','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>2,'price'=>'300','p_loss'=>'0.139','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>3,'price'=>'320','p_loss'=>'0.149','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>4,'price'=>'340','p_loss'=>'0.159','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>5,'price'=>'360','p_loss'=>'0.169','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>6,'price'=>'380','p_loss'=>'0.179','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>7,'price'=>'400','p_loss'=>'0.189','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>8,'price'=>'420','p_loss'=>'0.199','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>9,'price'=>'440','p_loss'=>'0.209','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>10,'price'=>'460','p_loss'=>'0.219','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>11,'price'=>'480','p_loss'=>'0.229','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>12,'price'=>'500','p_loss'=>'0.239','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>13,'price'=>'520','p_loss'=>'0.249','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>14,'price'=>'540','p_loss'=>'0.259','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>15,'price'=>'560','p_loss'=>'0.269','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>16,'price'=>'580','p_loss'=>'0.59','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>17,'price'=>'600','p_loss'=>'0.649','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>18,'price'=>'620','p_loss'=>'0.699','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>19,'price'=>'640','p_loss'=>'0.255','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>20,'price'=>'660','p_loss'=>'0.275','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>21,'price'=>'680','p_loss'=>'0.295','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>22,'price'=>'700','p_loss'=>'0.315','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>23,'price'=>'720','p_loss'=>'0.335','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>24,'price'=>'740','p_loss'=>'0.355','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>25,'price'=>'760','p_loss'=>'0.375','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>26,'price'=>'780','p_loss'=>'0.395','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>27,'price'=>'290','p_loss'=>'0.415','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>28,'price'=>'440','p_loss'=>'0.435','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>29,'price'=>'460','p_loss'=>'0.455','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>30,'price'=>'480','p_loss'=>'0.475','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>31,'price'=>'500','p_loss'=>'0.495','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>32,'price'=>'520','p_loss'=>'0.515','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>33,'price'=>'540','p_loss'=>'0.535','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>34,'price'=>'560','p_loss'=>'0.555','customer_category_id'=>1]);


        //base-50
        Rate::create(['price_code_id'=>1,'price'=>'330','p_loss'=>'0.129','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>2,'price'=>'350','p_loss'=>'0.139','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>3,'price'=>'370','p_loss'=>'0.149','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>4,'price'=>'390','p_loss'=>'0.159','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>5,'price'=>'410','p_loss'=>'0.169','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>6,'price'=>'430','p_loss'=>'0.179','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>7,'price'=>'450','p_loss'=>'0.189','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>8,'price'=>'470','p_loss'=>'0.199','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>9,'price'=>'490','p_loss'=>'0.209','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>10,'price'=>'510','p_loss'=>'0.219','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>11,'price'=>'530','p_loss'=>'0.229','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>12,'price'=>'550','p_loss'=>'0.239','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>13,'price'=>'570','p_loss'=>'0.249','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>14,'price'=>'590','p_loss'=>'0.259','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>15,'price'=>'610','p_loss'=>'0.269','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>16,'price'=>'630','p_loss'=>'0.59','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>17,'price'=>'650','p_loss'=>'0.649','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>18,'price'=>'670','p_loss'=>'0.699','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>19,'price'=>'690','p_loss'=>'0.255','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>20,'price'=>'710','p_loss'=>'0.275','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>21,'price'=>'730','p_loss'=>'0.295','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>22,'price'=>'750','p_loss'=>'0.315','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>23,'price'=>'770','p_loss'=>'0.335','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>24,'price'=>'790','p_loss'=>'0.355','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>25,'price'=>'810','p_loss'=>'0.375','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>26,'price'=>'830','p_loss'=>'0.395','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>27,'price'=>'340','p_loss'=>'0.415','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>28,'price'=>'490','p_loss'=>'0.435','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>29,'price'=>'510','p_loss'=>'0.455','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>30,'price'=>'530','p_loss'=>'0.475','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>31,'price'=>'550','p_loss'=>'0.495','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>32,'price'=>'570','p_loss'=>'0.515','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>33,'price'=>'590','p_loss'=>'0.535','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>34,'price'=>'610','p_loss'=>'0.555','customer_category_id'=>2]);



        //base-100
        Rate::create(['price_code_id'=>1,'price'=>'380','p_loss'=>'0.129','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>2,'price'=>'400','p_loss'=>'0.139','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>3,'price'=>'420','p_loss'=>'0.149','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>4,'price'=>'440','p_loss'=>'0.159','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>5,'price'=>'460','p_loss'=>'0.169','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>6,'price'=>'480','p_loss'=>'0.179','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>7,'price'=>'500','p_loss'=>'0.189','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>8,'price'=>'520','p_loss'=>'0.199','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>9,'price'=>'540','p_loss'=>'0.209','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>10,'price'=>'560','p_loss'=>'0.219','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>11,'price'=>'580','p_loss'=>'0.229','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>12,'price'=>'600','p_loss'=>'0.239','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>13,'price'=>'620','p_loss'=>'0.249','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>14,'price'=>'640','p_loss'=>'0.259','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>15,'price'=>'660','p_loss'=>'0.269','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>16,'price'=>'680','p_loss'=>'0.59','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>17,'price'=>'700','p_loss'=>'0.649','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>18,'price'=>'720','p_loss'=>'0.699','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>19,'price'=>'740','p_loss'=>'0.255','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>20,'price'=>'760','p_loss'=>'0.275','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>21,'price'=>'780','p_loss'=>'0.295','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>22,'price'=>'800','p_loss'=>'0.315','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>23,'price'=>'820','p_loss'=>'0.335','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>24,'price'=>'840','p_loss'=>'0.355','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>25,'price'=>'860','p_loss'=>'0.375','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>26,'price'=>'880','p_loss'=>'0.395','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>27,'price'=>'390','p_loss'=>'0.415','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>28,'price'=>'540','p_loss'=>'0.435','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>29,'price'=>'560','p_loss'=>'0.455','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>30,'price'=>'580','p_loss'=>'0.475','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>31,'price'=>'600','p_loss'=>'0.495','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>32,'price'=>'620','p_loss'=>'0.515','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>33,'price'=>'640','p_loss'=>'0.535','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>34,'price'=>'660','p_loss'=>'0.555','customer_category_id'=>3]);


        //Base-150
        Rate::create(['price_code_id'=>1,'price'=>'430','p_loss'=>'0.129','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>2,'price'=>'450','p_loss'=>'0.139','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>3,'price'=>'470','p_loss'=>'0.149','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>4,'price'=>'490','p_loss'=>'0.159','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>5,'price'=>'510','p_loss'=>'0.169','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>6,'price'=>'530','p_loss'=>'0.179','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>7,'price'=>'550','p_loss'=>'0.189','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>8,'price'=>'570','p_loss'=>'0.199','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>9,'price'=>'590','p_loss'=>'0.209','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>10,'price'=>'610','p_loss'=>'0.219','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>11,'price'=>'630','p_loss'=>'0.229','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>12,'price'=>'650','p_loss'=>'0.239','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>13,'price'=>'670','p_loss'=>'0.249','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>14,'price'=>'690','p_loss'=>'0.259','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>15,'price'=>'710','p_loss'=>'0.269','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>16,'price'=>'730','p_loss'=>'0.59','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>17,'price'=>'750','p_loss'=>'0.649','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>18,'price'=>'770','p_loss'=>'0.699','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>19,'price'=>'790','p_loss'=>'0.255','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>20,'price'=>'810','p_loss'=>'0.275','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>21,'price'=>'830','p_loss'=>'0.295','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>22,'price'=>'850','p_loss'=>'0.315','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>23,'price'=>'870','p_loss'=>'0.335','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>24,'price'=>'890','p_loss'=>'0.355','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>25,'price'=>'910','p_loss'=>'0.375','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>26,'price'=>'930','p_loss'=>'0.395','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>27,'price'=>'440','p_loss'=>'0.415','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>28,'price'=>'590','p_loss'=>'0.435','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>29,'price'=>'610','p_loss'=>'0.455','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>30,'price'=>'630','p_loss'=>'0.475','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>31,'price'=>'650','p_loss'=>'0.495','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>32,'price'=>'670','p_loss'=>'0.515','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>33,'price'=>'690','p_loss'=>'0.535','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>34,'price'=>'710','p_loss'=>'0.555','customer_category_id'=>4]);





//        User::create(['user_name'=>'Arindam Biswas','mobile1'=>'9836444999','mobile2'=>'100','email'=>'arindam','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>1]);

//        User::create(['user_name'=>'Counter Agent','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle396@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>7]);
//        User::create(['user_name'=>'Abishek Basak','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle39612@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>7]);
//        User::create(['user_name'=>'Sudip Roy','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle396002@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>7]);
//        User::create(['user_name'=>'Bijon Dey','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle39611@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>7]);
//
//        User::create(['user_name'=>'Rik Roy','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle39600@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>2]);
//        User::create(['user_name'=>'Abijit Basak','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle39612000@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>3]);
//        User::create(['user_name'=>'Sudipto Roy','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle39600005@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>4]);
//        User::create(['user_name'=>'Bijit Dey','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle3961100@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>5]);
//        User::create(['user_name'=>'Prodip Ghosh','mobile1'=>'9836444785','mobile2'=>'','email'=>'bangle3710@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>6]);
//
//        User::create(['user_name'=>'Pushpendu Roy','mobile1'=>'9836444426','mobile2'=>'','email'=>'bangle376@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>8]);
//        User::create(['user_name'=>'Pushpendu Ghosh','mobile1'=>'9836444785','mobile2'=>'','email'=>'bangle371@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>10,'customer_category_id'=>2]);
//
//        User::create(['user_name'=>'Joy Ghosh','mobile1'=>'9836444972','mobile2'=>'','email'=>'bangle322@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>11,'customer_category_id'=>3]);
//        User::create(['user_name'=>'Erik Ghosh','mobile1'=>'9836444972','mobile2'=>'','email'=>'bangle333@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>11,'customer_category_id'=>3]);
//        User::create(['user_name'=>'Tuhin Ghosh','mobile1'=>'9836444972','mobile2'=>'','email'=>'bangle344@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>11,'customer_category_id'=>3]);
//
//        User::create(['user_name'=>'kk Ghosh','mobile1'=>'9836444972','mobile2'=>'','email'=>'bangle3022@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>11,'customer_category_id'=>3]);
//        User::create(['user_name'=>'abcd Ghosh','mobile1'=>'9836444972','mobile2'=>'','email'=>'bangle3033@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'user_type_id'=>11,'customer_category_id'=>3]);



        //people table data
        //Owner- person id is 1
        Person::create(['user_name'=>'Vivekananda Ghosh','billing_name'=>' ','mobile1'=>'9836444999','mobile2'=>'','user_type_id'=>1]);
        //Counter Agent - person id is 2
        Person::create(['user_name'=>'Counter Agent','billing_name'=>' ','mobile1'=>'9836444451','mobile2'=>'','user_type_id'=>7]);
        //number 1 & number 2 fixed..cant change them
        Person::create(['user_name'=>'Arindam Ghosh','billing_name'=>' ','mobile1'=>'98364411221','mobile2'=>'','user_type_id'=>2]);
        Person::create(['user_name'=>'Arindam Biswas','billing_name'=>' ','mobile1'=>'7003031560','mobile2'=>'','user_type_id'=>3]);


        Person::create(['user_name'=>'Sameeran Majumdar','billing_name'=>' ','mobile1'=>'9830530463','mobile2'=>'','user_type_id'=>7]);

        Person::create(['user_name'=>'Jit Das','billing_name'=>' ','mobile1'=>'9830530463','mobile2'=>'','user_type_id'=>11]);
        Person::create(['user_name'=>'Asit Pal','billing_name'=>' ','mobile1'=>'9830530463','mobile2'=>'','user_type_id'=>11]);
        Person::create(['user_name'=>'Manik Sen','billing_name'=>' ','mobile1'=>'9830530463','mobile2'=>'','user_type_id'=>11]);


//        Person::create(['user_name'=>'Riya Guha Choudhury','billing_name'=>' ','mobile1'=>'9830530462','mobile2'=>'','user_type_id'=>9]);
//        Person::create(['user_name'=>'Priyam Ghosh','billing_name'=>' ','mobile1'=>'9830530463','mobile2'=>'','user_type_id'=>9]);
//        Person::create(['user_name'=>'Sukanta Hui','billing_name'=>' ','mobile1'=>'9830530461','mobile2'=>'','user_type_id'=>9]);





        //Sample Customers

        Person::create(['user_name'=>'Angana Jewellers', 'billing_name'=>'M/s Angana Jewellers', 'mobile1'=>'9831397484', 'mobile2'=>'546546464', 'user_type_id'=>10, 'customer_category_id'=>1,'address1'=> 'Barrackpore','address2'=>'Barrackpore','state'=>'West Bengal','po'=>'N.C. Pukur','area'=>'Barrackpore', 'city'=>'Shyamnagar', 'pin'=>'700123', 'mv'=>'.22', 'opening_balance_LC'=>'20000','opening_balance_Gold'=>'1000','discount'=>'10']);
        Person::create(['user_name'=>'Milan Kanak Sanj Jewellers', 'billing_name'=>'M/s Milan Kanak Sanj Jewellers', 'mobile1'=>'943382305', 'mobile2'=>'24338894', 'user_type_id'=>10, 'customer_category_id'=>1,'address1'=> 'Barrackpore','address2'=>'Barrackpore','state'=>'West Bengal','po'=>'N.C. Pukur','area'=>'Barrackpore', 'city'=>'Baruipur', 'pin'=>'700123', 'mv'=>'.22', 'opening_balance_LC'=>'20000','opening_balance_Gold'=>'1000','discount'=>'10']);
        Person::create(['user_name'=>'Jewell Garden (Khardha)', 'billing_name'=>'M/s Jewell Garden ', 'mobile1'=>'33-25685776', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1,'address1'=> 'Barrackpore','address2'=>'Barrackpore','state'=>'West Bengal','po'=>'N.C. Pukur','area'=>'Barrackpore', 'city'=>'Khardha', 'pin'=>'700123', 'mv'=>'.22', 'opening_balance_LC'=>'20000','opening_balance_Gold'=>'1000','discount'=>'10']);
        Person::create(['user_name'=>'K . C Choudhury & Sons Jewellers', 'billing_name'=>'M/s K . C Choudhury & Sons Jewellers', 'mobile1'=>'33-25636117', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1,'address1'=> 'Barrackpore','address2'=>'Barrackpore','state'=>'West Bengal','po'=>'N.C. Pukur','area'=>'Barrackpore', 'city'=>'Khardha', 'pin'=>'700123', 'mv'=>'.22', 'opening_balance_LC'=>'20000','opening_balance_Gold'=>'1000','discount'=>'10']);
        Person::create(['user_name'=>'New Anjali Jewellers', 'billing_name'=>'M/s New Anjali Jewellers', 'mobile1'=>'9831033871', 'mobile2'=>'/26641248', 'user_type_id'=>10, 'customer_category_id'=>1,'address1'=> 'Barrackpore','address2'=>'Barrackpore','state'=>'West Bengal','po'=>'N.C. Pukur','area'=>'Barrackpore', 'city'=>'Uttarpara', 'pin'=>'721158', 'mv'=>'.22', 'opening_balance_LC'=>'20000','opening_balance_Gold'=>'1000','discount'=>'10']);
        Person::create(['user_name'=>'Sukanya Jewellery House', 'billing_name'=>'M/s Sukanya Jewellery House', 'mobile1'=>'33-25681502', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1,'address1'=> 'Barrackpore','address2'=>'Barrackpore','state'=>'West Bengal','po'=>'N.C. Pukur','area'=>'Barrackpore', 'city'=>'Khardha', 'pin'=>'700123', 'mv'=>'.22', 'opening_balance_LC'=>'20000','opening_balance_Gold'=>'1000','discount'=>'10']);
        Person::create(['user_name'=>'Subhasree Jewellers', 'billing_name'=>'M/s Subhasree Jewellers', 'mobile1'=>'7602429823', 'mobile2'=>'/8167802629', 'user_type_id'=>10, 'customer_category_id'=>1,'address1'=> 'Barrackpore','address2'=>'Barrackpore','state'=>'West Bengal','po'=>'N.C. Pukur','area'=>'Barrackpore', 'city'=>'Mecheda', 'pin'=>'700123', 'mv'=>'.22', 'opening_balance_LC'=>'20000','opening_balance_Gold'=>'1000','discount'=>'10']);
        Person::create(['user_name'=>'S.S. Paul Jewellers', 'billing_name'=>'M/s S.S. Paul Jewellers', 'mobile1'=>'9830585936', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1,'address1'=> 'Barrackpore','address2'=>'Barrackpore','state'=>'West Bengal','po'=>'N.C. Pukur','area'=>'Barrackpore', 'city'=>'Dumdum', 'pin'=>'700123', 'mv'=>'.22', 'opening_balance_LC'=>'20000','opening_balance_Gold'=>'1000','discount'=>'10']);
        Person::create(['user_name'=>'Apan Jewellers', 'billing_name'=>'M/s Apan Jewellers', 'mobile1'=>'33-25386902', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1,'address1'=> 'Barrackpore','address2'=>'Barrackpore','state'=>'West Bengal','po'=>'N.C. Pukur','area'=>'Barrackpore', 'city'=>'Madhyamgram', 'pin'=>'700123', 'mv'=>'.22', 'opening_balance_LC'=>'20000','opening_balance_Gold'=>'1000','discount'=>'10']);
        Person::create(['user_name'=>'Venus Jewellers', 'billing_name'=>'M/s Venus Jewellers', 'mobile1'=>'33-253816750', 'mobile2'=>' , 983051222', 'user_type_id'=>10, 'customer_category_id'=>1,'address1'=> 'Barrackpore','address2'=>'Barrackpore','state'=>'West Bengal','po'=>'N.C. Pukur','area'=>'Barrackpore', 'city'=>'Madhyamgram ', 'pin'=>'700123', 'mv'=>'.22', 'opening_balance_LC'=>'20000','opening_balance_Gold'=>'1000','discount'=>'10']);



//        Person::create(['user_name'=>'Swarna Tarangini Jewellers', 'billing_name'=>'M/s Swarna Tarangini Jewellers', 'mobile1'=>'8538877077', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Maldha', 'pin'=>'0']);
//        Person::create(['user_name'=>'Sachidananda Jewellers', 'billing_name'=>'M/s Sachidananda Jewellers', 'mobile1'=>'9475173012', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Raniganj', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Annapurna Jewellers', 'billing_name'=>'M/s New Annapurna Jewellers', 'mobile1'=>'9088808465', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Lakhsmikantapore', 'pin'=>'00000']);
//        Person::create(['user_name'=>'R . C Jewellers(sainthia)', 'billing_name'=>'M/s R . C Jewellers', 'mobile1'=>'9933999273', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sainthia', 'pin'=>'0']);
//        Person::create(['user_name'=>'Rupashree Gold', 'billing_name'=>'M/s Rupashree Gold', 'mobile1'=>'33-2334920', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Saltlake', 'pin'=>'0']);
//        Person::create(['user_name'=>'Maa Rakshakali Jewellers', 'billing_name'=>'M/s Maa Rakshakali Jewellers', 'mobile1'=>'9735136575', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Suri', 'pin'=>'0']);
//        Person::create(['user_name'=>'Sathi Jewellers', 'billing_name'=>'M/s Sathi Jewellers', 'mobile1'=>'33-25305202', 'mobile2'=>' , 65219867', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Das Jewellers (Srithi)', 'billing_name'=>'M/s Das Jewellers ', 'mobile1'=>'9831612926', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Srithi', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Das Brothers Jewellers', 'billing_name'=>'M/s New Das Brothers Jewellers', 'mobile1'=>'9831526285', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Srithi', 'pin'=>'0']);
//        Person::create(['user_name'=>'Dey Brothers Jewellers', 'billing_name'=>'M/s Dey Brothers Jewellers', 'mobile1'=>'33-25329343', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Srithi', 'pin'=>'0']);
//        Person::create(['user_name'=>'M. B. Gold Museum', 'billing_name'=>'M/s M. B. Gold Museum', 'mobile1'=>'25452797', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'Kol-120']);
//        Person::create(['user_name'=>'Dutta Guinea Emporium', 'billing_name'=>'M/s Dutta Guinea Emporium', 'mobile1'=>'9804036755', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Srithi', 'pin'=>'0']);
//        Person::create(['user_name'=>'Rashiklal Jewellers', 'billing_name'=>'M/s Rashiklal Jewellers', 'mobile1'=>'9732059280', 'mobile2'=>' , 346225731', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Suri', 'pin'=>'0']);
//        Person::create(['user_name'=>'Bishalaxmi Jewellers', 'billing_name'=>'M/s Bishalaxmi Jewellers', 'mobile1'=>'3174258300', 'mobile2'=>' , 9830800300', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Diamond Hurber', 'pin'=>'0']);
//        Person::create(['user_name'=>'Maa Sarada Jewellers', 'billing_name'=>'M/s Maa Sarada Jewellers', 'mobile1'=>'9038206845', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sodepur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Beauti Jewellers', 'billing_name'=>'M/s Beauti Jewellers', 'mobile1'=>'9830966022', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Belgharia', 'pin'=>'0']);
//        Person::create(['user_name'=>'V Ghosh', 'billing_name'=>'V Ghosh', 'mobile1'=>'9836444999', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'0']);
//        Person::create(['user_name'=>'National Jewellery Palace', 'billing_name'=>'M/s National Jewellery Palace', 'mobile1'=>'9474706159', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Arambhag', 'pin'=>'0']);
//        Person::create(['user_name'=>'Joy Jewellers', 'billing_name'=>'M/s Joy Jewellers', 'mobile1'=>'8001561333', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Arambagh', 'pin'=>'0']);
//        Person::create(['user_name'=>'Vaishanadevi Jewellers', 'billing_name'=>'M/s Vaishanadevi Jewellers', 'mobile1'=>'9330402013 ', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Birati', 'pin'=>'0']);
//        Person::create(['user_name'=>'Maya Jewellers', 'billing_name'=>'M/s Maya Jewellers', 'mobile1'=>'9851053029', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Arambagh', 'pin'=>'0']);
//        Person::create(['user_name'=>'Karukanchan Jewellers', 'billing_name'=>'M/s Karukanchan Jewellers', 'mobile1'=>'33-25520142', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barasat', 'pin'=>'0']);
//        Person::create(['user_name'=>'Uttam Jewellers', 'billing_name'=>'M/s Uttam Jewellers', 'mobile1'=>'9831625780', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Chandannagar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Pushpa Gahanalay Jewellers', 'billing_name'=>'M/s Pushpa Gahanalay Jewellers', 'mobile1'=>'9433828458', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Chandannagar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Ashirbad Jewellers New Alipore', 'billing_name'=>'M/s Ashirbad Jewellers', 'mobile1'=>'7003274200', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'New Alipore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Paul Jewellers', 'billing_name'=>'M/s Paul Jewellers', 'mobile1'=>'9231884352', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kolkata', 'pin'=>'0']);
//        Person::create(['user_name'=>'B . K Jewellers', 'billing_name'=>'M/s B . K Jewellers', 'mobile1'=>'9331944102', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Chinsurah', 'pin'=>'0']);
//        Person::create(['user_name'=>'S .M Jewellers', 'billing_name'=>'M/s S .M Jewellers', 'mobile1'=>'8013363767', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Chinsurah', 'pin'=>'0']);
//        Person::create(['user_name'=>'Royco Jewellery ', 'billing_name'=>'M/s Royco Jewellery ', 'mobile1'=>'33-26811920 , 9874633306', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Chinsurah', 'pin'=>'0']);
//        Person::create(['user_name'=>'Neha Jewellers', 'billing_name'=>'M/s Neha Jewellers', 'mobile1'=>'9903103553', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Chinsurah', 'pin'=>'0']);
//        Person::create(['user_name'=>'S .R Jewellers', 'billing_name'=>'M/s S .R Jewellers', 'mobile1'=>'33-26704633 , 9748557593', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Domjur', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Parashmani Jewellers', 'billing_name'=>'M/s New Parashmani Jewellers', 'mobile1'=>'7797762113', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Durgapore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Biswajit Jewellers', 'billing_name'=>'M/s Biswajit Jewellers', 'mobile1'=>'9153021470 ', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Durgapore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Govind Jewellers', 'billing_name'=>'M/s Govind Jewellers', 'mobile1'=>'9434061309', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Durgapore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Dey Brothers Jewllers (Durgapore)', 'billing_name'=>'M/s Dey Brothers Jewllers ', 'mobile1'=>'9434332591', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Durgapore', 'pin'=>'0']);
//        Person::create(['user_name'=>'R .C Chandra Jewellers', 'billing_name'=>'M/s R .C Chandra Jewellers', 'mobile1'=>'9434444444', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Durgapore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Joy Jagannath Jewellers', 'billing_name'=>'M/s Joy Jagannath Jewellers', 'mobile1'=>'9830295320', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Howrah', 'pin'=>'0']);
//        Person::create(['user_name'=>'Dutta Guinea Palace', 'billing_name'=>'M/s Dutta Guinea Palace', 'mobile1'=>'9434014553', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Durgapore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Radha Gobinda Jewellers', 'billing_name'=>'M/s Radha Gobinda Jewellers', 'mobile1'=>'9038879778', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sodepur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Gold Palace (Sodepur)', 'billing_name'=>'M/s Gold Palace ', 'mobile1'=>'9051817207', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sodepur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Maa Kali Jewellers', 'billing_name'=>'M/s Maa Kali Jewellers', 'mobile1'=>'9732538367', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Mecheda', 'pin'=>'0']);
//        Person::create(['user_name'=>'R . C  Jewellers (Sodepur)', 'billing_name'=>'M/s R . C  Jewellers ', 'mobile1'=>'9830856286', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sodepur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Guinea Bhavan Jewellers', 'billing_name'=>'M/s Guinea Bhavan Jewellers', 'mobile1'=>'9143237892', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sodepur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Nandi Jewellery House', 'billing_name'=>'M/sNandi Jewellery House', 'mobile1'=>'9903751511', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Howrah', 'pin'=>'How-1']);
//        Person::create(['user_name'=>'Nag Jewellery', 'billing_name'=>'M/S Nag Jewellery', 'mobile1'=>'24401308/40014985', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Gariahat', 'pin'=>'Kol-19']);
//        Person::create(['user_name'=>'Rajrajeswari Jewellers', 'billing_name'=>'M/s Rajrajeswari Jewellers', 'mobile1'=>'8017282660 , 9830014395', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sodepur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Srikrishna Jewellers (Sodepur)', 'billing_name'=>'M/s Srikrishna Jewellers ', 'mobile1'=>'9830318457', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sodepur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Bhukta Jewellers Pvt. Ltd', 'billing_name'=>'M/s Bhukta Jewellers Pvt. Ltd', 'mobile1'=>'9331033686 ', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'700004']);
//        Person::create(['user_name'=>'Nilima Guinea Palace', 'billing_name'=>'M/s Nilima Guinea Palace', 'mobile1'=>'9609226794 , 9800519885', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Tamluk', 'pin'=>'0']);
//        Person::create(['user_name'=>'Alankar Jewellers', 'billing_name'=>'M/s Alankar Jewellers', 'mobile1'=>'9733901247', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bangaon', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Singha Jewellers', 'billing_name'=>'M/s New Singha Jewellers', 'mobile1'=>'9434102135', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bangaon', 'pin'=>'0']);
//        Person::create(['user_name'=>'Arati Jewellers', 'billing_name'=>'M/s Arati Jewellers', 'mobile1'=>'9332245939', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bangaon', 'pin'=>'0']);
//        Person::create(['user_name'=>'Laxmi Jewellers (Bangaon)', 'billing_name'=>'M/s Laxmi Jewellers', 'mobile1'=>'99326114744', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bangaon', 'pin'=>'0']);
//        Person::create(['user_name'=>'Motiganj Singha Jewellers', 'billing_name'=>'M/s Motiganj Singha Jewellers', 'mobile1'=>'321-5257177 , 9735412009', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bangaon', 'pin'=>'0']);
//        Person::create(['user_name'=>'Matadi Jewellers', 'billing_name'=>'M/s Matadi Jewellers', 'mobile1'=>'2483-8416 , 2351-0796', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Jodhpur', 'pin'=>'700068']);
//        Person::create(['user_name'=>'Dacca Jewellery House', 'billing_name'=>'M/s Dacca Jewellery House', 'mobile1'=>'9874173050', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Gariahut', 'pin'=>'0']);
//        Person::create(['user_name'=>'Erika Jewellers', 'billing_name'=>'M/s Erika Jewellers', 'mobile1'=>'2414-4156', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Gariahut', 'pin'=>'700031']);
//        Person::create(['user_name'=>'Sri Dhirendra Nath Dutta Jewellers Pvt. Ltd', 'billing_name'=>'M/s Sri Dhirendra Nath Dutta Jewellers Pvt. Ltd', 'mobile1'=>'3453-255068 , 9732293590', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Katwa', 'pin'=>'0']);
//        Person::create(['user_name'=>'K.B. Paul Jewellers', 'billing_name'=>'M/s K.B. Paul Jewellers', 'mobile1'=>'7003202927', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Srirampur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Dhar Jewellery Mansion', 'billing_name'=>'M/s Dhar Jewellery Mansion', 'mobile1'=>'9831580889', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Hind Motor', 'pin'=>'0']);
//        Person::create(['user_name'=>'P .C Jewellers ', 'billing_name'=>'M/s P .C Jewellers ', 'mobile1'=>'9832113385 ,9333611026', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Katwa', 'pin'=>'0']);
//        Person::create(['user_name'=>'Priyo Jewellery Palace', 'billing_name'=>'M/s Priyo Jewellery Palace', 'mobile1'=>'33-24221620', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Laketown', 'pin'=>'0']);
//        Person::create(['user_name'=>'D. S Debnath Jewellers', 'billing_name'=>'M/s D. S Debnath Jewellers', 'mobile1'=>'9088516383 , 24340180', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sonarpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Modern Guinea Mansion', 'billing_name'=>'M/s Modern Guinea Mansion', 'mobile1'=>'33-24637739 , 24383068', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kobordanga', 'pin'=>'0']);
//        Person::create(['user_name'=>'Raj Jewellers', 'billing_name'=>'M/s Raj Jewellers', 'mobile1'=>'8100805482', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bandle', 'pin'=>'0']);
//        Person::create(['user_name'=>'Singha Jewellers (Khoka)', 'billing_name'=>'M/s Singha Jewellers ', 'mobile1'=>'9830310524', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Khulna Art ', 'billing_name'=>'M/s New Khulna Art ', 'mobile1'=>'9831236195', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Lokenath Jewellers', 'billing_name'=>'M/s Lokenath Jewellers', 'mobile1'=>'9833466079', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Chinsurah', 'pin'=>'0']);
//        Person::create(['user_name'=>'Radharani Jewellers', 'billing_name'=>'M/s Radharani Jewellers', 'mobile1'=>'9748188283 , 33-25948704', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Ichapore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Kalika Prasad Gold', 'billing_name'=>'M/s Kalika Prasad Gold', 'mobile1'=>'9831016302 ', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Howrah', 'pin'=>'0']);
//        Person::create(['user_name'=>'Ashirbad Jewellers', 'billing_name'=>'M/s Ashirbad Jewellers', 'mobile1'=>'9339369848', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Jagaddal', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Mathura Prasad Jewellers', 'billing_name'=>'M/s New Mathura Prasad Jewellers', 'mobile1'=>'33-25856659 ', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kanchrapara', 'pin'=>'0']);
//        Person::create(['user_name'=>'National Mathura Prasad Jewellers', 'billing_name'=>'M/s National Mathura Prasad Jewellers', 'mobile1'=>'33-25859373', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kancharapara', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Barman Jewellers', 'billing_name'=>'M/s New Barman Jewellers', 'mobile1'=>'9331884549', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kankinara', 'pin'=>'0']);
//        Person::create(['user_name'=>'Gold Palace (Kankinara)', 'billing_name'=>'M/s Gold Palace ', 'mobile1'=>'8961651009', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kankinara', 'pin'=>'0']);
//        Person::create(['user_name'=>'Janaki Jewellers', 'billing_name'=>'M/s Janaki Jewellers', 'mobile1'=>'9433213060', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kankinara', 'pin'=>'0']);
//        Person::create(['user_name'=>'Barman Jewellers', 'billing_name'=>'M/s Barman Jewellers', 'mobile1'=>'9874110602', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kankinara', 'pin'=>'0']);
//        Person::create(['user_name'=>'Roy & Sons Jewellers', 'billing_name'=>'M/s Roy & Sons Jewellers', 'mobile1'=>'9836386318', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyamnagar', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Tara Maa Jewellers', 'billing_name'=>'M/s New Tara Maa Jewellers', 'mobile1'=>'9433191466 , 9051323040', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyamnagar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Debnarayan Dhar and Jewellers', 'billing_name'=>'M/S Debnarayan Dhar and Jewellers', 'mobile1'=>'9434546464, 8389943246, 8', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Katwa', 'pin'=>'0']);
//        Person::create(['user_name'=>'Jewell Garden', 'billing_name'=>'M/s Jewell Garden', 'mobile1'=>'7890279964 , 26371115', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Howrah', 'pin'=>'0']);
//        Person::create(['user_name'=>'Srikrishna Jewellers (Baduria)', 'billing_name'=>'M/s Srikrishna Jewellers', 'mobile1'=>'9903652244', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Baduria', 'pin'=>'0']);
//        Person::create(['user_name'=>'Gourav Jewellers', 'billing_name'=>'M/s Gourav Jewellers', 'mobile1'=>'90883228167', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyamnagar', 'pin'=>'0']);
//        Person::create(['user_name'=>'N. P Jewellers', 'billing_name'=>'M/s N. P Jewellers', 'mobile1'=>'9339568587', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Titagarh', 'pin'=>'0']);
//        Person::create(['user_name'=>'Laxmi Jewellers (Titagarh)', 'billing_name'=>'M/s Laxmi Jewellers ', 'mobile1'=>'9831084080', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Titagarh', 'pin'=>'0']);
//        Person::create(['user_name'=>'Mondol Jewellers', 'billing_name'=>'M/s Mondol Jewellers', 'mobile1'=>'9438503923 , 9153058299', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Arambagh', 'pin'=>'0']);
//        Person::create(['user_name'=>'Pelaram Jewellers', 'billing_name'=>'M/s Pelaram Jewellers', 'mobile1'=>'9476212830 , 9748536947', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bankura ', 'pin'=>'0']);
//        Person::create(['user_name'=>'Uttara Jewellers', 'billing_name'=>'M/s Uttara Jewellers', 'mobile1'=>'9330481556', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barasat', 'pin'=>'700126']);
//        Person::create(['user_name'=>'Dutta Jewellers Pvt. Ltd', 'billing_name'=>'M/s Dutta Jewellers Pvt. Ltd', 'mobile1'=>'9264798157', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kalna', 'pin'=>'0']);
//        Person::create(['user_name'=>'Roy Jewellery Palace', 'billing_name'=>'M/s Roy Jewellery Palace', 'mobile1'=>'25927047 , 9831000171', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Adi Singha Jewellers', 'billing_name'=>'M/s Adi Singha Jewellers', 'mobile1'=>'7003115370', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Dhar Jewellers', 'billing_name'=>'M/s Dhar Jewellers', 'mobile1'=>'22410549', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'0']);
//        Person::create(['user_name'=>'P . C Jewellers (Bashirhut)', 'billing_name'=>'M/s P . C Jewellers ', 'mobile1'=>'9434116298', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bashirhut', 'pin'=>'0']);
//        Person::create(['user_name'=>'Shantisree Gini palace', 'billing_name'=>'M/s Shantisree Gini palace', 'mobile1'=>'9830145619', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Howrah', 'pin'=>'711101']);
//        Person::create(['user_name'=>'Kalimata Jewellers', 'billing_name'=>'M/S Kalimata Jewellers', 'mobile1'=>'9831929403', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyamnagar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Monihar Jewellers', 'billing_name'=>'M/s Monihar Jewellers', 'mobile1'=>'33-23983550 ', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Behala', 'pin'=>'0']);
//        Person::create(['user_name'=>'N. Das & Sons  Jewellers', 'billing_name'=>'M/s N. Das & Sons  Jewellers', 'mobile1'=>'9830503549', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kanchrapara', 'pin'=>'0']);
//        Person::create(['user_name'=>'Promit Jewellers', 'billing_name'=>'M/s Promit Jewellers', 'mobile1'=>'0000000', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Behala', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Modern Dutta Jewellers', 'billing_name'=>'M/s New Modern Dutta Jewellers', 'mobile1'=>'9475020403 , 348-2256544', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Beharampore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Sandhya Gold Jewellers', 'billing_name'=>'M/s Sandhya Gold Jewellers', 'mobile1'=>'33-65010066', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bhawanipur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Nirodh Kumar Das', 'billing_name'=>'M/s Nirodh Kumar Das', 'mobile1'=>'33-22478497 , 9831034024', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bhawanipur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Biswanath Jewellers', 'billing_name'=>'M/s Biswanath Jewellers', 'mobile1'=>'03324338747, 9007773474', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Baruipore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Bachaspati Guinea Bhavan', 'billing_name'=>'M/s Bachaspati Guinea Bhavan', 'mobile1'=>'9239109717,64538623', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Baruipur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Satyam Shivam Sundaram Jewellers', 'billing_name'=>'M/s Satyam Shivam Sundaram Jewellers', 'mobile1'=>'9830105557 , 23542366', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Pyne Brothers Jewellers', 'billing_name'=>'M/s Pyne Brothers Jewellers', 'mobile1'=>'33-2455774', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bhawanipur', 'pin'=>'0']);
//        Person::create(['user_name'=>'G . C Day Jewellery House', 'billing_name'=>'M/s G . C Day Jewellery House', 'mobile1'=>'9831039490', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bhawanipur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Dutta Guinea Palace (Bowbazar)', 'billing_name'=>'M/s Dutta Guinea Palace ', 'mobile1'=>'9831950710', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bowbazar', 'pin'=>'700012']);
//        Person::create(['user_name'=>'Srodhanjoli Jewellers (Chakdaha)', 'billing_name'=>'M/s Srodhanjoli Jewellers ', 'mobile1'=>'9734786705', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Chakdaha', 'pin'=>'0']);
//        Person::create(['user_name'=>'Royco Jewellers', 'billing_name'=>'M/s Royco Jewellers', 'mobile1'=>'9830956569', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Chandannagar', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Podder Jewellers', 'billing_name'=>'M/s New podderJewellers', 'mobile1'=>'9062344050', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'700122']);
//        Person::create(['user_name'=>'New P . Chandra Jewellers', 'billing_name'=>'M/s New P . Chandra Jewellers', 'mobile1'=>'9836786560', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Dumdum ', 'pin'=>'0']);
//        Person::create(['user_name'=>'S. K. Jewellers ', 'billing_name'=>'M/s  S. K. Jewellers ', 'mobile1'=>'34000000', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Krishnanagar', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Gouri Jewellers', 'billing_name'=>'M/s New Gouri Jewellers', 'mobile1'=>'9231642617', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barasat', 'pin'=>'700124']);
//        Person::create(['user_name'=>'Radha Rani Jewellers', 'billing_name'=>'M/s Radha Rani Jewellers', 'mobile1'=>'9875369125', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'700122']);
//        Person::create(['user_name'=>'Fashion Jewellers', 'billing_name'=>'M/s Fashion Jewellers', 'mobile1'=>'25555147', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Dharco Jewellers', 'billing_name'=>'M/s Dharco Jewellers', 'mobile1'=>'9836690573', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Hindmotor', 'pin'=>'0']);
//        Person::create(['user_name'=>'Swarnanjali Jewellers', 'billing_name'=>'M/s Swarnanjali Jewellers', 'mobile1'=>'9051844133 , 24600147', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Gariahut', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Anukul Jewellers', 'billing_name'=>'M/s New Anukul Jewellers', 'mobile1'=>'321-7248397 , 9143118831', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Haroa', 'pin'=>'0']);
//        Person::create(['user_name'=>'Laxmi Narayan Jewellers', 'billing_name'=>'M/s Laxmi Narayan Jewellers', 'mobile1'=>'9874334760', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Rishra', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Radharani Jewellers', 'billing_name'=>'M/s New Radharani Jewellers', 'mobile1'=>'0000000000', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Ichapore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Sandhya Gold Jewellers (Jadavpur)', 'billing_name'=>'M/s Sandhya Gold Jewellers ', 'mobile1'=>'2412-6800 , 65555204', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Jadavpur', 'pin'=>'700032']);
//        Person::create(['user_name'=>'Swarnaniketan Jewellers ', 'billing_name'=>'M/s Swarnaniketan Jewellers', 'mobile1'=>'9038684069', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyamnagar', 'pin'=>'00000']);
//        Person::create(['user_name'=>'Sri Laxmi Narasingha Jewellers', 'billing_name'=>'M/s Sri Laxmi Narasingha Jewellers', 'mobile1'=>'7501926842', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kharagpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Sree Jeweller', 'billing_name'=>'M/s Sree Jeweller', 'mobile1'=>'9333296693', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kharagpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Das Jewellers (Kharagpur)', 'billing_name'=>'M/s Das Jewellers ', 'mobile1'=>'9434205479', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kharagpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Manikanchan Jewellers Pvt. Ltd', 'billing_name'=>'M/s Manikanchan Jewellers Pvt. Ltd', 'mobile1'=>'9830327808', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Gold & Silvar', 'billing_name'=>'M/s Gold & Silvar', 'mobile1'=>'9434008667 , 3222-255699', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kharagpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Hira Jewellers (Rajarhat )', 'billing_name'=>'M/s Hira Jewellers', 'mobile1'=>'000000', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Rajarhat', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Matri Jewellers', 'billing_name'=>'M/s New Matri Jewellers', 'mobile1'=>'0000000000', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyamnagar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Sonar Taree Jewellers', 'billing_name'=>'M/s Sonar Taree Jewellers', 'mobile1'=>'7685091560', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Madhyamgram', 'pin'=>'0']);
//        Person::create(['user_name'=>'Ram Thakur Jewellers', 'billing_name'=>'M/s Ram Thakur Jewellers', 'mobile1'=>'9804506476', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Madhyamgram', 'pin'=>'0']);
//        Person::create(['user_name'=>'Swarnarupa Jewellers', 'billing_name'=>'M/s Swarnarupa Jewellers', 'mobile1'=>'9332195251', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Nabadwip ', 'pin'=>'0']);
//        Person::create(['user_name'=>'Ria Jewellers', 'billing_name'=>'M/s Ria Jewellers', 'mobile1'=>'9830194883', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kolkata', 'pin'=>'Kol-90']);
//        Person::create(['user_name'=>'Bharati Gold Corner', 'billing_name'=>'M/s Bharati Gold Corner', 'mobile1'=>'9830877049', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Ramrajatala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Sohani Jewellers', 'billing_name'=>'M/s Sohani Jewellers', 'mobile1'=>'9167474025', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Prativa Nagar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Jee Narayan Jewellers', 'billing_name'=>'M/s Jee Narayan Jewellers', 'mobile1'=>'9874393860/9007856933', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Howrah', 'pin'=>'711101']);
//        Person::create(['user_name'=>'Rajlaxmi Guinea Mansion Jewellers', 'billing_name'=>'M/s Rajlaxmi Guinea Mansion Jewellers', 'mobile1'=>'25548598', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Kabita Das', 'billing_name'=>'M/s Kabita Das', 'mobile1'=>'9830288631', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Bakshi Jewellers', 'billing_name'=>'M/S Bakshi Jewellers', 'mobile1'=>'8013242585', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barasat', 'pin'=>'700124']);
//        Person::create(['user_name'=>'Subarna Shilpi Jewellers', 'billing_name'=>'M/s Subarna Shilpi Jewellers', 'mobile1'=>'9831796878', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sonarpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Surovi Mansion Jewellers', 'billing_name'=>'M/s Surovi Mansion Jewellers', 'mobile1'=>'2434-9338', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sonarpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'G . C Day Jewellers', 'billing_name'=>'M/s G . C Day Jewellers', 'mobile1'=>'9830021962 , 33-24666871', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Tollygunge', 'pin'=>'0']);
//        Person::create(['user_name'=>'Howrah Jewellers', 'billing_name'=>'M/s Howrah Jewellers', 'mobile1'=>'9830280620 , 33-26411126', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Howrah', 'pin'=>'0']);
//        Person::create(['user_name'=>'Maniratnam Jewellers', 'billing_name'=>'M/s Maniratnam Jewellers', 'mobile1'=>'9830233494', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'0']);
//        Person::create(['user_name'=>'A . M Day Brothers Jewellers', 'billing_name'=>'M/s A . M Day Brothers Jewellers', 'mobile1'=>'25550876', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Bhabani Guine Palace', 'billing_name'=>'M/s Bhabani Guine Palace', 'mobile1'=>'9874222828', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Nimta', 'pin'=>'700049']);
//        Person::create(['user_name'=>'L. B Jewellers', 'billing_name'=>'M/s L. B Jewellers', 'mobile1'=>'9830677454 , 25430715', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'700004']);
//        Person::create(['user_name'=>'Ghosh Jewellers', 'billing_name'=>'M/s Ghosh Jewellers', 'mobile1'=>'9831125042', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Anushka Jewellers (Andul)', 'billing_name'=>'M/s Anushka Jewellers ', 'mobile1'=>'9832148835', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Andul', 'pin'=>'0']);
//        Person::create(['user_name'=>'Anandamoyi Jewellers', 'billing_name'=>'M/s Anandamoi Jewellers', 'mobile1'=>'9830945044', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Howrah', 'pin'=>'Howra-4']);
//        Person::create(['user_name'=>'Narayan Jewellers', 'billing_name'=>'M/s Narayan  Jewellers', 'mobile1'=>'6291134007', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Titagarh', 'pin'=>'700119']);
//        Person::create(['user_name'=>'Sandhya Jewellers', 'billing_name'=>'M/s Sandhya Jewellers', 'mobile1'=>'8910389106', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bhatpara', 'pin'=>'0']);
//        Person::create(['user_name'=>'Joy Anjali Jewellers', 'billing_name'=>'M/s Joy Anjali Jewellers', 'mobile1'=>'9836775642', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyamnagar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Provashon Jewellers', 'billing_name'=>'Provashon Jewellers', 'mobile1'=>'7890730977', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Balli', 'pin'=>'0']);
//        Person::create(['user_name'=>'G.M. Jewellers', 'billing_name'=>'M/s G.M. Jewellers', 'mobile1'=>'9883349348', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bandle', 'pin'=>'712123']);
//        Person::create(['user_name'=>'Panchanan Roy & Co', 'billing_name'=>'M/s Panchanan Roy & Co', 'mobile1'=>'9874718657', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sheorahphully', 'pin'=>'0']);
//        Person::create(['user_name'=>'Poddar Jewellers (Barrackpore)', 'billing_name'=>'M/s Poddar Jewellers ', 'mobile1'=>'9230833905', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'700122']);
//        Person::create(['user_name'=>'Subham Kundu', 'billing_name'=>'M/s Subham Kundu', 'mobile1'=>'7278636343', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Namita Jewellery House', 'billing_name'=>'M/s Namita Jewellery House', 'mobile1'=>'9733501217', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Champahati', 'pin'=>'0']);
//        Person::create(['user_name'=>'Radha Krishna Kewellers', 'billing_name'=>'M/s Radha Krishna Kewellers', 'mobile1'=>'9062646177', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Titagarh', 'pin'=>'0']);
//        Person::create(['user_name'=>'Srikrishna Jewellers (Kankinara)', 'billing_name'=>'M/s Srikrishna Jewellers ', 'mobile1'=>'9331216859', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kankinara', 'pin'=>'0']);
//        Person::create(['user_name'=>'Srikrishna Jewellery House', 'billing_name'=>'M/s Srikrishna Jewellery House', 'mobile1'=>'9831212600', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Basanti Jewellery Mansion', 'billing_name'=>'M/s Basanti Jewellery Mansion', 'mobile1'=>'9433234869', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Singur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Parul Jewellers (Singur)', 'billing_name'=>'M/s Parul Jewellers ', 'mobile1'=>'9062402308', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Singur', 'pin'=>'0']);
//        Person::create(['user_name'=>'M . N Jewellers', 'billing_name'=>'M/s M . N Jewellers', 'mobile1'=>'9231889012', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Rishra', 'pin'=>'0']);
//        Person::create(['user_name'=>'Rajlaxmi Guinea Gold', 'billing_name'=>'M/s Rajlaxmi Guinea Gold', 'mobile1'=>'9836135948 , 9804531322', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Behala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Rajlaxmi Swarnalay (Kishore Da)', 'billing_name'=>'M/s Rajlaxmi Swarnalay', 'mobile1'=>'9836311506', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Behala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Srikrishna Jewellers (Sarisha)', 'billing_name'=>'M/S Srikrishna Jewellers', 'mobile1'=>'9836057996', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sarisha', 'pin'=>'0000']);
//        Person::create(['user_name'=>'New Nandi Keswer Jewellers', 'billing_name'=>'M/S New Nandi Keswer Jewellers', 'mobile1'=>'00000', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Champahati', 'pin'=>'']);
//        Person::create(['user_name'=>'New Manikanchan Jewellers', 'billing_name'=>'M/s New Manikanchan Jewellers', 'mobile1'=>'65250298', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Ajanta Jewellers', 'billing_name'=>'M/S Ajanta Jewellers', 'mobile1'=>'9231962494/2501-2164', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Titagarh', 'pin'=>'700119']);
//        Person::create(['user_name'=>'B N Paul James and Jewellers', 'billing_name'=>'M/S B N Paul James & Jewellers ', 'mobile1'=>'7407023758/9732248858', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Katwa', 'pin'=>'0']);
//        Person::create(['user_name'=>'Maa Manasha Jewellers', 'billing_name'=>' Maa Manasha Jewellers', 'mobile1'=>'9674979284/6290959585', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Madhyamgram', 'pin'=>'700129']);
//        Person::create(['user_name'=>'Manik Ch Pyne', 'billing_name'=>'Manik Ch Pyne', 'mobile1'=>'0000000000', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Ramkrishna Jewellers', 'billing_name'=>'Ramkrishna Jewellers', 'mobile1'=>'033-2563-2164', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sodepur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Chandra Palace Jewellers', 'billing_name'=>'Chandra Palace Jewellers', 'mobile1'=>'9832127232  , 9832260840', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Aasnsol', 'pin'=>'0']);
//        Person::create(['user_name'=>'Avishek Jewellers', 'billing_name'=>'AVISHEK JEWELLERS', 'mobile1'=>'9832110994, 9832854859', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Durgapur', 'pin'=>'000000']);
//        Person::create(['user_name'=>'Jai Hind Jewellers', 'billing_name'=>'Jai hind jewellers', 'mobile1'=>'9933057277', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Burnpur', 'pin'=>'713325']);
//        Person::create(['user_name'=>'Purushottam Alankar', 'billing_name'=>'M/s Purushottam Alankar', 'mobile1'=>'9088666888', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'700121']);
//        Person::create(['user_name'=>'Jewell Garden(asansol)', 'billing_name'=>'Jewell Garden', 'mobile1'=>'9547067569', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Asansol', 'pin'=>'0000000000']);
//        Person::create(['user_name'=>'Kalyan Jewellers', 'billing_name'=>'M/s Kalyan Jewellers', 'mobile1'=>'9734536835 , 3214266004', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bagnan', 'pin'=>'0']);
//        Person::create(['user_name'=>'Mathura Prasad Jewellers', 'billing_name'=>'M/s Mathura Prasad Jewellers', 'mobile1'=>'9331980828 033 2585 2221', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kanchrapara', 'pin'=>'0000000000']);
//        Person::create(['user_name'=>'Subham Jewellery House', 'billing_name'=>'Subham Jewellery House', 'mobile1'=>'9830220540       033 2632', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Hooghly', 'pin'=>'712223']);
//        Person::create(['user_name'=>'M.k.jewellers', 'billing_name'=>'M.K.JEWELLERS', 'mobile1'=>'033 2664-0856', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Hooghly', 'pin'=>'000000']);
//        Person::create(['user_name'=>'S.r Jewellers(bangaon)', 'billing_name'=>'S.r Jewellers', 'mobile1'=>'7076836806/03215-259415', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bangaon', 'pin'=>'0']);
//        Person::create(['user_name'=>'G.d.jewellers', 'billing_name'=>'G.D.JEWELLERS', 'mobile1'=>'8910717164   9830120829', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bhawanipur', 'pin'=>'0000000']);
//        Person::create(['user_name'=>'S. N .Gold', 'billing_name'=>'S. N .Gold', 'mobile1'=>'9831037544', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Goriahut', 'pin'=>'0']);
//        Person::create(['user_name'=>'Debnath Silpa Mandir Jewellers', 'billing_name'=>'M/s Debnath Silpa Mandir Jewellers', 'mobile1'=>'9007126422 , 9748212143', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sonarpur', 'pin'=>'700150']);
//        Person::create(['user_name'=>'Laxmi Jewellers(tollygung)', 'billing_name'=>'M/s Laxmi Jewellers', 'mobile1'=>'33-24668150', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Tollygung', 'pin'=>'0']);
//        Person::create(['user_name'=>'Roy Jewellery Mansion', 'billing_name'=>'Roy Jewellery Mansion', 'mobile1'=>'9830246470', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Shyambazar', 'pin'=>'700004']);
//        Person::create(['user_name'=>'Bakshi & Company Jeweller', 'billing_name'=>'Bakshi & Company Jeweller', 'mobile1'=>'033 2544-4922           8', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kolkata', 'pin'=>'700057']);
//        Person::create(['user_name'=>'Laxmi Jewellers', 'billing_name'=>'M/s Laxmi Jewellers', 'mobile1'=>'9933031271', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bagnan', 'pin'=>'0']);
//        Person::create(['user_name'=>'Jatindranath Dutta Jewellers Pvt.ltd', 'billing_name'=>'JATINDRANATH DUTTA JEWELLERS PVT.LTD', 'mobile1'=>'9831071349', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bakhrahat', 'pin'=>'743377']);
//        Person::create(['user_name'=>'Milan Ghosh', 'billing_name'=>'M/S Milan Ghosh', 'mobile1'=>'9681817840', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'700121']);
//        Person::create(['user_name'=>'Anupam Rakshit', 'billing_name'=>'Anupam Rakshit', 'mobile1'=>'7278834919', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'700121']);
//        Person::create(['user_name'=>'Arati Jewellers(barisha)', 'billing_name'=>'Arati Jewellers(Barisha)', 'mobile1'=>'7980760667   9230401366', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kolkata', 'pin'=>'700008']);
//        Person::create(['user_name'=>'V.k.jewellers(Krishnapur)', 'billing_name'=>'V.K. JEWELLERS', 'mobile1'=>'8335023425', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kolkata', 'pin'=>'700101']);
//        Person::create(['user_name'=>'Raj Ratan Jewellers', 'billing_name'=>'Raj Ratan Jewellers', 'mobile1'=>'9434804153', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Durgapur', 'pin'=>'Durgapur-13']);
//        Person::create(['user_name'=>'New Rupam Jewellers', 'billing_name'=>'New Rupam Jewellers', 'mobile1'=>'9733058200', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Egra', 'pin'=>'721429']);
//        Person::create(['user_name'=>'Bile Da', 'billing_name'=>'Mr. Bile Da', 'mobile1'=>'033-2535-2222', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'700121']);
//        Person::create(['user_name'=>'Poddar Ornaments', 'billing_name'=>'M/s Poddar Ornaments', 'mobile1'=>'9734761332', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Durgapore', 'pin'=>'713213']);
//        Person::create(['user_name'=>'Usha Jewellers', 'billing_name'=>'M/s Usha Jewellers', 'mobile1'=>'7002237269,7002955455', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Assam', 'pin'=>'785675']);
//        Person::create(['user_name'=>'Maa Annapurna Jewellers', 'billing_name'=>'M/s Maa Annapurna Jewellers', 'mobile1'=>'9232560246', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Bagnan', 'pin'=>'0']);
//        Person::create(['user_name'=>'Raja Jewellers', 'billing_name'=>'Raja Jewellers', 'mobile1'=>'7003363376', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'North 24 Pgs', 'pin'=>'0000']);
//        Person::create(['user_name'=>'R.chandra & Sons', 'billing_name'=>'R.chandra & Sons', 'mobile1'=>'9681438283', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kancharapara', 'pin'=>'0000']);
//        Person::create(['user_name'=>'Susanta Jewellers', 'billing_name'=>'Susanta Jewellers', 'mobile1'=>'8017504202', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Belgharia', 'pin'=>'0000']);
//        Person::create(['user_name'=>'Sayan Jewellers', 'billing_name'=>'Sayan Jewellers', 'mobile1'=>'9143678985', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kancharapara', 'pin'=>'000000']);
//        Person::create(['user_name'=>'Protussa Jewellers', 'billing_name'=>'Protussa Jewellers', 'mobile1'=>'9007148480 , 7687909401', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Howrah', 'pin'=>'4']);
//        Person::create(['user_name'=>'Anup Paul (Barasat)', 'billing_name'=>'Anup Paul (Barasat)', 'mobile1'=>'7439863638', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barasat', 'pin'=>'0000000000']);
//        Person::create(['user_name'=>'Ankan Jewellers', 'billing_name'=>'Ankan Jewellers', 'mobile1'=>'9748165712', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Konnogar', 'pin'=>'0000']);
//        Person::create(['user_name'=>'Rco G-o-l-d Jewellers', 'billing_name'=>'Rco G-o-l-d Jewellers', 'mobile1'=>'9874841883 , 25734030', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Rajarhat', 'pin'=>'700135']);
//        Person::create(['user_name'=>'Matri Jewellery Palace', 'billing_name'=>'Matri Jewellery Palace', 'mobile1'=>'9831430374', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kolkat', 'pin'=>'700010']);
//        Person::create(['user_name'=>'Dacca Jewellers Pvt. Ltd.', 'billing_name'=>'M/s Dacca Jewellers Pvt. Ltd.', 'mobile1'=>'9836999588,03326521315', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sirumpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Banik Jewellers', 'billing_name'=>'M/s Banik Jewellers', 'mobile1'=>'9433436880', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Badyabati', 'pin'=>'0']);
//        Person::create(['user_name'=>'Mr Vivekananda Ghosh', 'billing_name'=>'M/s Mr Vivekananda Ghosh', 'mobile1'=>'9836444999', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'700121']);
//        Person::create(['user_name'=>'New Sree Dhar Jewellers', 'billing_name'=>'M/s New Sree Dhar Jewellers', 'mobile1'=>'9674439870', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Behala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Rajlaxmi Shilpalaya Jewellers', 'billing_name'=>'M/s Rajlaxmi Shilpalaya Jewellers', 'mobile1'=>'23979197', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Behala', 'pin'=>'0']);
//        Person::create(['user_name'=>'G. Rakshit Jewellers & Sons', 'billing_name'=>'M/s G. Rakshit Jewellers & Sons', 'mobile1'=>'26700180/9830382790', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Domjur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Parashmani Jewellers', 'billing_name'=>'M/s Parashmani Jewellers', 'mobile1'=>'9432181461 , 23986787', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Behala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Tirupati Gold House', 'billing_name'=>'M/s Tirupati Gold House', 'mobile1'=>'23491168 , 24071168', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Behala', 'pin'=>'0']);
//        Person::create(['user_name'=>'P . C Dutta Jewellers Pvt. Ltd', 'billing_name'=>'M/s P . C Dutta Jewellers Pvt. Ltd', 'mobile1'=>'9874278020 , 23965050', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Behala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Rajlaxmi Swarnamahal Jewellers', 'billing_name'=>'M/s Rajlaxmi Swarnamahal Jewellers', 'mobile1'=>'9830177726,8017299322', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Behala', 'pin'=>'0']);
//        Person::create(['user_name'=>'M.R. Jewellers', 'billing_name'=>'M/s M.R. Jewellers', 'mobile1'=>'9830156731/9830156731', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Rajarhut', 'pin'=>'0']);
//        Person::create(['user_name'=>'M. Dutta & Sons', 'billing_name'=>'M/s M. Dutta & Sons', 'mobile1'=>'9830908166,24709213', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Amtala', 'pin'=>'0']);
//        Person::create(['user_name'=>'A . M Jewellers', 'billing_name'=>'M/s A . M Jewellers', 'mobile1'=>'26434323', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Howrah', 'pin'=>'0']);
//        Person::create(['user_name'=>'Swarna Kuthir Jewellers', 'billing_name'=>'M/s Swarna Kuthir Jewellers', 'mobile1'=>'8981740798', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Konnogor', 'pin'=>'0']);
//        Person::create(['user_name'=>'R . C Jewellers', 'billing_name'=>'M/s R . C Jewellers', 'mobile1'=>'9433488104 , 9681253071', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Konnogor', 'pin'=>'0']);
//        Person::create(['user_name'=>'Gold Palace', 'billing_name'=>'M/s Gold Palace', 'mobile1'=>'8420099889', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Konnogor', 'pin'=>'0']);
//        Person::create(['user_name'=>'New R . A Jewellery House', 'billing_name'=>'M/s New R . A Jewellery House', 'mobile1'=>'9038513522 , 9836004590', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Rajarhut', 'pin'=>'700135']);
//        Person::create(['user_name'=>'Shaikh Co Jewellers', 'billing_name'=>'M/s Shaikh Co Jewellers', 'mobile1'=>'9674127989', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Rajarhut', 'pin'=>'0']);
//        Person::create(['user_name'=>'Das Jewellers(dipak Da)', 'billing_name'=>'M/s Das Jewellers', 'mobile1'=>'9830892030', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Ramrajatala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Das Jewellers (Suman Da)', 'billing_name'=>'M/s Das Jewellers ', 'mobile1'=>'9830417341', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Ramrajatala', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Samanta Jewellers', 'billing_name'=>'M/s New Samanta Jewellers', 'mobile1'=>'9836621060', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Ramrajatala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Kalyaneswari Jewellers', 'billing_name'=>'M/s Kalyaneswari Jewellers', 'mobile1'=>'9830312516 , 26573796', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Ramrajatala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Jatindra Nath Dutta Jewellers', 'billing_name'=>'M/s Jatindra Nath Dutta Jewellers', 'mobile1'=>'24709212', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Amtala', 'pin'=>'0']);
//        Person::create(['user_name'=>'M . D Nath & Others Jewellers', 'billing_name'=>'M/s M . D Nath & Others Jewellers', 'mobile1'=>'3326272739 ', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Ramrajatala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Anushka Jewellers', 'billing_name'=>'M/s Anushka Jewellers', 'mobile1'=>'9804151712', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Ramrajatala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Bera Jewellery Palace', 'billing_name'=>'M/s Bera Jewellery Palace', 'mobile1'=>'9051998543 , 26270719', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Ramrajatala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Tilottama Guinea Palace', 'billing_name'=>'M/s Tilottama Guinea Palace', 'mobile1'=>'9836770526', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Ramrajatala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Laxmi Gold', 'billing_name'=>'M/s Laxmi Gold', 'mobile1'=>'8902272318', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Rishra', 'pin'=>'0']);
//        Person::create(['user_name'=>'Gahana', 'billing_name'=>'M/s Gahana', 'mobile1'=>'9830327384/9831614867', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Domjur', 'pin'=>'00000']);
//        Person::create(['user_name'=>'Shyamashree Jewellers', 'billing_name'=>'M/s Shyamashree Jewellers', 'mobile1'=>'8276003092', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sheoraphully', 'pin'=>'0']);
//        Person::create(['user_name'=>'Srodhanjoli Jewellers', 'billing_name'=>'M/s Srodhanjoli Jewellers', 'mobile1'=>'9831678090 , 9734786705', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Baidyabati', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Gold Queen Jewellers', 'billing_name'=>'M/s New Gold Queen Jewellers', 'mobile1'=>'9143048365 , 26624524', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sirumpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'New B . M Jewellers', 'billing_name'=>'M/s New B . M Jewellers', 'mobile1'=>'9433290413', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sirumpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Binapani Jewellers', 'billing_name'=>'M/s Binapani Jewellers', 'mobile1'=>'9830799395', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Amtala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Nihar Jewellers', 'billing_name'=>'M/s Nihar Jewellers', 'mobile1'=>'03324608786,9903214752', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Kolkata', 'pin'=>'0']);
//        Person::create(['user_name'=>'Rajlakhsmi Jewellery House', 'billing_name'=>'M/s Rajlakhsmi Jewellery House', 'mobile1'=>'0', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Dum Dum', 'pin'=>'0']);
//        Person::create(['user_name'=>'The M . N  Jewellers', 'billing_name'=>'M/s New M . N  Jewellers', 'mobile1'=>'7044171504', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sirumpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Fancy Jewellers', 'billing_name'=>'M/s Fancy Jewellers', 'mobile1'=>'9830070360', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sirumpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'The New Gold Queen ', 'billing_name'=>'M/s The New Gold Queen ', 'mobile1'=>'8902250538', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Uttarpara', 'pin'=>'0']);
//        Person::create(['user_name'=>'Ginico Jewellers', 'billing_name'=>'M/s Ginico Jewellers', 'mobile1'=>'8420741463', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Alambazar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Das Jewellers', 'billing_name'=>'M/s Das Jewellers', 'mobile1'=>'9831526285', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Alambazar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Promila Jewellers', 'billing_name'=>'M/s Promila Jewellers', 'mobile1'=>'9830215916', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Baruipur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Poddar Jewellers', 'billing_name'=>'M/s Poddar Jewellers', 'mobile1'=>'9433096790 , 24338615', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Baruipur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Lila Bachuspati Jewellers', 'billing_name'=>'M/s Lila Bachaspati Jewellers', 'mobile1'=>'24330710', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Baruipur', 'pin'=>'0']);
//        Person::create(['user_name'=>'A. K Dutta & Sons', 'billing_name'=>'M/s A. K Dutta & Sons', 'mobile1'=>'24809686,9831071349', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Amtala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Dutta Jewellers', 'billing_name'=>'M/s Dutta Jewellers', 'mobile1'=>'9830343668 ,  24331638', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Baruipur', 'pin'=>'0']);
//        Person::create(['user_name'=>'The Promila Guinea Mansion ', 'billing_name'=>'M/s The Promila Guinea Mansion ', 'mobile1'=>'9836468719 , 9051083911', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Baruipur', 'pin'=>'0']);
//        Person::create(['user_name'=>'D . K Jewellers', 'billing_name'=>'M/s D . K Jewellers', 'mobile1'=>'25635878 , 9874242788', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Belgharia', 'pin'=>'0']);
//        Person::create(['user_name'=>'Maa Shitala Jewellers', 'billing_name'=>'M/s Maa Shitala Jewellers', 'mobile1'=>'9051918010/7044762099', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Mahesh', 'pin'=>'0']);
//        Person::create(['user_name'=>'New Rajlakhsmi Jewellers', 'billing_name'=>'M/s New Rajlakhsmi Jewellers', 'mobile1'=>'9231661547, 8617278400', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Barrackpore', 'pin'=>'Kol - 126']);
//        Person::create(['user_name'=>'The Modern Guinea Palce', 'billing_name'=>'M/s The Modern Guinea Palce', 'mobile1'=>'9830482307', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Belgharia', 'pin'=>'0']);
//        Person::create(['user_name'=>'Modern Jewellers', 'billing_name'=>'M/s Modern Jewellers', 'mobile1'=>'9830196456', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Belgharia', 'pin'=>'0']);
//        Person::create(['user_name'=>'Bijoy Bachaspati Jewellers', 'billing_name'=>'M/s Bijoy Bachaspati Jewellers', 'mobile1'=>'9883343333', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Champahati', 'pin'=>'0']);
//        Person::create(['user_name'=>'Raj Lakshmi Jewellers', 'billing_name'=>'M/s Raj Lakshmi Jewellers', 'mobile1'=>'0320255356,256471', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Contai', 'pin'=>'0']);
//        Person::create(['user_name'=>'Rupam Jewellers', 'billing_name'=>'M/s Rupam Jewellers', 'mobile1'=>'9002520861,255498', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Contai', 'pin'=>'0']);
//        Person::create(['user_name'=>'Srikrishna Jewellers', 'billing_name'=>'M/s Srikrishna Jewellers', 'mobile1'=>'9874693591', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Amtala', 'pin'=>'0']);
//        Person::create(['user_name'=>'Gold House', 'billing_name'=>'M/s Gold House', 'mobile1'=>'8820883267', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Contai', 'pin'=>'0']);
//        Person::create(['user_name'=>'Sarada Jewellers', 'billing_name'=>'M/s Sarada Jewellers', 'mobile1'=>'9433171725', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Dumdum', 'pin'=>'0']);
//        Person::create(['user_name'=>'H . Roy Jewellers', 'billing_name'=>'M/s H . Roy Jewellers', 'mobile1'=>'8017370467', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Dumdum', 'pin'=>'0']);
//        Person::create(['user_name'=>'Dhanalaxmi Jewellers', 'billing_name'=>'M/s Dhanalaxmi Jewellers', 'mobile1'=>'033-25568616', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Dumdum', 'pin'=>'0']);
//        Person::create(['user_name'=>'B.c Jewellers', 'billing_name'=>'M/s B.c Jewellers', 'mobile1'=>'9433359688', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Dumdum', 'pin'=>'0']);
//        Person::create(['user_name'=>'Subha Raj Jewellers', 'billing_name'=>'M/s Subha Raj Jewellers', 'mobile1'=>'9830426823,033-25606130', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Dumdum', 'pin'=>'0']);
//        Person::create(['user_name'=>'Rupashree Jewellers', 'billing_name'=>'M/s Rupashree Jewellers', 'mobile1'=>'9830606544 , 25607220', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Dumdum', 'pin'=>'0']);
//        Person::create(['user_name'=>'Parul Jewellers', 'billing_name'=>'M/s Parul Jewellers', 'mobile1'=>'9804150808', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Dumdum', 'pin'=>'0']);
//        Person::create(['user_name'=>'Laxmi Jeweller & Sons', 'billing_name'=>'M/s Laxmi Jeweller & Sons', 'mobile1'=>'26625717/8017627217', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Sreerampore', 'pin'=>'0']);
//        Person::create(['user_name'=>'Sri Gopal Jewellers', 'billing_name'=>'M/s Sri Gopal Jewellers', 'mobile1'=>'9233820046', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Durgachawk', 'pin'=>'0']);
//        Person::create(['user_name'=>'Gini Mansion Jewellers', 'billing_name'=>'M/s Gini Mansion Jewellers', 'mobile1'=>'9831792487', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Baruipur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Taniya Jewellers', 'billing_name'=>'M/s Taniya Jewellers', 'mobile1'=>'9830720850/9230530850', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Dumdum', 'pin'=>'Kol-50']);
//        Person::create(['user_name'=>'Modern Jewellers(durgachawk)', 'billing_name'=>'M/s Modern Jewellers', 'mobile1'=>'24274027 ', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Durgachawk', 'pin'=>'0']);
//        Person::create(['user_name'=>'K .C Jewellery Museum', 'billing_name'=>'M/s K .C Jewellery Museum', 'mobile1'=>'9839696302', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Durganagar', 'pin'=>'0']);
//        Person::create(['user_name'=>'Mundra Jewellers', 'billing_name'=>'M/s Mundra Jewellers', 'mobile1'=>'9800016767', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Gangarampur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Rekha Jewellers', 'billing_name'=>'M/s Rekha Jewellers', 'mobile1'=>'9051487670', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Belgharia', 'pin'=>'0']);
//        Person::create(['user_name'=>'Vadilal Maganlal', 'billing_name'=>'M/s Vadilal Maganlal', 'mobile1'=>'0657-2320140 , 2321808', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Jamshedpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Arvind Vadilal', 'billing_name'=>'M/s Arvind Vadilal', 'mobile1'=>'0657-2321721 , 8235661334', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Jamshedpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Natwarlal Sukhlal & Bros', 'billing_name'=>'M/s Natwarlal Sukhlal & Bros', 'mobile1'=>'0657-2249225 , 2249292 , ', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Jamshedpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'Keshavji Chhaganlal Jewellers Pvt. Ltd', 'billing_name'=>'M/s Keshavji Chhaganlal Jewellers Pvt. Ltd', 'mobile1'=>'0657-2320834 , 6441105', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Jamshedpur', 'pin'=>'0']);
//        Person::create(['user_name'=>'V . K Jewellers', 'billing_name'=>'M/s V . K Jewellers', 'mobile1'=>'9830803735', 'mobile2'=>'', 'user_type_id'=>10, 'customer_category_id'=>1, 'city'=>'Dumdum', 'pin'=>'0']);




        User::create(['person_id'=>'1','email'=>'bile','password'=>"81dc9bdb52d04dc20036dbd8313ed055"]);
        User::create(['person_id'=>'3','email'=>'papai','password'=>"81dc9bdb52d04dc20036dbd8313ed055"]);
//        User::create(['person_id'=>'3','email'=>'papai','password'=>"81dc9bdb52d04dc20036dbd8313ed055"]);
//        User::create(['person_id'=>'4','email'=>'guddu','password'=>"81dc9bdb52d04dc20036dbd8313ed055"]);
//        User::create(['person_id'=>'5','email'=>'sameeran','password'=>"81dc9bdb52d04dc20036dbd8313ed055"]);
//        User::create(['person_id'=>'7','email'=>'pritam','password'=>"81dc9bdb52d04dc20036dbd8313ed055"]);
//        User::create(['person_id'=>'8','email'=>'riya','password'=>"81dc9bdb52d04dc20036dbd8313ed055"]);
//        User::create(['person_id'=>'9','email'=>'priyam','password'=>"81dc9bdb52d04dc20036dbd8313ed055"]);
//        User::create(['person_id'=>'10','email'=>'biju','password'=>"81dc9bdb52d04dc20036dbd8313ed055"]);
//        User::create(['person_id'=>'11','email'=>'Test','password'=>"81dc9bdb52d04dc20036dbd8313ed055"]);


//        php artisan db:seed --class=ProductSeeder
    }
}
