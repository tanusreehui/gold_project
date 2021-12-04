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