<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateJobProceduresAndFunctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // get gold send to job by job master
        DB::unprepared('DROP FUNCTION IF EXISTS get_gold_send_by_job_master;
                    CREATE FUNCTION get_gold_send_by_job_master(`param_job_master_id` INT) RETURNS double
                        DETERMINISTIC
                    BEGIN
                            DECLARE temp_total_gold_send double;
                            select sum(material_quantity) into temp_total_gold_send from job_details where job_master_id=param_job_master_id and job_task_id=1;
                            IF temp_total_gold_send IS NULL THEN
                                RETURN 0;
                            END IF;
                            RETURN temp_total_gold_send;
                    END;'
        );
        // get gold returned in job by job master
        DB::unprepared('DROP FUNCTION IF EXISTS get_gold_return_by_job_master;
                    CREATE FUNCTION get_gold_return_by_job_master(`param_job_master_id` INT) RETURNS double
                        DETERMINISTIC
                    BEGIN
                            DECLARE temp_total_gold_returned double;
                            select sum(material_quantity) into temp_total_gold_returned from job_details where job_master_id=1 and job_task_id in (2);
                            IF temp_total_gold_returned IS NULL THEN
                                RETURN 0;
                            END IF;
                            RETURN temp_total_gold_returned;
                    END;'
        );
        // get gold used in job by job master
        DB::unprepared('DROP FUNCTION IF EXISTS get_gold_used_by_job_master;
                    CREATE FUNCTION get_gold_used_by_job_master(`param_job_master_id` INT) RETURNS double
                        DETERMINISTIC
                    BEGIN
                            DECLARE temp_total_gold_used double;
                            select sum(material_quantity) into temp_total_gold_used from job_details where job_master_id=1 and job_task_id in (1,2);
                            IF temp_total_gold_used IS NULL THEN
                                RETURN 0;
                            END IF;
                            RETURN temp_total_gold_used;
                    END;'
        );
        // get dal send in job by job master
        DB::unprepared('DROP FUNCTION IF EXISTS get_dal_send_by_job_master;
                    CREATE FUNCTION get_dal_send_by_job_master(`param_job_master_id` INT) RETURNS double
                        DETERMINISTIC
                    BEGIN
                            DECLARE temp_total double;
                            select sum(material_quantity) into temp_total from job_details where job_master_id=param_job_master_id and job_task_id in (3);
                            IF temp_total IS NULL THEN
                                RETURN 0;
                            END IF;
                            RETURN temp_total;
                    END;'
        );
        // get dal returned in job by job master
        DB::unprepared('DROP FUNCTION IF EXISTS get_dal_returned_by_job_master;
                    CREATE FUNCTION get_dal_returned_by_job_master(`param_job_master_id` INT) RETURNS double
                        DETERMINISTIC
                    BEGIN
                            DECLARE temp_total double;
                            select sum(material_quantity) into temp_total from job_details where job_master_id=param_job_master_id and job_task_id in (4);
                            IF temp_total IS NULL THEN
                                RETURN 0;
                            END IF;
                            RETURN temp_total;
                    END;'
        );
        // get dal used in job by job master
        DB::unprepared('DROP FUNCTION IF EXISTS get_dal_used_by_job_master;
                    CREATE FUNCTION get_dal_used_by_job_master(`param_job_master_id` INT) RETURNS double
                        DETERMINISTIC
                    BEGIN
                            DECLARE temp_total double;
                            select sum(material_quantity) into temp_total from job_details where job_master_id=param_job_master_id and job_task_id in (3,4);
                            IF temp_total IS NULL THEN
                                RETURN 0;
                            END IF;
                            RETURN temp_total;
                    END;'
        );

        // get pan send in job by job master
        DB::unprepared('DROP FUNCTION IF EXISTS get_pan_send_by_job_master;
                    CREATE FUNCTION get_pan_send_by_job_master(`param_job_master_id` INT) RETURNS double
                        DETERMINISTIC
                    BEGIN
                            DECLARE temp_total double;
                            select sum(material_quantity) into temp_total from job_details where job_master_id=param_job_master_id and job_task_id in (5);
                            IF temp_total IS NULL THEN
                                RETURN 0;
                            END IF;
                            RETURN temp_total;
                    END;'
        );
        // get pan returned in job by job master
        DB::unprepared('DROP FUNCTION IF EXISTS get_pan_returned_by_job_master;
                    CREATE FUNCTION get_pan_returned_by_job_master(`param_job_master_id` INT) RETURNS double
                        DETERMINISTIC
                    BEGIN
                            DECLARE temp_total double;
                            select sum(material_quantity) into temp_total from job_details where job_master_id=param_job_master_id and job_task_id in (6);
                            IF temp_total IS NULL THEN
                                RETURN 0;
                            END IF;
                            RETURN temp_total;
                    END;'
        );
        // get pan used in job by job master
        DB::unprepared('DROP FUNCTION IF EXISTS get_pan_used_by_job_master;
                    CREATE FUNCTION get_pan_used_by_job_master(`param_job_master_id` INT) RETURNS double
                        DETERMINISTIC
                    BEGIN
                            DECLARE temp_total double;
                            select sum(material_quantity) into temp_total from job_details where job_master_id=param_job_master_id and job_task_id in (5,6);
                            IF temp_total IS NULL THEN
                                RETURN 0;
                            END IF;
                            RETURN temp_total;
                    END;'
        );
        // get pan used in job by job master
        DB::unprepared('DROP FUNCTION IF EXISTS get_nitric_returned_by_job_master;
                    CREATE FUNCTION get_nitric_returned_by_job_master(`param_job_master_id` INT) RETURNS double
                        DETERMINISTIC
                    BEGIN
                            DECLARE temp_total double;
                            select sum(material_quantity) into temp_total from job_details where job_master_id=param_job_master_id and job_task_id in (7);
                            IF temp_total IS NULL THEN
                                RETURN 0;
                            END IF;
                            RETURN temp_total;
                    END;'
        );
        // get pan used in job by job master
        DB::unprepared('DROP FUNCTION IF EXISTS get_bronze_send_by_job_master;
                    CREATE FUNCTION get_bronze_send_by_job_master(`param_job_master_id` INT) RETURNS double
                        DETERMINISTIC
                    BEGIN
                            DECLARE temp_total double;
                            select sum(material_quantity) into temp_total from job_details where job_master_id=param_job_master_id and job_task_id in (8);
                            IF temp_total IS NULL THEN
                                RETURN 0;
                            END IF;
                            RETURN temp_total;
                    END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS get_gold_used_for_bill_by_job_master;
                            CREATE FUNCTION `get_gold_used_for_bill_by_job_master`(`param_job_master_id` INT) RETURNS double
                                DETERMINISTIC
                            BEGIN
                            DECLARE temp_total_gold_used double;
                            select sum(material_quantity*(select bill_percentage from materials where id=job_details.material_id)) into temp_total_gold_used from job_details where job_master_id=1 and job_task_id in (1,2);
                            IF temp_total_gold_used IS NULL THEN
                                RETURN 0;
                            END IF;
                                RETURN temp_total_gold_used;
                            END;'
        );
        DB::unprepared('DROP FUNCTION IF EXISTS get_pan_used_for_bill_by_job_master;
                                CREATE FUNCTION `get_pan_used_for_bill_by_job_master`(`param_job_master_id` INT) RETURNS double
                                    DETERMINISTIC
                                BEGIN
                            DECLARE temp_total_pan_used_for_bill double;
                            select sum(material_quantity*(select bill_percentage from materials where id=job_details.material_id)) into temp_total_pan_used_for_bill from job_details where job_master_id=1 and job_task_id in (5,6);
                            IF temp_total_pan_used_for_bill IS NULL THEN
                                RETURN 0;
                            END IF;
                                RETURN temp_total_pan_used_for_bill;
                            END;'
        );
        DB::unprepared('DROP FUNCTION IF EXISTS get_nitric_returned_for_bill_by_job_master;
                                CREATE FUNCTION `get_nitric_returned_for_bill_by_job_master`(`param_job_master_id` INT) RETURNS double
                                    DETERMINISTIC
                                BEGIN
                            DECLARE temp_total_nitric_return_for_bill double;
                            select sum(material_quantity*(select bill_percentage from materials where id=job_details.material_id)) into temp_total_nitric_return_for_bill from job_details where job_master_id=1 and job_task_id in (7);
                            IF temp_total_nitric_return_for_bill IS NULL THEN
                                RETURN 0;
                            END IF;
                                RETURN temp_total_nitric_return_for_bill;
                            END;'
        );
        DB::unprepared('DROP FUNCTION IF EXISTS get_customer_mv_total_by_job_master;
                                CREATE FUNCTION `get_customer_mv_total_by_job_master`(`param_job_master_id` INT) RETURNS double
                                    DETERMINISTIC
                                BEGIN
                            DECLARE total_mv double;
                            select cust_mv*quantity into total_mv FROM job_masters where id=param_job_master_id;
                            IF total_mv IS NULL THEN
                                RETURN 0;
                            END IF;
                                RETURN round(total_mv,3);
                            END;'
        );
        DB::unprepared('DROP FUNCTION IF EXISTS get_product_mv_total_by_job_master;
                                CREATE FUNCTION `get_product_mv_total_by_job_master`(`param_job_master_id` INT) RETURNS double
                                    DETERMINISTIC
                                BEGIN
                            DECLARE total_mv double;
                            select product_mv*quantity into total_mv FROM job_masters where id=param_job_master_id;
                            IF total_mv IS NULL THEN
                                RETURN 0;
                            END IF;
                                RETURN round(total_mv,3);
                            END;'
        );
        DB::unprepared('
                            DROP FUNCTION IF EXISTS get_finished_job_count_by_order_master_id;
                            CREATE FUNCTION `get_finished_job_count_by_order_master_id`(`param_order_master_id` INT) RETURNS int
                                DETERMINISTIC
                            BEGIN

                              DECLARE temp_finished_jobs double;

                              select count(*) into temp_finished_jobs  from job_masters
                              inner join order_details ON order_details.id = job_masters.order_details_id
                              inner join order_masters ON order_masters.id = order_details.order_master_id
                              where job_masters.status_id=100 and  order_masters.id=param_order_master_id;

                              IF temp_finished_jobs IS NULL THEN
                                  RETURN 0;
                              END IF;
                              RETURN temp_finished_jobs;
                           END;

        ');
        DB::unprepared('
            DROP FUNCTION IF EXISTS get_order_count_by_order_master_id;
            CREATE FUNCTION `get_order_count_by_order_master_id`(`param_order_master_id` INT) RETURNS int
            DETERMINISTIC
            BEGIN

                  DECLARE temp_order_count double;

                  select count(*) into temp_order_count  from order_masters
                  inner join order_details ON order_details.order_master_id = order_masters.id
                  where order_masters.id=param_order_master_id;

                  IF temp_order_count IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_order_count;
            END;
        ');
        DB::unprepared('
            DROP FUNCTION IF EXISTS get_work_in_progress_job_count_by_order_master_id;
            CREATE FUNCTION `get_work_in_progress_job_count_by_order_master_id`(`param_order_master_id` INT) RETURNS int
            DETERMINISTIC
            BEGIN

                  DECLARE temp_wip_jobs double;

                  select count(*) into temp_wip_jobs  from job_masters
                  inner join order_details ON order_details.id = job_masters.order_details_id
                  inner join order_masters ON order_masters.id = order_details.order_master_id
                  where job_masters.status_id=1 and  order_masters.id=param_order_master_id;

                  IF temp_wip_jobs IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_wip_jobs;
            END;

        ');
        DB::unprepared('
            DROP FUNCTION IF EXISTS get_non_started_order_count_by_order_master_id;
            CREATE FUNCTION get_non_started_order_count_by_order_master_id(param_order_master_id INT) RETURNS int
            DETERMINISTIC
            BEGIN

                  DECLARE temp_non_started_order double;

                  select count(*) into temp_non_started_order  from order_masters
                  inner join order_details ON order_details.order_master_id = order_masters.id
                  where order_details.status_id=40 and  order_masters.id=param_order_master_id;
                  IF temp_non_started_order IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_non_started_order;
            END;

        ');










    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_procedures_and_functions');
    }
}
