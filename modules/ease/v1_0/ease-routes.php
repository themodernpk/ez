<?php
//=========================================================================================================================
//API PUBLIC
use Illuminate\Support\Facades\Mail;

Route::group(array('prefix' => 'api/public'),function() {
    Route::post('/login',array('as' => 'post-login','uses'=>'EaseApiPublicController@postLogin'));
    Route::get('/servicelist',array('as' => 'get-service-list','uses'=>'EaseApiPublicController@getServiceList'));
    Route::post('/professionlist',array('as'=>'get-profession-list','uses'=>'EaseApiPublicController@getProfessionList'));
    Route::get('/countrylist',array('as'=>'get-country-list','uses' => 'EaseApiPublicController@getCountryList'));
    Route::post('/offers',array('as'=>'get-offers','uses'=>'EaseApiPublicController@getOffers'));
    Route::get('/faq',array('as'=>'get-faq','uses'=>'EaseApiPublicController@getFaq'));
    Route::post('/tnc',array('as'=>'get-tnc','uses'=>'EaseApiPublicController@getTnc'));
    Route::get('/settingKey/{key}',array('as'=>'get-setting-key','uses'=>'EaseApiPublicController@getSettingKey'));
    });
//=========================================================================================================================
//API SEEKER

    Route::post('api/seeker/register', array('as' => 'seeker/register', 'uses' => 'EaseApiSeekerController@postRegister'));

    Route::group(array('before' => 'login','prefix' => 'api/seeker'), function () {
        Route::post('/read', array('as' => 'get-seeker', 'uses' => 'EaseApiSeekerController@getSeeker'));
        Route::post('update', array('as' => 'post-update-seeker', 'uses' => 'EaseApiSeekerController@postUpdateSeeker'));
        Route::post('raise-request', array('as' => 'raise-request', 'uses' => 'EaseApiSeekerController@postRaiseServiceRequest'));
        Route::post('/use-coupon', array('as' => 'use-coupon', 'uses' => 'EaseApiSeekerController@postUseCoupon'));
        Route::post('/cancel-request', array('as' => 'post-cancel-service-request', 'uses' => 'EaseApiSeekerController@postCancelServiceRequest'));
        Route::post('/charge-cancelletion-fee', array('as' => 'charge-cancelletion-fee', 'uses' => 'EaseApiSeekerController@postChargeCancelletionFee'));
        Route::post('/extend-time', array('as' => 'post-extend-time', 'uses' => 'EaseApiSeekerController@postExtendTime'));
        Route::post('/make-payment', array('as' => 'post-make-payment', 'uses' => 'EaseApiSeekerController@postMakePayment'));
        Route::post('/update-service-request', array('as' => 'post-update-service-request', 'uses' => 'EaseApiSeekerController@postUpdateServiceRequest'));
    });
//=========================================================================================================================
//API PROVIDER
Route::post('api/provider/register',array('as' => 'post-register','uses'=>'EaseApiProviderController@postRegister'));

Route::group(array('before' => 'login','prefix' => 'api/provider'),function() {
    Route::post('/read',array('as' => 'post-provider','uses'=>'EaseApiProviderController@postProvider'));
    Route::post('/update',array('as'=>'post-update-provider','uses'=>'EaseApiProviderController@postUpdateProvider'));
    Route::post('/accept',array('as'=>'post-accept-service-request','uses' => 'EaseApiProviderController@postAcceptServiceRequest'));
    Route::post('/{id}/mark-paid/{service_request_id}',array('as'=>'post-mark-paid','uses'=>'EaseApiProviderController@postMarkPaid'));
    Route::post('/{id}/withdraw-payment',array('as'=>'post-withdraw-payment','uses'=>'EaseApiProviderController@postFaq'));
    Route::post('/{id}/pay-commission',array('as'=>'post-pay-commission','uses'=>'EaseApiProviderController@postPayCommission'));
});
//=========================================================================================================================
//API Service Request
Route::group(array('before' => 'login','prefix' => 'api/service-request'),function() {
    Route::post('/request-list-nearby',array('as' => 'request-list-nearby','uses'=>'EaseApiServiceRequestController@postServiceRequestListNearby'));
    Route::post('/post-service-request-by',array('as' => 'post-service-request-by','uses'=>'EaseApiServiceRequestController@postServiceRequestBy'));
    Route::post('/history/seeker/{seeker_id?}',array('as'=>'post-seeker-service-request-history','uses'=>'EaseApiServiceRequestController@postSeekerServiceRequestHistory'));
    Route::post('/history/provider/{seeker_id?}',array('as'=>'post-provider-service-request-history','uses' => 'EaseApiServiceRequestController@postProviderServiceRequestHistory'));
    Route::post('/{id?}/log-time}',array('as'=>'post-service-request-log-time','uses'=>'EaseApiServiceRequestController@postMarkPaid'));
    Route::post('/{service_request_id}/accepted-providers-count',array('as'=>'post-current-provider-count','uses'=>'EaseApiServiceRequestController@postCurrentProviderCount'));
    Route::post('/start-service',array('as'=>'post-start-service','uses'=>'EaseApiServiceRequestController@postStartService'));
    Route::post('/start-stop',array('as'=>'post-stop-service','uses'=>'EaseApiServiceRequestController@postStopService'));
});
//=========================================================================================================================
//API Ease-User
Route::group(array('before' => 'login','prefix' =>"api/ease-user"),function(){
    Route::post('/checkcode',array('as'=>'post-reset-password','uses'=>'EaseApiUserController@checkCode'));
    Route::post('/resendcode',array('as'=>'post-reset-password','uses'=>'EaseApiUserController@resendCode'));
    Route::post('api/user/writetosupport',array('as'=>'post-write-to-support','uses'=>'EaseApiUserController@postWriteToSupport'));
    Route::post('/forgot-password',array('as'=>'post-forgot-password','uses'=>'EaseApiUserController@postForgotPassword'));
    Route::post('/reset-password',array('as'=>'post-reset-password','uses'=>'EaseApiUserController@postResetPassword'));
    Route::post('/changepassword',array('as'=>'post-change-password','uses'=>'EaseApiUserController@postChangePassword'));
    Route::post('/write-review-provider',array('as'=>'post-write-review','uses'=>'EaseApiUserController@postWriteReviewProvider'));
    Route::post('/write-review-seeker',array('as'=>'post-write-review','uses'=>'EaseApiUserController@postWriteReviewSeeker'));
    Route::post('{id}/write-report',array('as'=>'post-write-report','uses'=>'EaseApiUserController@postWriteReport'));

    Route::get('{id}/payment-history/{user-type}/{monthly?}',array('as'=>'get-payment-history','uses'=>'EaseApiUserController@getPaymentHistory'));
    Route::post('{id}/post-add-money',array('as'=>'post-forgot-password','uses'=>'EaseApiUserController@postAddMoneyToWallet'));
    Route::post('{id}/logout',array('as'=>'post-logout','uses'=>'EaseApiUserController@postLogout'));
});
//=========================================================================================================================
/* protected urls */
Route::get('/db/update', array('as' => 'bmb-db-update', 'uses' => 'EaseDbController@index'));
Route::group(array('before' => 'auth', 'prefix' => 'ease-admin'), function () {
//----------DB Update
    Route::get('/db/reset', array('as' => 'bmb-db-reset', 'uses' => 'EaseDbController@reset'));
//=========================================================================================================================
    //country controller
    Route::group(array('prefix' => 'country'), function () {
        //----------Permission
        Route::get('/index', array('as' => 'ease-country-index', 'uses' => 'EaseCountryController@index'));
        Route::any('/create', array('as' => 'ease-country-create', 'uses' => 'EaseCountryController@create'));
        Route::any('/read/{_id?}', array('as' => 'ease-country-read', 'uses' => 'EaseCountryController@read'));
        Route::any('/update/{_id?}', array('as' => 'ease-country-update', 'uses' => 'EaseCountryController@update'));
        Route::any('/delete/{_id?}', array('as' => 'ease-country-delete', 'uses' => 'EaseCountryController@delete'));
        Route::any('/bulk/action', array('as' => 'ease-country-bulk-action', 'uses' => 'EaseCountryController@bulkAction'));
    });
//=========================================================================================================================
        //----------Permission
    Route::group(array('prefix' => 'faq'), function () {
        Route::get('/index', array('as' => 'ease-faq-index', 'uses' => 'EaseFaqController@index'));
        Route::any('/create', array('as' => 'ease-faq-create', 'uses' => 'EaseFaqController@create'));
        Route::any('/read/{_id?}', array('as' => 'ease-faq-read', 'uses' => 'EaseFaqController@read'));
        Route::any('/update/{_id?}', array('as' => 'ease-faq-update', 'uses' => 'EaseFaqController@update'));
        Route::any('/delete/{_id?}', array('as' => 'ease-faq-delete', 'uses' => 'EaseFaqController@delete'));
        Route::any('/bulk/action', array('as' => 'ease-faq-bulk-action', 'uses' => 'EaseFaqController@bulkAction'));
    });
    //=========================================================================================================================
    //----------Permission
    Route::group(array('prefix' => 'setting'), function () {
        Route::get('/index', array('as' => 'ease-setting-index', 'uses' => 'EaseSettingController@index'));
        Route::any('/create', array('as' => 'ease-setting-create', 'uses' => 'EaseSettingController@create'));
        Route::any('/read/{_id?}', array('as' => 'ease-setting-read', 'uses' => 'EaseSettingController@read'));
        Route::any('/update/{_id?}', array('as' => 'ease-setting-update', 'uses' => 'EaseSettingController@update'));
        Route::any('/delete/{_id?}', array('as' => 'ease-setting-delete', 'uses' => 'EaseSettingController@delete'));
        Route::any('/bulk/action', array('as' => 'ease-setting-bulk-action', 'uses' => 'EaseSettingController@bulkAction'));
    });
//=========================================================================================================================
    Route::group(array('prefix' => 'service'), function () {
        Route::get('/index', array('as' => 'ease-service-index', 'uses' => 'EaseServiceController@index'));
        Route::any('/create', array('as' => 'ease-service-create', 'uses' => 'EaseServiceController@create'));
        Route::any('/read/{_id?}', array('as' => 'ease-service-read', 'uses' => 'EaseServiceController@read'));
        Route::any('/update/{_id?}', array('as' => 'ease-service-update', 'uses' => 'EaseServiceController@update'));
        Route::any('/delete/{_id?}', array('as' => 'ease-service-delete', 'uses' => 'EaseServiceController@delete'));
        Route::any('/bulk/action', array('as' => 'ease-service-bulk-action', 'uses' => 'EaseServiceController@bulkAction'));
    });
//=========================================================================================================================
    //TermAndCondition
    Route::group(array('prefix' => 'tnc'), function () {
    Route::get('/index', array('as' => 'ease-tnc-index', 'uses' => 'EaseTncController@index'));
    Route::any('/create', array('as' => 'ease-tnc-create', 'uses' => 'EaseTncController@create'));
    Route::any('/read/{_id?}', array('as' => 'ease-tnc-read', 'uses' => 'EaseTncController@read'));
    Route::any('/update/{_id?}', array('as' => 'ease-tnc-update', 'uses' => 'EaseTncController@update'));
    Route::any('/delete/{_id?}', array('as' => 'ease-tnc-delete', 'uses' => 'EaseTncController@delete'));
    Route::any('/bulk/action', array('as' => 'ease-tnc-bulk-action', 'uses' => 'EaseTncController@bulkAction'));
});
//=========================================================================================================================
    //offers
    Route::group(array('prefix' => 'offer'), function () {
        Route::get('/index', array('as' => 'ease-offer-index', 'uses' => 'EaseOfferController@index'));
        Route::any('/create', array('as' => 'ease-offer-create', 'uses' => 'EaseOfferController@create'));
        Route::any('/read/{_id?}', array('as' => 'ease-offer-read', 'uses' => 'EaseOfferController@read'));
        Route::any('/update/{_id?}', array('as' => 'ease-offer-update', 'uses' => 'EaseOfferController@update'));
        Route::any('/delete/{_id?}', array('as' => 'ease-offer-delete', 'uses' => 'EaseOfferController@delete'));
        Route::any('/bulk/action', array('as' => 'ease-offer-bulk-action', 'uses' => 'EaseOfferController@bulkAction'));
    });
//=========================================================================================================================
    //coupons
    Route::group(array('prefix' => 'coupon'), function () {
        Route::get('/index', array('as' => 'ease-coupon-index', 'uses' => 'EaseCouponController@index'));
        Route::any('/create', array('as' => 'ease-coupon-create', 'uses' => 'EaseCouponController@create'));
        Route::any('/read/{_id?}', array('as' => 'ease-coupon-read', 'uses' => 'EaseCouponController@read'));
        Route::any('/update/{_id?}', array('as' => 'ease-coupon-update', 'uses' => 'EaseCouponController@update'));
        Route::any('/delete/{_id?}', array('as' => 'ease-coupon-delete', 'uses' => 'EaseCouponController@delete'));
        Route::any('/bulk/action', array('as' => 'ease-coupon-bulk-action', 'uses' => 'EaseCouponController@bulkAction'));
    });
//=========================================================================================================================
    //ProfessionalLevel
    Route::group(array('prefix' => 'profession-level'), function () {
        Route::get('/index', array('as' => 'ease-profession-level-index', 'uses' => 'EaseProfessionLevelController@index'));
        Route::any('/create', array('as' => 'ease-profession-level-create', 'uses' => 'EaseProfessionLevelController@create'));
        Route::any('/read/{_id?}', array('as' => 'ease-profession-level-read', 'uses' => 'EaseProfessionLevelController@read'));
        Route::any('/update/{_id?}', array('as' => 'ease-profession-level-update', 'uses' => 'EaseProfessionLevelController@update'));
        Route::any('/delete/{_id?}', array('as' => 'ease-profession-level-delete', 'uses' => 'EaseProfessionLevelController@delete'));
        Route::any('/bulk/action', array('as' => 'ease-profession-level-bulk-action', 'uses' => 'EaseProfessionLevelController@bulkAction'));
    });
//=========================================================================================================================
    //seeker
    Route::group(array('prefix' => 'seeker'), function () {
        Route::get('/index', array('as' => 'ease-seeker-index', 'uses' => 'EaseSeekerController@index'));
        Route::any('/create', array('as' => 'ease-seeker-create', 'uses' => 'EaseSeekerController@create'));
        Route::any('/read/{_id?}', array('as' => 'ease-seeker-read', 'uses' => 'EaseSeekerController@read'));
        Route::post('/full/update/{id?}', array('as' => 'ease-seeker-full-update', 'uses' => 'EaseSeekerController@updateFullSeeker'));
        Route::any('/update/{/id?}', array('as' => 'ease-seeker-update', 'uses' => 'EaseSeekerController@update'));
        Route::any('/delete/{_id?}', array('as' => 'ease-seeker-delete', 'uses' => 'EaseSeekerController@delete'));
        Route::any('/bulk/action', array('as' => 'ease-seeker-bulk-action', 'uses' => 'EaseSeekerController@bulkAction'));
    });
//=========================================================================================================================
//Providers
    Route::group(array('prefix' => 'provider'), function () {
        Route::get('/index', array('as' => 'ease-provider-index', 'uses' => 'EaseProviderController@index'));
        Route::any('/create', array('as' => 'ease-provider-create', 'uses' => 'EaseProviderController@create'));
        Route::any('/read/{id?}', array('as' => 'ease-provider-read', 'uses' => 'EaseProviderController@read'));
        Route::any('/readdata', array('as' => 'ease-provider-read-data', 'uses' => 'EaseProviderController@readData'));
        Route::any('/update/{_id?}', array('as' => 'ease-provider-update', 'uses' => 'EaseProviderController@update'));
        Route::post('/full/update/{id?}', array('as' => 'ease-provider-full-update', 'uses' => 'EaseProviderController@updateFullProvider'));
        Route::any('/delete/{_id?}', array('as' => 'ease-provider-delete', 'uses' => 'EaseProviderController@delete'));
        Route::any('/bulk/action', array('as' => 'ease-provider-bulk-action', 'uses' => 'EaseProviderController@bulkAction'));
    });
//=========================================================================================================================
//support desk
    Route::group(array('prefix' => 'support'), function () {
        Route::get('/index', array('as' => 'ease-support-index', 'uses' => 'EaseSupportController@index'));
        Route::any('/create', array('as' => 'ease-support-create', 'uses' => 'EaseSupportController@create'));
        Route::any('/read/{_id?}', array('as' => 'ease-support-read', 'uses' => 'EaseSupportController@read'));
        Route::any('/update/{_id?}', array('as' => 'ease-support-update', 'uses' => 'EaseSupportController@update'));
        Route::any('/delete/{_id?}', array('as' => 'ease-support-delete', 'uses' => 'EaseSupportController@delete'));
        Route::any('/bulk/action', array('as' => 'ease-support-bulk-action', 'uses' => 'EaseSupportController@bulkAction'));
    });
//=========================================================================================================================
//Reported Issues
    Route::group(array('prefix' => 'report-issue'), function () {
        Route::get('/index', array('as' => 'ease-report-issue-index', 'uses' => 'EaseReportIssueController@index'));
        Route::any('/create', array('as' => 'ease-report-issue-create', 'uses' => 'EaseReportIssueController@create'));
        Route::any('/read/{_id?}', array('as' => 'ease-report-issue-read', 'uses' => 'EaseReportIssueController@read'));
        Route::any('/update/{_id?}', array('as' => 'ease-report-issue-update', 'uses' => 'EaseReportIssueController@update'));
        Route::any('/delete/{_id?}', array('as' => 'ease-report-issue-delete', 'uses' => 'EaseReportIssueController@delete'));
        Route::any('/bulk/action', array('as' => 'ease-report-issue-bulk-action', 'uses' => 'EaseReportIssueController@bulkAction'));
    });
//=========================================================================================================================
//Payment
    Route::group(array('prefix' => 'payment'), function () {
        Route::get('/index', array('as' => 'ease-payment-index', 'uses' => 'EasePaymentController@index'));
        Route::any('/create', array('as' => 'ease-payment-create', 'uses' => 'EasePaymentController@create'));
        Route::any('/read/{_id?}', array('as' => 'ease-payment-read', 'uses' => 'EasePaymentController@read'));
        Route::any('/update/{_id?}', array('as' => 'ease-payment-update', 'uses' => 'EasePaymentController@update'));
        Route::any('/delete/{_id?}', array('as' => 'ease-payment-delete', 'uses' => 'EasePaymentController@delete'));
        Route::any('/bulk/action', array('as' => 'ease-payment-bulk-action', 'uses' => 'EasePaymentController@bulkAction'));
    });
//=========================================================================================================================
//reviews
    Route::group(array('prefix' => 'review'), function () {
        Route::get('/index', array('as' => 'ease-review-index', 'uses' => 'EaseReviewController@index'));
        Route::any('/create', array('as' => 'ease-review-create', 'uses' => 'EaseReviewController@create'));
        Route::any('/read/{_id?}', array('as' => 'ease-review-read', 'uses' => 'EaseReviewController@read'));
        Route::any('/update/{_id?}', array('as' => 'ease-review-update', 'uses' => 'EaseReviewController@update'));
        Route::any('/delete/{_id?}', array('as' => 'ease-review-delete', 'uses' => 'EaseReviewController@delete'));
        Route::any('/bulk/action', array('as' => 'ease-review-bulk-action', 'uses' => 'EaseReviewController@bulkAction'));
    });
});
//=========================================================================================================================
Route::group(array('prefix' => 'servicerequest'), function () {
    Route::get('/index', array('as' => 'ease-servicerequest-index', 'uses' => 'EaseServiceRequestController@index'));
    Route::any('/create', array('as' => 'ease-servicerequest-create', 'uses' => 'EaseServiceRequestController@create'));
    Route::any('/read/{_id?}', array('as' => 'ease-servicerequest-read', 'uses' => 'EaseServiceRequestController@read'));
    Route::any('/update/{_id?}', array('as' => 'ease-servicerequest-update', 'uses' => 'EaseServiceRequestController@update'));
    Route::any('/delete/{_id?}', array('as' => 'ease-servicerequest-delete', 'uses' => 'EaseServiceRequestController@delete'));
    Route::any('/bulk/action', array('as' => 'ease-servicerequest-bulk-action', 'uses' => 'EaseServiceRequestController@bulkAction'));
});