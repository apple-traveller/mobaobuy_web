<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    /**
     * 控制器返回错误信息
     */
    'clear_goods_not_exist'=>'Clearance commodities do not exist!',//
    'promote_goods_not_exist'=>'Promotional commodities do not exist!',//
    'collect_goods_not_exist'=>'Collection commodities do not exist!',//
    'goods_not_exist'=>'Commodity does not exist!',//
    'insufficient_stock_tips'=>'Insufficient stock to place orders!',//
    'goods_info_tips'=>'Commodity information is incorrect!',//
    'beyond_maximum'=>'Beyond the Maximum!',//
    'only_enterprise_users_tips'=>'Buy-up can only be ordered by enterprise users!',//
    'no_right_place_tips'=>'You have no right to place an order for the enterprise.!',//
    'activity_over_tips'=>'The event is over.!',//
    'no_less_num_tips'=>'No less than the starting quantity!',//
    'user_info_error_tips'=>'Error in User Information!',//
    'contact_info_cannot_empty_tips'=>'Contact information can not be empty!',//!
    'mobile_error_tips'=>'The mobile phone number is wrong!',//!
    'need_content_cannot_empty_tips'=>'Need content can not be empty!',//!
    'wait_service_contact_tips'=>'Requirement information submitted successfully, please wait patiently for customer service contact!',//
    'no_right'=>'No right to visit',//
    'illegal_visits'=>'Illegal visits',//
    'unable_get_id'=>'Unable to get parameter ID',//
    'cat_not_found_tips'=>'No corresponding classification was found.',//
    'out_stock_num_error_tips'=>'The quantity out of warehouse should not be greater than the quantity in stock.',//
    'no_out_stock_info'=>'No corresponding access information',//
    'not_have_func_tips'=>'Individual membership does not have this function',//
    'bound_enterprise_tips'=>'Users have been bound to the enterprise!',//
    'user_not_found'=>'The user was not found!',//
    'enterprise_not_exist'=>'Enterprise users do not exist!',//
    'user_not_exist'=>'User does not exist!',//
    'user_unbound_enterprise'=>'User Unbound Enterprise!',//
    'enterprise_cannot_add'=>'Enterprise accounts cannot be added!',//
    'shop_info_not_exist'=>'Business information does not exist',//
    'order_info_not_exist'=>'Order information does not exist',//
    'cat_cannot_delete'=>'Goods under this category cannot be deleted',//
    'the'=>'',//
    'week'=>'week',//
    'no_brand'=>'No brand',//
    'no_have_right_apply_invoice'=>'You have no right to apply for an invoice.',//
    'invoice_info_not_exist'=>'The invoice information does not exist',//
    'network_error'=>'network error',//
    'select_order_tips'=>'Please select the order',//
    'no_real_name_tips'=>"You can't apply for invoice because you haven't got real-name certification yet.",//
    'real_name_no_pass_tips'=>'Your real-name certification has not been passed and you cannot apply for invoices.',//
    'lack_address_id'=>'Lack of address ID！',//!
    'address_info_not_exist'=>'Address information does not exist！',//!
    'select_success'=>'Successful selection',//
    'lack_invoice_type_parameter'=>'Lack of invoice type parameters！',//!
    'not_meet_special_invoice_tips'=>'You do not meet the requirements for issuing special value-added invoices',//
    'miss_parameter'=>'Missing parameters',//
    'apply_success'=>'Successful application',//
    'apply_error'=>'Application failure',//
    'user_name_cannot_empty'=>'User name cannot be empty',//
    'password_cannot_empty'=>'Password cannot be empty',//
    'login_success'=>'The login is successful and is entering the system.',//
    'bind_account'=>'Bind on Account',//
    'user_name_and_password_param_error'=>'Error in username or password parameters！',//!
    'bind_failed'=>'Binding failed! Please contact customer service.',//
    'user_name_and_password_error'=>'Incorrect username or password！',//!
    'need_audit_can_login_tips'=>'Accounts need to be audited before they can log in！',//!
    'mobile_registered'=>'Mobile phone number has been registered',//
    'enterprises_frozen'=>'Enterprises have been frozen',//
    'business_name_error_tips'=>'Incorrect business name or registered',//
    'mobile_verification_error'=>'The mobile phone verification code is incorrect',//
    'sub_success'=>'Successful submission, please wait for review！',//!
    'register_failed'=>'Registration failed！',//!
    'nothing'=>'nothing',//
    'upload_success'=>'Upload success！',//!
    'order_detail_error'=>'The order details are incorrect!',//
    'audit_success'=>'Audit success',//
    'cancel_success'=>'Cancellation of success',//
    'no_real_name_no_order_tips'=>"You can't place an order because you haven't got a real-name certification yet.",//
    'real_name_no_pass_no_order_tips'=>'Your real-name certification has not been passed and you cannot place an order.',//
    'no_address_info'=>'No address information, please go ahead and maintain it.',//
    'select_address'=>'Please choose the receiving address.',//
    'sub_order_success'=>'Successful submission of orders',//
    'sub_order_error'=>'Failure of order submission',//
    'param_error'=>'Parameter error',//
    'expired_goods'=>'There are expired commercial',//
    'no_order'=>'No order.',//
    'upload_resume_cannot_empty'=>'Upload resume can not be empty',//
    'inquire_info_error'=>'Error in Purchasing Information',//
    'quote_price_cannot_empty'=>'The quotation price cannot be empty',//
    'quote_num_cannot_empty'=>'Quotations cannot be empty',//
    'delivery_area_cannot_empty'=>'The place of delivery cannot be empty',//
    'verification_success'=>'Verification success!',//
    'user_not_real_name'=>'This user is not authenticated by real name!',//

    'graphic_verify_error'=>'Graphic Verification Error',//
    'register_success'=>'Successful registration!',//
    'logout_success'=>'Log out successfully',//
    'choose_address'=>'Please choose the address.',//
    'enter_address_detail'=>'Please enter the detailed address',//
    'enter_consignee'=>'Please enter the consignee',//
    'enter_mobile'=>'Please enter the receiving phone number.',//
    'edit_success'=>'Modified success',//
    'add_address_success'=>'Added Harvest Address Successfully',//
    'delete_success'=>'Successful deletion',//
    'delete_failed'=>'Delete failed',//
    'success'=>'Success',//
    'fail'=>'Fail',//
    'fill_title'=>'Please fill in the company\'s name',//
    'fill_tax_number'=>'Please fill in the tax number.',//
    'fill_open_bank'=>'Please fill in the opening bank.',//
    'fill_bank_account'=>'Please fill in the bank account',//
    'add_real_name_success'=>'Real name information was added successfully, waiting for audit.',//
    'mobile_not_register'=>'Mobile phone number not registered',//
    'collected'=>'This commodity has been collected！',//
    'passed_real_name_can_order'=>'The order can not be placed until the real-name certification has been passed.',//
    'mail_format_error'=>'The mailbox format is incorrect!',//
    'process_unapproved_order'=>'Please process the unapproved order first.',//
    'illegal_operation'=>'Illegal operation',//
    'upload_electronic_license'=>'Please upload the electronic version of the business license.',//
    'upload_electronic_attorney'=>'Please upload the electronic version of invoice information.',//
    'upload_electronic_invoice'=>'Please upload the electronic version of the power of attorney',//
    'enter_company_name'=>'Please enter the full name of the enterprise.',//
    'enter_card_reverse'=>'Please upload the reverse of your ID card.',//
    'enter_card_front'=>'Please upload the front of your ID card.',//
    'enter_real_name'=>'Please enter your real name.',//
    'set_pay_password_success'=>'Setting Payment Password Successfully',//
    'passed_real_name_cannot_cancel'=>'Enterprise users who have been authenticated by their real names cannot cancel their accounts',//
    'user_logout_success'=>'Cancellation success!',//
    'user_logout_fail'=>'Cancellation failed! Please contact the administrator.',//

    //购物车
    'join_cart_success'=>'Join the shopping cart successfully',//
    'cart_goods_not_exist'=>'Shopping cart merchandise does not exist!',//
    'quote_info_not_exist'=>'Quotation information does not exist!',//!
    'cannot_add_cart_tips'=>'The number of goods is zero and cannot be added to the shopping cart.',//
    'quote_expired'=>'The quotation has expired',//
    'goods_info_not_exist'=>'Commodity information does not exist',//
    'not_greater_inventory'=>'Not greater than inventory',//
    'goods_cannot_reduced'=>'This commodity cannot be reduced.',//
    'num_is_positive_int'=>'Quantity can only be entered in positive integers',//
    'num_not_less_spec'=>'Quantity should not be less than commodity specifications',//
    'num_wrong_tips'=>'The quantity is wrong. Please re-enter it.',//
];
