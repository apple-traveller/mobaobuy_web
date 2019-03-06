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
    'clear_goods_not_exist'=>'清仓商品不存在!',//Clearance commodities do not exist
    'promote_goods_not_exist'=>'促销商品不存在!',//Promotional commodities do not exist
    'collect_goods_not_exist'=>'集采商品不存在!',//Collection commodities do not exist
    'goods_not_exist'=>'商品不存在!',//Commodity does not exist
    'insufficient_stock_tips'=>'库存不足,无法下单!',//Insufficient stock to place orders
    'goods_info_tips'=>'商品信息有误!',//Commodity information is incorrect
    'beyond_maximum'=>'超出最大限量!',//Beyond the Maximum
    'only_enterprise_users_tips'=>'抢购只能是企业用户下单!',//Buy-up can only be ordered by enterprise users
    'no_right_place_tips'=>'您没有权限为该企业下单!',//You have no right to place an order for the enterprise.
    'activity_over_tips'=>'该活动已结束!',//The event is over.
    'no_less_num_tips'=>'不能低于起售数量!',//No less than the starting quantity
    'user_info_error_tips'=>'用户信息有误!',//Error in User Information
    'contact_info_cannot_empty_tips'=>'联系方式不能为空!',//Contact information can not be empty!
    'mobile_error_tips'=>'手机号码有误!',//The mobile phone number is wrong!
    'need_content_cannot_empty_tips'=>'需求内容不能为空!',//Need content can not be empty!
    'wait_service_contact_tips'=>'需求信息提交成功，请耐心等待客服联系!',//Requirement information submitted successfully, please wait patiently for customer service contact!
    'no_right'=>'无权访问',//No right to visit
    'illegal_visits'=>'非法访问',//Illegal visits
    'unable_get_id'=>'无法获取参数ID',//Unable to get parameter ID
    'cat_not_found_tips'=>'找不到对应的分类',//No corresponding classification was found.
    'out_stock_num_error_tips'=>'出库数量不能大于库存数量',//The quantity out of warehouse should not be greater than the quantity in stock.
    'no_out_stock_info'=>'没有对应的出入库信息',//No corresponding access information
    'not_have_func_tips'=>'个人会员并无此功能',//Individual membership does not have this function
    'bound_enterprise_tips'=>'用户已经绑定过本企业了!',//Users have been bound to the enterprise
    'user_not_found'=>'未找到该用户!',//The user was not found
    'enterprise_not_exist'=>'企业用户不存在!',//Enterprise users do not exist
    'user_not_exist'=>'用户不存在!',//User does not exist
    'user_unbound_enterprise'=>'用户未绑定企业!',//User Unbound Enterprise
    'enterprise_cannot_add'=>'企业账户不能被添加!',//Enterprise accounts cannot be added!
    'shop_info_not_exist'=>'商家信息不存在',//Business information does not exist
    'order_info_not_exist'=>'订单信息不存在',//Order information does not exist
    'cat_cannot_delete'=>'该分类下有商品不能删除',//Goods under this category cannot be deleted
    'the'=>'第',//
    'week'=>'周',//week
    'no_brand'=>'无品牌',//No brand
    'no_have_right_apply_invoice'=>'您没有申请开票的权限',//You have no right to apply for an invoice.
    'invoice_info_not_exist'=>'该开票信息不存在',//The invoice information does not exist
    'network_error'=>'网络错误',//network error
    'select_order_tips'=>'请选择订单',//Please select the order
    'no_real_name_tips'=>'您还没有实名认证，不能申请发票',//You can't apply for invoice because you haven't got real-name certification yet.
    'real_name_no_pass_tips'=>'您的实名认证还未通过，不能申请发票',//Your real-name certification has not been passed and you cannot apply for invoices.
    'lack_address_id'=>'缺少地址ID！',//Lack of address ID!
    'address_info_not_exist'=>'地址信息不存在！',//Address information does not exist!
    'select_success'=>'选择成功',//Successful selection
    'lack_invoice_type_parameter'=>'缺少开票类型参数！',//Lack of invoice type parameters!
    'not_meet_special_invoice_tips'=>'您不符合开增值专用发票的条件',//You do not meet the requirements for issuing special value-added invoices
    'miss_parameter'=>'缺少参数',//Missing parameters
    'apply_success'=>'申请成功',//Successful application
    'apply_error'=>'申请失败',//Application failure
    'user_name_cannot_empty'=>'用户名不能为空',//User name cannot be empty
    'password_cannot_empty'=>'密码不能为空',//Password cannot be empty
    'login_success'=>'登录成功，正在进入系统...',//The login is successful and is entering the system.
    'bind_account'=>'账号绑定',//Bind on Account
    'user_name_and_password_param_error'=>'用户名或密码参数错误！',//Error in username or password parameters!
    'bind_failed'=>'绑定失败！请联系客服处理。',//Binding failed! Please contact customer service.
    'user_name_and_password_error'=>'用户名或密码不正确！',//Incorrect username or password!
    'need_audit_can_login_tips'=>'账号需待审核通过后才可登录！',//Accounts need to be audited before they can log in!
    'mobile_registered'=>'手机号已经注册',//Mobile phone number has been registered
    'enterprises_frozen'=>'企业已被冻结',//Enterprises have been frozen
    'business_name_error_tips'=>'企业名称不对或已被注册',//Incorrect business name or registered
    'mobile_verification_error'=>'手机验证码不正确',//The mobile phone verification code is incorrect
    'sub_success'=>'提交成功，请等待审核！',//Successful submission, please wait for review!
    'register_failed'=>'注册失败！',//Registration failed!
    'nothing'=>'没有了哦',//nothing
    'upload_success'=>'上传成功！',//Upload success!
    'order_detail_error'=>'订单详情有误!',//The order details are incorrect!
    'audit_success'=>'审核成功',//Audit success
    'cancel_success'=>'取消成功',//Cancellation of success
    'no_real_name_no_order_tips'=>'您还没有实名认证，不能下单',//
    'real_name_no_pass_no_order_tips'=>'您的实名认证还未通过，不能下单',//
    'no_address_info'=>'无地址信息请前去维护',//No address information, please go ahead and maintain it.
    'select_address'=>'请选择收货地址',//Please choose the receiving address.
    'sub_order_success'=>'订单提交成功',//Successful submission of orders
    'sub_order_error'=>'订单提交失败',//Failure of order submission
    'param_error'=>'参数错误',//Parameter error
    'expired_goods'=>'存在已过期商品',//There are expired commercial
    'no_order'=>'不能下单',//No order.
    'upload_resume_cannot_empty'=>'上传简历不能为空',//Upload resume can not be empty
    'inquire_info_error'=>'求购信息有误',//Error in Purchasing Information
    'quote_price_cannot_empty'=>'报价价格不能为空',//The quotation price cannot be empty
    'quote_num_cannot_empty'=>'报价数量不能为空',//Quotations cannot be empty
    'delivery_area_cannot_empty'=>'交货地不能为空',//The place of delivery cannot be empty
    'verification_success'=>'验证成功！',//Verification success!
    'user_not_real_name'=>'该用户未实名认证！',//This user is not authenticated by real name!

    'graphic_verify_error'=>'图形验证有误',//Graphic Verification Error
    'register_success'=>'注册成功！',//
    'logout_success'=>'退出登录成功',//Log out successfully
    'choose_address'=>'请选择地址',//Please choose the address.
    'enter_address_detail'=>'请输入详细地址',//Please enter the detailed address
    'enter_consignee'=>'请输入收货人',//Please enter the consignee
    'enter_mobile'=>'请输入收货电话',//Please enter the receiving phone number.
    'edit_success'=>'修改成功',//Modified success
    'add_address_success'=>'添加收获地址成功',//Added Harvest Address Successfully
    'delete_success'=>'删除成功',//Successful deletion
    'delete_failed'=>'删除失败',//Delete failed
    'success'=>'成功',//Success
    'fail'=>'失败',//Fail
    'fill_title'=>'请填写公司抬头',//Please fill in the company's name
    'fill_tax_number'=>'请填写税号',//Please fill in the tax number.
    'fill_open_bank'=>'请填写开户银行',//Please fill in the opening bank.
    'fill_bank_account'=>'请填写银行账号',//Please fill in the bank account
    'add_real_name_success'=>'实名信息添加成功，等待审核...',//Real name information was added successfully, waiting for audit.
    'mobile_not_register'=>'手机号未注册',//Mobile phone number not registered
    'collected'=>'已收藏过此商品！',//This commodity has been collected!
    'passed_real_name_can_order'=>'实名认证通过后才能下单',//The order can not be placed until the real-name certification has been passed.
    'mail_format_error'=>'邮箱格式有误!',//The mailbox format is incorrect!
    'process_unapproved_order'=>'请先处理未审批的订单',//Please process the unapproved order first.
    'illegal_operation'=>'非法操作',//Illegal operation
    'upload_electronic_license'=>'请上传营业执照电子版',//Please upload the electronic version of the business license.
    'upload_electronic_attorney'=>'请上传开票资料电子版',//Please upload the electronic version of invoice information.
    'upload_electronic_invoice'=>'请上传授权委托书电子版',//Please upload the electronic version of the power of attorney
    'enter_company_name'=>'请输入企业全称',//Please enter the full name of the enterprise.
    'enter_card_reverse'=>'请上传身份证反面',//Please upload the reverse of your ID card.
    'enter_card_front'=>'请上传身份证正面',//Please upload the front of your ID card.
    'enter_real_name'=>'请输入真实姓名',//Please enter your real name.
    'set_pay_password_success'=>'设置支付密码成功',//Setting Payment Password Successfully
    'passed_real_name_cannot_cancel'=>'已经实名认证的企业用户不能注销账号',//Enterprise users who have been authenticated by their real names cannot cancel their accounts
    'user_logout_success'=>'注销成功！',//Cancellation success!
    'user_logout_fail'=>'注销失败！请联系管理员。',//Cancellation failed! Please contact the administrator.
];
