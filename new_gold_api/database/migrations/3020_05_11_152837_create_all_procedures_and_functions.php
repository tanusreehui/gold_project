<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAllProceduresAndFunctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


       DB::unprepared('DROP FUNCTION IF EXISTS get_gold_due_by_customer_id_by_agent_id_for_customer;
            CREATE FUNCTION gold_db.`get_gold_due_by_customer_id_by_agent_id_for_customer`(`param_customer_id` INT, `param_agent_id` INT) RETURNS double
                DETERMINISTIC
            BEGIN
                              DECLARE temp_total_billed_gold double;
                              DECLARE temp_opening_balance_Gold double;
                              DECLARE temp_total_gold_received double;
                              DECLARE temp_total_gold_due double;


                                 select get_opening_balance_gold_by_customer_id(param_customer_id) into temp_opening_balance_Gold;

                                 select sum(get_billed_gold_by_bill_master_id(id)) into temp_total_billed_gold from bill_masters
                                 where bill_masters.agent_id = param_agent_id and bill_masters.customer_id = param_customer_id ;

                                 select get_total_gold_payment_by_customer_id(param_customer_id) into temp_total_gold_received;

                                 select  temp_opening_balance_Gold + temp_total_billed_gold - temp_total_gold_received into temp_total_gold_due;

                              IF temp_total_gold_due IS NULL THEN
                                  RETURN 0;
                              END IF;
                              RETURN temp_total_gold_due;
                        END;
            ');

        DB::unprepared('DROP FUNCTION IF EXISTS get_LC_due_by_customer_id_and_by_agent_id_for_customer;
            CREATE FUNCTION gold_db.`get_LC_due_by_customer_id_and_by_agent_id_for_customer`(`param_customer_id` INT, `param_agent_id` INT) RETURNS double
                DETERMINISTIC
            BEGIN
                                  DECLARE temp_total_billed_LC double;
                                  DECLARE temp_opening_balance_LC double;
                                  DECLARE temp_total_payment double;
                                  DECLARE temp_total_LC_due double;
                                     select get_opening_balance_LC_by_customer_id(param_customer_id) into temp_opening_balance_LC;

                                     select sum(get_billed_LC_by_bill_master_id(id)) into temp_total_billed_LC from bill_masters
                                     where bill_masters.agent_id = param_agent_id and bill_masters.customer_id = param_customer_id ;

                                     select get_total_LC_payment_by_customer_id(param_customer_id) into temp_total_payment;

                                     select  temp_opening_balance_LC + temp_total_billed_LC - temp_total_payment into temp_total_LC_due;

                                  IF temp_total_LC_due IS NULL THEN
                                      RETURN 0;
                                  END IF;
                                  RETURN temp_total_LC_due;
                               END;
            ');

       // OLD FUNCTION
//            DB::unprepared('DROP FUNCTION IF EXISTS get_gold_quantity;
//                CREATE FUNCTION `get_gold_quantity`(`param_job_master_id` INT) RETURNS double
//                    DETERMINISTIC
//                BEGIN
//                  DECLARE temp_gold_send double;
//                  DECLARE temp_gold_ret double;
//                  DECLARE temp_pan_send double;
//                  DECLARE temp_pan_ret double;
//                  DECLARE temp_nitric_ret double;
//                  DECLARE temp_ploss_info double;
//                  DECLARE temp_gold_quantity double;
//
//                  select ifNull(sum(material_quantity),0) into temp_gold_send   from job_details where job_master_id=param_job_master_id and job_task_id =1 ;
//
//                  select ifNull(sum(material_quantity),0) into temp_gold_ret   from job_details where job_master_id=param_job_master_id and job_task_id =2;
//
//                  select ifNull(sum(material_quantity),0) into temp_pan_send   from job_details where job_master_id=param_job_master_id and job_task_id =5;
//
//                  select ifNull(sum(material_quantity),0) into temp_pan_ret   from job_details where job_master_id=param_job_master_id and job_task_id =6;
//
//                  select ifNull(sum(material_quantity),0) into temp_nitric_ret   from job_details where job_master_id=param_job_master_id and job_task_id =7;
//
//                  select (order_details.p_loss*order_details.quantity ) into temp_ploss_info from job_masters
//                  inner join order_details ON order_details.id = job_masters.order_details_id
//                  where job_masters.id=param_job_master_id;
//
//                  select temp_gold_send + temp_gold_ret  + temp_pan_send + temp_pan_ret + temp_nitric_ret + temp_ploss_info into temp_gold_quantity ;
//
//                IF temp_gold_quantity IS NULL THEN
//                    RETURN 0;
//                END IF;
//                RETURN temp_gold_quantity;
//                END;'
//            );

        //UPDATED FUNCTION
//        DB::unprepared('DROP FUNCTION IF EXISTS gold_db.get_gold_quantity;
//            CREATE FUNCTION gold_db.`get_gold_quantity`(`param_job_master_id` INT) RETURNS double
//                DETERMINISTIC
//            BEGIN
//                  DECLARE temp_gold_send double;
//                  DECLARE temp_gold_ret double;
//                  DECLARE temp_pan_send double;
//                  DECLARE temp_pan_ret double;
//                  DECLARE total_pan double;
//                  DECLARE temp_nitric_ret double;
//                  DECLARE temp_ploss_info double;
//                  DECLARE temp_gold_quantity double;
//                  DECLARE temp_billAdjustment_nitric double;
//
//                  select bill_adjustments.value into temp_billAdjustment_nitric FROM bill_adjustments where id=2;
//
//                  select ifNull(sum(material_quantity),0) into temp_gold_send   from job_details where job_master_id=param_job_master_id and job_task_id =1 ;
//
//                  select ifNull(sum(material_quantity),0) into temp_gold_ret   from job_details where job_master_id=param_job_master_id and job_task_id =2;
//
//                  select ifNull(sum(material_quantity),0) into temp_pan_send   from job_details where job_master_id=param_job_master_id and job_task_id =5;
//
//                  select ifNull(sum(material_quantity),0) into temp_pan_ret   from job_details where job_master_id=param_job_master_id and job_task_id =6;
//
//                  select ifNull((sum(material_quantity)*temp_billAdjustment_nitric)/100,0) into temp_nitric_ret from job_details where job_master_id=param_job_master_id and job_task_id =7;
//
//                  select (order_details.p_loss*order_details.quantity) into temp_ploss_info from job_masters
//                  inner join order_details ON order_details.id = job_masters.order_details_id
//                  where job_masters.id=param_job_master_id;
//
//
//                  select (people.mv * order_details.quantity) into temp_total_mv from  job_masters
//                  inner join order_details ON order_details.id = job_masters.order_details_id
//                  inner join order_masters ON order_masters.id = order_details.order_master_id
//                  inner join people ON people.id = order_masters.person_id
//                  where job_masters.id = param_job_master_id;
//
//
//                  select (((temp_pan_send + temp_pan_ret)*bill_adjustments.value)/100) into total_pan FROM bill_adjustments where id=1;
//
//                  select temp_gold_send + temp_gold_ret  + total_pan + temp_nitric_ret + temp_ploss_info + temp_total_mv into temp_gold_quantity ;
//
//                IF temp_gold_quantity IS NULL THEN
//                    RETURN 0;
//                END IF;
//                RETURN temp_gold_quantity;
//                END;'
//        );

//
//            DB::unprepared('DROP PROCEDURE IF EXISTS gold_db.getStockWithTag;
//                    CREATE PROCEDURE gold_db.`getStockWithTag`()
//                    BEGIN
//
//
//
//                    select stocks.id,stocks.gold, stocks.agent_id , stocks.amount, stocks.in_stock,stocks.quantity, stocks.gross_weight,stocks.material_id,products.model_number,stocks.job_master_id,order_details.size,people.id as person_id,
//                    concat( conv(SUBSTRING(tag, 5,5),10,16),'-' ,
//                    conv(SUBSTRING_INDEX(SUBSTRING_INDEX(tag,'-',-2), '-',1),10,16),'-',
//                    SUBSTRING_INDEX(tag,'-',-1)) as tag
//                    from stocks
//                    inner join job_masters ON job_masters.id = stocks.job_master_id
//                    inner join order_details ON order_details.id = job_masters.order_details_id
//                    inner join order_masters ON order_masters.id = order_details.order_master_id
//                    inner join people ON people.id = order_masters.person_id
//                    inner join products ON products.id = order_details.product_id;
//
//                    END;'
//            );




        //new updated function------------
        DB::unprepared('DROP FUNCTION IF EXISTS get_gold_quantity;
                CREATE FUNCTION `get_gold_quantity`(`param_job_master_id` INT) RETURNS double
                    DETERMINISTIC
         BEGIN
                  DECLARE temp_gold_send double;
                  DECLARE temp_gold_ret double;
                  DECLARE temp_pan_send double;
                  DECLARE temp_pan_ret double;
                  DECLARE total_pan double;
                  DECLARE temp_nitric_ret double;
                  DECLARE temp_ploss_info double;
                  DECLARE temp_gold_quantity double;
                  DECLARE temp_billAdjustment_nitric double;
                  DECLARE temp_total_mv double;

                  select bill_adjustments.value into temp_billAdjustment_nitric FROM bill_adjustments where id=2;

                  select ifNull(sum(material_quantity),0) into temp_gold_send   from job_details where job_master_id=param_job_master_id and job_task_id =1 ;

                  select ifNull(sum(material_quantity),0) into temp_gold_ret   from job_details where job_master_id=param_job_master_id and job_task_id =2;

                  select ifNull(sum(material_quantity),0) into temp_pan_send   from job_details where job_master_id=param_job_master_id and job_task_id =5;

                  select ifNull(sum(material_quantity),0) into temp_pan_ret   from job_details where job_master_id=param_job_master_id and job_task_id =6;

                  select ifNull((sum(material_quantity)*temp_billAdjustment_nitric)/100,0) into temp_nitric_ret from job_details where job_master_id=param_job_master_id and job_task_id =7;

                  select (order_details.p_loss*order_details.quantity) into temp_ploss_info from job_masters
                  inner join order_details ON order_details.id = job_masters.order_details_id
                  where job_masters.id=param_job_master_id;


                  select (people.mv * order_details.quantity) into temp_total_mv from  job_masters
                  inner join order_details ON order_details.id = job_masters.order_details_id
                  inner join order_masters ON order_masters.id = order_details.order_master_id
                  inner join people ON people.id = order_masters.person_id
                  where job_masters.id = param_job_master_id;


                  select (((temp_pan_send + temp_pan_ret)*bill_adjustments.value)/100) into total_pan FROM bill_adjustments where id=1;

                  select temp_gold_send + temp_gold_ret  + total_pan + temp_nitric_ret + temp_ploss_info + temp_total_mv into temp_gold_quantity ;

                IF temp_gold_quantity IS NULL THEN
                    RETURN 0;
                END IF;
                RETURN temp_gold_quantity;
                END;'
        );

        DB::unprepared( 'DROP PROCEDURE IF EXISTS getStockWithTag;
                    CREATE PROCEDURE getStockWithTag()
                    BEGIN



                    select stocks.id,stocks.gold, stocks.agent_id , stocks.amount, stocks.in_stock,stocks.quantity, stocks.gross_weight,stocks.material_id,products.model_number,stocks.job_master_id,order_details.size,people.id as person_id,
                    concat( conv(SUBSTRING(tag, 5,5),10,16),\'-\' ,
                    conv(SUBSTRING_INDEX(SUBSTRING_INDEX(tag,\'-\',-2), \'-\',1),10,16),\'-\',
                    SUBSTRING_INDEX(tag,\'-\',-1)) as tag
                    from stocks
                    inner join job_masters ON job_masters.id = stocks.job_master_id
                    inner join order_details ON order_details.id = job_masters.order_details_id
                    inner join order_masters ON order_masters.id = order_details.order_master_id
                    inner join people ON people.id = order_masters.person_id
                    inner join products ON products.id = order_details.product_id
                    where stocks.in_stock=1;

                    END;'

        );

        DB::unprepared( 'DROP PROCEDURE IF EXISTS getBillByMasterId;
                    CREATE PROCEDURE gold_db.`getBillByMasterId`(IN `temp_bill_master_id` INT)
                    BEGIN

                        select (table1.temp_LC - ((table1.discount / 100) * table1.temp_LC)) as total_LC, temp_gold from(select sum(bill_details.LC) as temp_LC , sum(bill_details.pure_gold) as temp_gold, bill_masters.discount from bill_masters
                        inner join bill_details on bill_details.bill_master_id = bill_masters.id
                        where bill_masters.id = temp_bill_master_id) as table1;

                    END;'

        );

        DB::unprepared('DROP FUNCTION IF EXISTS get_LC_due_by_customer_id;
            CREATE FUNCTION gold_db.`get_LC_due_by_customer_id`(`param_customer_id` INT) RETURNS double
                DETERMINISTIC
            BEGIN
                  DECLARE temp_total_billed_LC double;
                  DECLARE temp_opening_balance_LC double;
                  DECLARE temp_total_payment double;
                  DECLARE temp_total_LC_due double;
                     select get_opening_balance_LC_by_customer_id(param_customer_id) into temp_opening_balance_LC;

                     select sum(get_billed_LC_by_bill_master_id(id)) into temp_total_billed_LC from bill_masters where bill_masters.customer_id = param_customer_id;

                     select get_total_LC_payment_by_customer_id(param_customer_id) into temp_total_payment;

                     select  temp_opening_balance_LC + temp_total_billed_LC - temp_total_payment into temp_total_LC_due;

                  IF temp_total_LC_due IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_total_LC_due;
               END;');

        DB::unprepared('DROP FUNCTION IF EXISTS get_gold_due_by_customer_id;
                CREATE FUNCTION gold_db.`get_gold_due_by_customer_id`(`param_customer_id` INT) RETURNS double
                    DETERMINISTIC
                BEGIN
                  DECLARE temp_total_billed_gold double;
                  DECLARE temp_opening_balance_Gold double;
                  DECLARE temp_total_gold_received double;
                  DECLARE temp_total_gold_due double;


                     select get_opening_balance_gold_by_customer_id(param_customer_id) into temp_opening_balance_Gold;

                     select sum(get_billed_gold_by_bill_master_id(id)) into temp_total_billed_gold from bill_masters where customer_id = param_customer_id;

                     select get_total_gold_payment_by_customer_id(param_customer_id) into temp_total_gold_received;

                     select  temp_opening_balance_Gold + temp_total_billed_gold - temp_total_gold_received into temp_total_gold_due;

                  IF temp_total_gold_due IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_total_gold_due;
            END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS get_bill_info;
            CREATE FUNCTION gold_db.`get_bill_info`(`param_bill_master_id` INT) RETURNS double
            DETERMINISTIC
            BEGIN
                  DECLARE temp_total_LC double;


                  select sum(bill_details.LC) into temp_total_LC  from bill_details where bill_details.bill_master_id = param_bill_master_id;
                  select (temp_total_LC - ((bill_masters.discount/100)*temp_total_LC)) into temp_total_LC  from bill_masters where bill_masters.id = param_bill_master_id;


                IF temp_total_LC IS NULL THEN
                    RETURN 0;
                END IF;
                RETURN temp_total_LC;
            END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS get_billed_gold_by_bill_master_id;
        CREATE FUNCTION gold_db.`get_billed_gold_by_bill_master_id`(`param_bill_master_id` INT) RETURNS double
        DETERMINISTIC
        BEGIN

                  DECLARE temp_billed_gold double;

                  select sum(bill_details.pure_gold) into temp_billed_gold from bill_details where bill_details.bill_master_id = param_bill_master_id;

                  IF temp_billed_gold IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_billed_gold;
               END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS get_billed_LC_by_bill_master_id;
                CREATE FUNCTION gold_db.`get_billed_LC_by_bill_master_id`(`param_bill_master_id` INT) RETURNS double
                    DETERMINISTIC
                BEGIN
                                      DECLARE temp_total_LC double;
                      DECLARE temp_discount double;
                      DECLARE temp_billed_LC double;

                      select sum(bill_details.quantity*bill_details.rate) into temp_total_LC from bill_details where bill_details.bill_master_id = param_bill_master_id;

                      select bill_masters.discount into temp_discount FROM bill_masters where id = param_bill_master_id ;

                      select temp_total_LC - temp_discount into temp_billed_LC;

                      IF temp_billed_LC IS NULL THEN
                          RETURN 0;
                      END IF;
                      RETURN temp_billed_LC;
                 END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS get_opening_balance_gold_by_customer_id;
                CREATE FUNCTION gold_db.`get_opening_balance_gold_by_customer_id`(`param_customer_id` INT) RETURNS double
                    DETERMINISTIC
                BEGIN

                       DECLARE temp_opening_balance_gold double;

                       select people.opening_balance_Gold into temp_opening_balance_gold  from people where id = param_customer_id;

                       IF temp_opening_balance_gold IS NULL THEN
                       RETURN 0;
                       END IF;
                       RETURN temp_opening_balance_gold;
                 END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS get_opening_balance_LC_by_customer_id;
                CREATE FUNCTION gold_db.`get_opening_balance_LC_by_customer_id`(`param_customer_id` INT) RETURNS double
                    DETERMINISTIC
                BEGIN

                      DECLARE temp_opening_balance_LC double;

                      select people.opening_balance_LC into temp_opening_balance_LC  from people where id = param_customer_id;

                      IF temp_opening_balance_LC IS NULL THEN
                          RETURN 0;
                      END IF;
                      RETURN temp_opening_balance_LC;
                 END;'
        );


        DB::unprepared('DROP FUNCTION IF EXISTS get_total_gold_payment_by_customer_id;
                CREATE FUNCTION gold_db.`get_total_gold_payment_by_customer_id`(`param_customer_id` INT) RETURNS double
                    DETERMINISTIC
                BEGIN

                      DECLARE temp_total_gold_payment double;

                      select sum(payment_gold.gold_received) into temp_total_gold_payment  from payment_gold where payment_gold.person_id = param_customer_id;

                      IF temp_total_gold_payment IS NULL THEN
                          RETURN 0;
                      END IF;
                      RETURN temp_total_gold_payment;
                END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS gold_db.get_total_LC_payment_by_customer_id;
                CREATE FUNCTION get_total_LC_payment_by_customer_id(param_customer_id INT) RETURNS double
                    DETERMINISTIC
                BEGIN

                      DECLARE temp_total_LC_payment double;

                      select sum(payment_cashes.cash_received) into temp_total_LC_payment  from payment_cashes where payment_cashes.person_id = param_customer_id;

                      IF temp_total_LC_payment IS NULL THEN
                          RETURN 0;
                      END IF;
                      RETURN temp_total_LC_payment;
                END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS get_employee_balance;
                CREATE FUNCTION get_employee_balance(param_employee_id INT , param_material_id INT  ) RETURNS double
                    DETERMINISTIC
                BEGIN
                                  DECLARE temp_opening_balance double;
                                  DECLARE temp_total_instock double;
                                  DECLARE temp_total_outstock double;

                                  DECLARE temp_total_gold_submit double;
                                  DECLARE temp_total_dal_submit double;
                                  DECLARE temp_total_pan_submit double;
                                  DECLARE temp_total_bronze_submit double;

                                  DECLARE temp_total_gold_return double;
                                  DECLARE temp_total_dal_return double;
                                  DECLARE temp_total_pan_return double;
                                  DECLARE temp_total_nitric_return double;

                                  DECLARE temp_gold_payment double;

                                  DECLARE temp_total_balance double;

                                  /*Opening balance*/
                                  select ifnull(sum(quantity),0) into temp_opening_balance from employee_opening_balances
                                  where employee_opening_balances.employee_id = param_employee_id
                                  and employee_opening_balances.material_id = param_material_id;


                                  select ifnull(sum(material_transaction_details.quantity),0)into temp_total_instock from material_transaction_masters
                                  inner join material_transaction_details
                                  on material_transaction_details.transaction_masters_id = material_transaction_masters.id
                                  where material_transaction_details.employee_id = param_employee_id
                                  and material_transaction_masters.material_id = param_material_id
                                  and material_transaction_details.transaction_value = 1;

                                  select ifnull(sum(material_transaction_details.quantity),0)into temp_total_outstock from material_transaction_masters
                                  inner join material_transaction_details
                                  on material_transaction_details.transaction_masters_id = material_transaction_masters.id
                                  where material_transaction_details.employee_id = param_employee_id
                                  and material_transaction_masters.material_id = param_material_id
                                  and material_transaction_details.transaction_value = -1;

                                  /*Gold submit*/
                                  select abs(ifnull(sum(material_quantity),0)) into temp_total_gold_submit from job_details
                                  where material_id = param_material_id and employee_id = param_employee_id and job_task_id = 1;

                                  /*dal submit*/
                                  select abs(ifnull(sum(material_quantity),0)) into temp_total_dal_submit from job_details
                                  where material_id = param_material_id and employee_id = param_employee_id and job_task_id = 3;

                                  /*pan submit*/
                                  select abs(ifnull(sum(material_quantity),0)) into temp_total_pan_submit from job_details
                                  where material_id = param_material_id and employee_id = param_employee_id and job_task_id = 5;

                                  /*bronze submit*/
                                  select abs(ifnull(sum(material_quantity),0)) into temp_total_bronze_submit from job_details
                                  where material_id = param_material_id and employee_id = param_employee_id and job_task_id = 8;

                                  /*gold return*/
                                  select abs(ifnull(sum(material_quantity),0)) into temp_total_gold_return from job_details
                                  inner join materials ON materials.id = job_details.material_id
                                  where employee_id = param_employee_id and job_task_id = 2 and materials.main_material_id = param_material_id;

                                  select if(param_material_id=1,ifnull(sum(gold_received),0),0) into temp_gold_payment from payment_gold
                                   where user_id = param_employee_id;



                                  /*dal return*/
                                  select abs(ifnull(sum(material_quantity),0)) into temp_total_dal_return from job_details
                                  inner join materials ON materials.id = job_details.material_id
                                  where employee_id = param_employee_id and job_task_id = 4 and materials.main_material_id = param_material_id;

                                  /*pan return*/
                                  select abs(ifnull(sum(material_quantity),0)) into temp_total_pan_return from job_details
                                  inner join materials ON materials.id = job_details.material_id
                                  where employee_id = param_employee_id and job_task_id = 6 and materials.main_material_id = param_material_id;

                                  /*nitric return*/
                                  select abs(ifnull(sum(material_quantity),0)) into temp_total_nitric_return from job_details
                                  inner join materials ON materials.id = job_details.material_id
                                  where employee_id = param_employee_id and job_task_id = 7 and materials.main_material_id = param_material_id;

                                  /*select sum(gold_received) into temp_gold_payment from payment_gold
                                  where user_id = param_employee_id;*/

                                  select ((temp_total_instock + temp_opening_balance) - temp_total_outstock)+
                                  ((temp_total_gold_return+temp_gold_payment) - temp_total_gold_submit) + (temp_total_dal_return - temp_total_dal_submit)+
                                  (temp_total_pan_return - temp_total_pan_submit) + temp_total_nitric_return into temp_total_balance;


                                IF temp_total_balance IS NULL THEN
                                    RETURN 0;
                                END IF;
                                RETURN temp_total_balance;
                            END;
                '
        );
//old method----------
//        DB::unprepared('DROP PROCEDURE IF EXISTS gold_db.getBilledJobInfo;
//                        CREATE PROCEDURE gold_db.`getBilledJobInfo`(IN `job_master_id` INT)
//                        BEGIN
//                                                      select job_tasks.task_name,job_tasks.id,ifNull(sum(table1.material_quantity),0)as material_submitted,table1.p_loss, table1.rate, table1.quantity, table1.mv, table1.model_number  from  job_tasks left join
//                                                      (select job_details.job_master_id, job_details.job_task_id, job_details.material_quantity,order_details.p_loss,bill_details.rate, bill_details.quantity, bill_details.mv,bill_details.model_number
//                                                      from job_details
//                                                      inner join job_masters ON job_masters.id = job_details.job_master_id
//                                                      inner join order_details ON order_details.id = job_masters.order_details_id
//                                                      inner join bill_details on job_details.job_master_id = bill_details.job_master_id
//                                                      where job_details.job_master_id = job_master_id) as table1
//                                                      on job_tasks.id = table1.job_task_id
//                                                      group by job_tasks.id,job_tasks.task_name,table1.p_loss, table1.rate, table1.quantity, table1.mv, table1.model_number;
//
//                        END;'
//        );

//New method----------


        DB::unprepared('DROP PROCEDURE IF EXISTS gold_db.getBilledJobInfo;
                        CREATE PROCEDURE gold_db.`getBilledJobInfo`(IN `in_job_master_id` INT)
                        DETERMINISTIC
                        BEGIN
                                         select job_tasks.task_name,job_tasks.id,ifNull(sum(table1.material_quantity),0)as material_submitted,table1.p_loss, table1.rate, table1.quantity, table1.mv, table1.model_number ,ifNull(table1.user_name,"N/A") as user_name  from  job_tasks left join
                                         (select people.user_name,job_details.job_master_id,job_details.employee_id, job_details.job_task_id, job_details.material_quantity,order_details.p_loss,bill_details.rate, bill_details.quantity, bill_details.mv,bill_details.model_number
                                         from job_details
                                         inner join people ON people.id = job_details.employee_id
                                         inner join job_masters ON job_masters.id = job_details.job_master_id
                                         inner join order_details ON order_details.id = job_masters.order_details_id
                                         inner join bill_details on job_details.job_master_id = bill_details.job_master_id
                                         where job_details.job_master_id = in_job_master_id) as table1
                                         on job_tasks.id = table1.job_task_id
                                         group by job_tasks.id,job_tasks.task_name,table1.p_loss, table1.rate, table1.quantity, table1.mv, table1.model_number, table1.user_name;

                        END;'
        );



//        DB::unprepared('DROP FUNCTION IF EXISTS gold_db.get_employee_balance;
//            CREATE FUNCTION gold_db.`get_employee_balance`(`param_employee_id` INT , `param_material_id` INT  ) RETURNS double
//                DETERMINISTIC
//            BEGIN
//                  DECLARE temp_opening_balance double;
//                  DECLARE temp_total_instock double;
//                  DECLARE temp_total_outstock double;
//
//                  DECLARE temp_total_gold_submit double;
//                  DECLARE temp_total_dal_submit double;
//                  DECLARE temp_total_pan_submit double;
//                  DECLARE temp_total_bronze_submit double;
//
//                  DECLARE temp_total_gold_return double;
//                  DECLARE temp_total_dal_return double;
//                  DECLARE temp_total_pan_return double;
//                  DECLARE temp_total_nitric_return double;
//
//                  DECLARE temp_total_balance double;
//
//                  /*Opening balance*/
//                  select ifnull(sum(quantity),0) into temp_opening_balance from employee_opening_balances
//                  where employee_opening_balances.employee_id = param_employee_id
//                  and employee_opening_balances.material_id = param_material_id;
//
//
//                  select ifnull(sum(material_transaction_details.quantity),0)into temp_total_instock from material_transaction_masters
//                  inner join material_transaction_details
//                  on material_transaction_details.transaction_masters_id = material_transaction_masters.id
//                  where material_transaction_details.employee_id = param_employee_id
//                  and material_transaction_masters.material_id = param_material_id
//                  and material_transaction_details.transaction_value = 1;
//
//                  select ifnull(sum(material_transaction_details.quantity),0)into temp_total_outstock from material_transaction_masters
//                  inner join material_transaction_details
//                  on material_transaction_details.transaction_masters_id = material_transaction_masters.id
//                  where material_transaction_details.employee_id = param_employee_id
//                  and material_transaction_masters.material_id = param_material_id
//                  and material_transaction_details.transaction_value = -1;
//
//                  /*Gold submit*/
//                  select abs(ifnull(sum(material_quantity),0)) into temp_total_gold_submit from job_details
//                  where material_id = param_material_id and employee_id = param_employee_id and job_task_id = 1;
//
//                  /*dal submit*/
//                  select abs(ifnull(sum(material_quantity),0)) into temp_total_dal_submit from job_details
//                  where material_id = param_material_id and employee_id = param_employee_id and job_task_id = 3;
//
//                  /*pan submit*/
//                  select abs(ifnull(sum(material_quantity),0)) into temp_total_pan_submit from job_details
//                  where material_id = param_material_id and employee_id = param_employee_id and job_task_id = 5;
//
//                  /*bronze submit*/
//                  select abs(ifnull(sum(material_quantity),0)) into temp_total_bronze_submit from job_details
//                  where material_id = param_material_id and employee_id = param_employee_id and job_task_id = 8;
//
//                  /*gold return*/
//                  select abs(ifnull(sum(material_quantity),0)) into temp_total_gold_return from job_details
//                  inner join materials ON materials.id = job_details.material_id
//                  where employee_id = param_employee_id and job_task_id = 2 and materials.main_material_id = param_material_id;
//
//                  /*dal return*/
//                  select abs(ifnull(sum(material_quantity),0)) into temp_total_dal_return from job_details
//                  inner join materials ON materials.id = job_details.material_id
//                  where employee_id = param_employee_id and job_task_id = 4 and materials.main_material_id = param_material_id;
//
//                  /*pan return*/
//                  select abs(ifnull(sum(material_quantity),0)) into temp_total_pan_return from job_details
//                  inner join materials ON materials.id = job_details.material_id
//                  where employee_id = param_employee_id and job_task_id = 6 and materials.main_material_id = param_material_id;
//
//                  /*nitric return*/
//                  select abs(ifnull(sum(material_quantity),0)) into temp_total_nitric_return from job_details
//                  inner join materials ON materials.id = job_details.material_id
//                  where employee_id = param_employee_id and job_task_id = 7 and materials.main_material_id = param_material_id;
//
//
//                  select ((temp_total_instock + temp_opening_balance) - temp_total_outstock)+
//                  (temp_total_gold_return - temp_total_gold_submit) + (temp_total_dal_return - temp_total_dal_submit)+
//                  (temp_total_pan_return - temp_total_pan_submit) + temp_total_nitric_return into temp_total_balance;
//
//
//                IF temp_total_balance IS NULL THEN
//                    RETURN 0;
//                END IF;
//                RETURN temp_total_balance;
//            END;
//        ');

        DB::unprepared('DROP PROCEDURE IF EXISTS employeeTransaction;
            CREATE PROCEDURE employeeTransaction(IN param_employee_id INT, IN param_transaction_masters_id  INT)
            BEGIN

                                   select transaction_types.transaction_type, x.employee_id as user1 ,y.employee_id as user2 ,user1.person_name as user1_person_name,user2.person_name  as user2_person_name,x.transaction_value as user1_val,  y.transaction_value as user2_val ,x.transaction_masters_id, materials.material_name,x.quantity, x.created_at
                                   FROM material_transaction_details x join material_transaction_details y
                                   on x.employee_id <> y.employee_id
                                   inner join material_transaction_masters ON material_transaction_masters.id = x.transaction_masters_id
                                   inner join people as user1 on  user1.id = x.employee_id
                                   inner join people as user2 on  user2.id = y.employee_id
                                   inner join transaction_types ON transaction_types.id = material_transaction_masters.transaction_type_id
                                   inner join materials ON materials.id = material_transaction_masters.material_id
                                   where x.employee_id = param_employee_id
                                   and x.transaction_masters_id = param_transaction_masters_id
                                   and y.transaction_masters_id = param_transaction_masters_id ;

            END;'
        );
        // function to check a person is deletable or not
        DB::unprepared('DROP FUNCTION IF EXISTS is_deletable_person;
            CREATE FUNCTION `is_deletable_person`(`PARAM_ID` INT) RETURNS INT
            DETERMINISTIC
            BEGIN

                  DECLARE temp_entry_count INT;
                  DECLARE temp_count INT;
                  set temp_entry_count=0;
                  -- counting order master entry
                  select count(*) into temp_count from order_masters where person_id=PARAM_ID;
                  set temp_entry_count:=temp_entry_count+temp_count;

                  IF temp_entry_count>0 THEN
                      RETURN 0;
                  else
                      RETURN 1;
                  END IF;

            END;'
        );













    }

    public function down()
    {
        Schema::dropIfExists('all_procedures_and_functions');
    }
}
