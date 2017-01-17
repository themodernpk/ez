<?php

class EaseDbController extends BaseController
{
    public function __construct()
    {
    }

    //------------------------------------------------------
    public function index()
    {
        $list = get_class_methods('EaseDbController');
        $release_version = "v1_0";
        foreach ($list as $item) {
            if (strpos($item, 'update_' . $release_version) !== false) {
                echo "<b>" . $item . "</b>";
                echo "<br clear='all'/>";
                EaseDbController::$item();
            }
        }
        echo "<hr/>";
        echo "Execution Completed";
        die();
    }

    //------------------------------------------------------
    public function reset()
    {
        echo "done";
        die();
    }
    //creating ease_user
    public function update_v1_01_2016_08_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('user', function ($table) {
                $table->increments('id');
                $table->integer('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->after('id');
                $table->string('verified')->unsigned()->nullable();
                $table->String('gender')->unsigned()->nullable();
                $table->Double('rating')->unsigned()->nullable();
                $table->Double('wallet')->unsigned()->nullable();
                $table->String('nationality')->unsigned()->nullable();
                $table->integer('number_of_reviews')->unsigned()->nullable();
                $table->String('national_iqama_id')->nullable();
                $table->String('email_verification_code')->nullable();
                $table->String('mobile_verification_code')->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('answer');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //==================================================================================
    //creating ease_faq
    public function update_v1_00_2016_08_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_faqs', function ($table) {
                $table->increments('id');
                $table->string('question')->nullable();
                $table->string('answer')->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('answer');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //------------------------------------------------------
    //creating ease_services
    public function update_v1_02_2016_08_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_services', function ($table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->string('description')->nullable();
                $table->string('icon_url')->nullable();
                $table->string('icon_url_circle')->nullable();
                $table->string('unit')->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
                });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //============================================================
    //creating ease_tncs
    public function update_v1_03_2016_08_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_tncs', function ($table) {
                $table->increments('id');
                $table->string('tnc_for')->nullable();
                $table->string('conditions')->nullable();
                $table->string('heading')->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //==========================================================
    //creating ease_offers
    public function update_v1_04_2016_08_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_offers', function ($table) {
                $table->increments('id');
                $table->string('offer')->nullable();
                $table->string('offer_for')->nullable();
                $table->string('offer_name')->unsigned()->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //------------------------------------------------------
    //creating ease_coupons
    public function update_v1_05_2016_08_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_coupons', function ($table) {
                $table->increments('id');
                $table->text('coupon_code')->nullable();
                $table->text('discounts')->nullable();
                $table->timestamp('exp_date')->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //=============================================================================================
    //creating ease_profession_levels
    public function update_v1_06_2016_08_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_profession_levels', function ($table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->float('base_price')->nullable();
                $table->integer('service_id')->unsigned()->nullable();
                $table->foreign('service_id')->references('_id')->on('ease_services')->onDelete('set null')->after('base_price');
                $table->integer('country_id')->unsigned()->nullable();
                $table->foreign('country_id')->references('_id')->on('ease_countries')->onDelete('set null')->after('service_id');
                $table->String('units')->unsigned()->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('country_id');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //==========================================================
    //creating ease_seekers
    public function update_v1_07_2016_08_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_seekers', function ($table) {
                $table->increments('id');
                $table->integer('ease_user_id')->unsigned()->nullable();
                $table->foreign('ease_user_id')->references('_id')->on('user')->onDelete('set null')->after('id');
                $table->double('cancelletion_amount')->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //==========================================================
    //creating ease_providers
    public function update_v1_08_2016_08_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_providers', function ($table) {
                $table->increments('id');
                $table->integer('ease_user_id')->unsigned()->nullable();
                $table->foreign('ease_user_id')->references('_id')->on('user')->onDelete('set null')->after('id');

                $table->double('pending_commission')->nullable();
                $table->double('amount_withdrew')->nullable();
                $table->double('commission_paid_to_company')->nullable();
                $table->boolean('is_available')->nullable();

                $table->string('profession_level')->unsigned()->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //==========================================================
    //creating ease_supports
    public function update_v1_09_2016_08_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_supports', function ($table) {
                $table->increments('id');
                $table->integer('ease_user_id')->unsigned()->nullable();
                $table->foreign('ease_user_id')->references('_id')->on('ease_user')->onDelete('set null')->after('id');
                $table->string('username')->nullable();
                $table->string('message')->nullable();
                $table->timestamp('sent_on')->nullable();
                $table->String('type')->unsigned()->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //==========================================================
    //creating ease_report_issues
    public function update_v1_010_2016_08_12_4PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_report_issues', function ($table) {
                $table->increments('id');
                $table->integer('ease_provider_id')->unsigned()->nullable();
                $table->foreign('ease_provider_id')->references('_id')->on('ease_providers')->onDelete('set null')->after('id');
                $table->string('subject')->nullable();
                $table->string('comment')->nullable();
                $table->integer('ease_service_request_id')->unsigned()->nullable();
                $table->foreign('ease_service_request_id')->references('_id')->on('ease_service_requests')->onDelete('set null')->after('comment');

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
//======================================================================
//creating ease_reviews
    public function update_v1_012_2016_08_12_4PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_reviews', function ($table) {
                $table->increments('id');
                $table->integer('review_by')->unsigned()->nullable();
                $table->foreign('review_by')->references('_id')->on('user')->onDelete('set null')->after('id');
                $table->integer('review_to')->nullable();
                $table->foreign('review_to')->references('_id')->on('user')->onDelete('set null')->after('review_by');
                $table->text('comment')->nullable();
                $table->timestamp('comment_on')->nullable();
                $table->double('rating')->nullable();
                $table->integer('ease_service_request_id')->unsigned()->nullable();
                $table->foreign('ease_service_request_id')->references('_id')->on('ease_service_requests')->onDelete('set null')->after('rating');

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //============================================================
//creating ease_wallet_histories
    public function update_v1_013_2016_17_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_wallet_histories', function ($table) {
                $table->increments('id');
                $table->integer('ease_user_id')->unsigned()->nullable();
                $table->foreign('ease_user_id')->references('_id')->on('user')->onDelete('set null')->after('id');
                $table->text('action')->unsigned()->nullable();
                $table->text('payment_type')->unsigned()->nullable();
                $table->integer('amount')->unsigned()->nullable();
                $table->string('status')->unsigned()->nullable();
                $table->timestamp('performed_at')->unsigned()->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //============================================================
//creating ease_uploaded_documents
    public function update_v1_014_2016_17_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_uploaded_documents', function ($table) {
                $table->increments('id');
                $table->integer('ease_user_id')->unsigned()->nullable();
                $table->foreign('ease_user_id')->references('_id')->on('user')->onDelete('set null')->after('id');
                $table->string('document_type')->unsigned()->nullable();
                $table->string('url')->unsigned()->nullable();
                $table->string('document_name')->unsigned()->nullable();


                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //==========================================================
//creating ease_user_verifications
    public function update_v1_015_2016_17_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_user_verifications', function ($table) {
                $table->increments('id');
                $table->integer('ease_user_id')->unsigned()->nullable();
                $table->foreign('ease_user_id')->references('_id')->on('user')->onDelete('set null')->after('id');
                $table->string('mobile')->unsigned()->nullable();
                $table->string('email')->unsigned()->nullable();
                $table->string('iqma')->unsigned()->nullable();
                $table->string('documents')->unsigned()->nullable();


                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }

    }
    //--------------------------------------------------------------------
//creating ease_provider_service_requests
    public function update_v1_016_2016_17_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_provider_service_requests', function ($table) {
                $table->increments('id');
                $table->integer('ease_provider_id')->unsigned()->nullable();
                $table->foreign('ease_provider_id')->references('_id')->on('ease_providers')->onDelete('set null')->after('id');
                $table->double('lat')->unsigned()->nullable();
                $table->double('lng')->unsigned()->nullable();
                $table->double('ease_service_request_id')->unsigned()->nullable();
                $table->foreign('ease_service_request_id')->references('_id')->on('ease_service_requests')->onDelete('set null')->after('lat');
                $table->string('action')->unsigned()->nullable();
                $table->timestamp('action_performed_at')->unsigned()->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //--------------------------------------------------------------------
    //creating ease_service_requests
    public function update_v1_017_2016_17_12_3PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_service_requests', function ($table) {
                $table->increments('id');
                $table->integer('ease_seeker_id')->unsigned()->nullable();
                $table->foreign('ease_seeker_id')->references('_id')->on('ease_seekers')->onDelete('set null')->after('id');
                $table->integer('ease_service_id')->unsigned()->nullable();
                $table->foreign('ease_service_id')->references('_id')->on('ease_services')->onDelete('set null')->after('ease_seeker_id');
                $table->integer('number_of_providers')->unsigned()->nullable();

                $table->integer('ease_profession_level_id')->unsigned()->nullable();
                $table->foreign('ease_profession_level_id')->references('_id')->on('ease_profession_levels')->onDelete('set null')->after('number_of_providers');

                $table->timestamp('start_time')->unsigned()->nullable();
                $table->timestamp('end_time')->unsigned()->nullable();
                $table->integer('duration')->unsigned()->nullable();
                $table->integer('ease_country_id')->unsigned()->nullable();
                $table->foreign('ease_country_id')->references('_id')->on('ease_countries')->onDelete('set null')->after('duration');
                $table->double('lat')->unsigned()->nullable();
                $table->double('lng')->unsigned()->nullable();
                $table->String('city')->unsigned()->nullable();
                $table->float('price')->unsigned()->nullable();
                $table->timestamp('is_scheduled')->unsigned()->nullable();
                $table->text('status')->unsigned()->nullable();
                $table->timestamp('changed_at')->unsigned()->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //--------------------------------------------------------------------
    //creating ease_settings
    public function update_v1_018_2016_19_12_6PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_settings', function ($table) {
                $table->increments('id');
                $table->string('name')->unsigned()->nullable();
                $table->string('slug')->unsigned()->nullable();
                $table->string('value')->unsigned()->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('enable');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
//======================================================================================
//creating ease_service_payments
    public function update_v1_019_2016_20_12_12PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_service_payments', function ($table) {
                $table->increments('id');
                $table->double('amount')->nullable();
                $table->integer('ease_seeker_id')->unsigned()->nullable();
                $table->foreign('ease_seeker_id')->references('_id')->on('ease_seekers')->onDelete('set null')->after('amount');
                $table->integer('ease_provider_id')->unsigned()->nullable();
                $table->foreign('ease_provider_id')->references('_id')->on('ease_providers')->onDelete('set null')->after('ease_seeker_id');
                $table->text('payment_through')->nullable();
                $table->integer('ease_service_request_id')->unsigned()->nullable();
                $table->foreign('ease_service_request_id')->references('_id')->on('ease_service_requests')->onDelete('set null')->after('payment_through');
                $table->timestamp('performed_at')->unsigned()->nullable();
                $table->timestamp('status')->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('status');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
//========================================================================================
//======================================================================================
//creating ease_cancelletion_payments
    public function update_v1_020_2016_20_12_12PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_cancelletion_payments', function ($table) {
                $table->increments('id');
                $table->double('amount')->nullable();
                $table->integer('ease_seeker_id')->unsigned()->nullable();
                $table->foreign('ease_seeker_id')->references('_id')->on('ease_seekers')->onDelete('set null')->after('amount');
                $table->text('payment_through')->nullable();
                $table->integer('ease_service_request_id')->unsigned()->nullable();
                $table->foreign('ease_service_request_id')->references('_id')->on('ease_service_requests')->onDelete('set null')->after('payment_through');
                $table->timestamp('performed_at')->unsigned()->nullable();
                $table->timestamp('status')->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('status');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //======================================================================================
//creating ease_commission_payments
    public function update_v1_021_2016_20_12_12PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_commission_payments', function ($table) {
                $table->increments('id');
                $table->double('amount')->nullable();
                $table->integer('ease_provider_id')->unsigned()->nullable();
                $table->foreign('ease_provider_id')->references('_id')->on('ease_providers')->onDelete('set null')->after('amount');
                $table->text('payment_through')->nullable();
                $table->integer('ease_service_request_id')->unsigned()->nullable();
                $table->foreign('ease_service_request_id')->references('_id')->on('ease_service_requests')->onDelete('set null')->after('payment_through');
                $table->timestamp('performed_at')->unsigned()->nullable();
                $table->timestamp('status')->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('status');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //creating ease_service_time_logs
    public function update_v1_022_2016_20_12_12PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_service_time_logs', function ($table) {
                $table->increments('id');
                $table->integer('ease_service_request_id')->unsigned()->nullable();
                $table->foreign('ease_service_request_id')->references('_id')->on('ease_service_requests')->onDelete('set null')->after('id');
                $table->timestamp('start_time')->unsigned()->nullable();
                $table->timestamp('end_time')->unsigned()->nullable();
                $table->string('status')->unsigned()->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('status');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //creating ease_push_notifications
    public function update_v1_023_2016_20_12_12PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_push_notifications', function ($table) {
                $table->increments('id');
                $table->integer('ease_user_id')->unsigned()->nullable();
                $table->foreign('ease_user_id')->references('_id')->on('user')->onDelete('set null')->after('id');
                $table->string('device_id')->unsigned()->nullable();
                $table->string('message')->unsigned()->nullable();
                $table->timestamp('delivered_at')->unsigned()->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('status');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }

    //creating ease_provider_services
    public function update_v1_024_2016_20_12_12PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_provider_services', function ($table) {
                $table->increments('id');
                $table->integer('ease_provider_id')->unsigned()->nullable();
                $table->foreign('ease_provider_id')->references('_id')->on('ease_providers')->onDelete('set null')->after('_id');
                $table->integer('ease_service_id')->unsigned()->nullable();
                $table->foreign('ease_service_request_id')->references('_id')->on('ease_services')->onDelete('set null')->after('ease_provider_id');

                $table->double('lat')->unsigned()->nullable();
                $table->double('lng')->unsigned()->nullable();

                $table->string('action')->unsigned()->nullable();
                $table->timestamp('action_performed_at')->unsigned()->nullable();

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('status');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //creating ease_used_coupons
    public function update_v1_025_2016_20_12_12PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_used_coupons', function ($table) {
                $table->increments('id');
                $table->integer('ease_coupon_id')->unsigned()->nullable();
                $table->foreign('ease_coupon_id')->references('_id')->on('ease_coupons')->onDelete('set null')->after('_id');

                $table->integer('ease_seeker_id')->unsigned()->nullable();
                $table->foreign('ease_seeker_id')->references('_id')->on('ease_seekers')->onDelete('set null')->after('ease_coupon_id');

                $table->integer('ease_service_request_id')->unsigned()->nullable();
                $table->foreign('ease_service_request_id')->references('_id')->on('ease_service_requests')->onDelete('set null')->after('ease_coupon_id');

                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('status');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
    //------------------------------------------------------------------------------
    //creating ease_used_coupons
    public function update_v1_027_2016_20_12_12PM()
    {
        try {
            $connection="mongodb";
            Schema::connection($connection)->create('ease_countries', function ($table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('nationality')->nullable();
                $table->string('slug')->nullable();
                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('slug');
                $table->integer('modified_by')->unsigned()->nullable();
                $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');
                $table->integer('deleted_by')->unsigned()->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');

                $table->timestamps();
                $table->softDeletes();
            });
        } catch (Exception $e) {
            echo $e->getMessage();
            echo " - this will not stop the execution of other functions<hr/>";
        }
    }
}