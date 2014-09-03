<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

/* --------------  admin side route -------------------- */
/* admin login, dashboard and forgot password */
$route['backend'] = "admin/index";
$route['backend/login'] = "admin/index";
$route['backend/index'] = "admin/index";
$route['backend/home'] = "admin/home";
$route['backend/dashboard'] = "admin/home";
$route['backend/log-out'] = "admin/logout";
$route['backend/forgot-password'] = "admin/forgotPassword";
$route['backend/forgot-password-email'] = "admin/checkForgotPasswordEmail";
/* 5 feb */
$route['backend/reset-admin-password/([0-9]+)'] = "admin/resetAdminPassword/$1";
$route['backend/reset-admin-password-action'] = "admin/resetAdminPasswordAction";

/* admin login, dashboard and forgot password end here */

/* Global Settings:   */
$route['backend/global-settings/list'] = "global_setting/listGlobalSettings";
$route['backend/global-settings/edit/(:any)'] = "global_setting/editGlobalSettings/$1/$2";
$route['backend/global-settings/edit-parameter-language/(:any)'] = "global_setting/editParameterLanguage/$1";
$route['backend/global-settings/get-global-parameter-language'] = "global_setting/getGlobalParameterLanguage";
/* Global Settings End Here */

/* Manage Role: */
$route['backend/role/list'] = "role/listRole";
$route['backend/role/edit/(:any)'] = "role/addRole/$1";
$route['backend/role/add'] = "role/addRole";
$route['backend/role/check-role'] = "role/checkRole";

/* Manage Role End Here */

/* Manage Admin  */
$route['backend/admin/list'] = "admin/listAdmin";
$route['backend/admin/change-status'] = "admin/changeStatus";
$route['backend/admin/add'] = "admin/addAdmin";
$route['backend/admin/check-admin-username'] = "admin/checkAdminUsername";
$route['backend/admin/check-admin-email'] = "admin/checkAdminEmail";
$route['backend/admin/account-activate/(:any)'] = "admin/activateAccount/$1";
$route['backend/admin/edit/(:any)'] = "admin/editAdmin/$1";
$route['backend/admin/profile'] = "admin/adminProfile";
/* 27 feb edit subadmin */
$route['backend/admin/edit-profile'] = "admin/editProfile";
/* Manage Admin End Here */

/* Manage email template routes */
$route['backend/email-template/list'] = "email_template/index";
$route['backend/edit-email-template/(:any)'] = "email_template/editEmailTemplate/$1";
/* Manage email template routes */

/* Start : Manage currency */
$route['backend/currency/list'] = "currency/index";
$route['backend/currency/edit-currency/([0-9]+)'] = "currency/editCurrency/$1";
$route['backend/currency/edit-currency'] = "currency/editCurrency";
$route['backend/currency/add-currency'] = "currency/addCurrency";
/* end :manage currency */

/* Start : Manage payment methods */
$route['backend/payment-method/list'] = "payment_method/getPaymentMethodList";
$route['backend/payment-method/change-status'] = "payment_method/changePaymentStatus";
$route['backend/payment-method/add'] = "payment_method/addPaymentMethod";
$route['backend/payment-method/edit/(:any)'] = "payment_method/editPaymentMethod/$1";
$route['backend/payment-unique-uri'] = "payment_method/checkUniqueMethodUrl";


/* Testimonial Routs backend */
$route['backend/testimonial/list'] = "testimonial/listTestimonial";
$route['backend/testimonial/change-status'] = "testimonial/changeStatus";
$route['backend/testimonial/add/(:any)'] = "testimonial/addTestimonial/$1";
$route['backend/testimonial/add'] = "testimonial/addTestimonial";
/* Testimonial Routs bacend end here */

/* Manage User Start Here */
$route['backend/user/list'] = "user/listUser";
$route['backend/user/log-list'] = "user/log_list";
$route['backend/user/deletion-list'] = "user/deletion_list";
$route['backend/user/change-status'] = "user/changeStatus";
$route['backend/user/add'] = "user/addUser";
$route['backend/user/check-user-username'] = "user/checkUserUsername";
$route['backend/user/check-user-email'] = "user/checkUserEmail";
$route['backend/user/account-activate/(:any)'] = "user/activateAccount/$1";
$route['backend/user/edit/(:any)'] = "user/editUser/$1";
$route['backend/user/view/(:any)'] = "user/userProfile/$1";
$route['backend/user/view-request/(:any)'] = "user/userViewRequest/$1";
$route['backend/user/deactivate'] = "user/deactivateUser";
/* Manage User End Here */

/* Manage trusted people start here */
$route['backend/accounts/trusted'] = "trusted_contacts/trusted_to";
$route['backend/accounts/trusted/ads'] = "trusted_contacts/trusted_ads";
/* Manage trusted people end here */

/* Manage advertise start here */
$route['backend/advertise'] = "advertise/list_advertisement";
$route['backend/advertise/add'] = "advertise/add_advertisement";
$route['backend/advertise/add-action'] = "advertise/add_advertisement_action";
$route['backend/advertise/edit/(:any)'] = "advertise/edit_advertisement/$1";
$route['backend/advertise/edit-action'] = "advertise/edit_advertisement_action";
$route['backend/advertise/trade-requests-list'] = "advertise/trade_requests_list";
$route['backend/advertise/ajax-change-trade-status'] = "advertise/change_trade_status";
/* Manage advertise end here */


/* Manage Forum section start here */
$route['backend/forum-categories'] = "forum/getForumCategoryList";
$route['backend/forum-category-edit/(:any)'] = "forum/editForumCategory/$1";
$route['backend/forum-category-edit'] = "forum/editForumCategory/$1";
$route['backend/forum-add-category'] = "forum/addForumCategory";

$route['backend/forum-unique-uri'] = "forum/checkUniqueUrl";
$route['backend/forum-category-edit-multilingual/(:any)'] = "forum/multilingualForumCategory/$1";

$route['backend/forum-list'] = "forum/getAllForumTopicsList";
$route['backend/forum-topic-comments/(:any)'] = "forum/getAllForumTopicsList/$1";
$route['backend/forum-topic-status/(:any)'] = "forum/changeForumTopicStatus/$1/$2";

$route['backend/forum-topic-edit/(:any)'] = "forum/editForumTopic/$1";
$route['backend/forum-topic-add'] = "forum/addForumTopic";

$route['backend/wallet-list'] = "wallet/getAllWalletsListForAdmin";
$route['backend/wallet-view/(:any)'] = "wallet/getWalletInfo/$1";


/* Front-end  forum section */
$route['forum/add-comment'] = "forum/add_comment";
$route['forum/discussion-forum'] = "forum_1/discusionForum";
$route['forum/add-forum-topic'] = "forum/add_forum_topic";
$route['forum/edit-forum-topic'] = "forum/edit_forum_topic";
$route['forum/(:any)'] = "forum/index/$1";
/* 22 march */
$route['forum/add-comments'] = "forum/add_comments";
/* 24 march */
$route['forum/add-topic'] = "forum/add_forum_topic_frontend";
/* 25 march */
$route['get-user-feeds'] = 'forum/getUserFeeds';
/* 26 march */
$route['forum/change'] = 'forum/change_avatar_image';
/* 29 march */
$route['load-more-topics'] = 'forum/load_more_topics';

/* Manage Forum section end here */

/* Manage app section start here */
$route['backend/api'] = "user/listApiClients";
$route['backend/apps'] = "user/listApplicationClients";

/* Manage app section end here */

/* --------------  admin side route end here -------------------- */

/* --------------  user module route start here -------------------- */

$route['default_controller'] = "home";

/* Instant bitcoin search start */
$route['instant-bitcoins'] = "home/instantBitcoins";
$route['country'] = "home/changeLocation";

/* Buy bitcoin page */
$route['buy-bitcoins'] = "home/buyBitcoins";
$route['buy-bitcoins-online'] = "home/buyBitcoinsOnline";
$route['buy-bitcoins-online/(:num)'] = "home/buyBitcoinsOnline/$1";
$route['buy-bitcoins-with-cash'] = "home/buyBitcoinsWithCash";
$route['buy-bitcoins-with-cash/(:num)'] = "home/buyBitcoinsWithCash/$1";
$route['lookup-bitcoins/(:any)'] = "home/lookUpBitcoins/$1";
$route['buy-bitcoins-online/(:any)'] = "home/buyBitcoinsOnlinePaymentMethod/$1";

/* Sell bitcoin page */
$route['sell-bitcoins'] = "home/sellBitcoins";
$route['sell-bitcoins-online'] = "home/sellBitcoinsOnline";
$route['sell-bitcoins-online/(:num)'] = "home/sellBitcoinsOnline/$1";
$route['sell-bitcoins-with-cash'] = "home/sellBitcoinsWithCash";
$route['sell-bitcoins-with-cash/(:any)'] = "home/sellBitcoinsWithCash/$1";
$route['sell-bitcoins-online/(:any)'] = "home/sellBitcoinsOnlinePaymentMethod/$1";

/* Wallet creation start here */
$route['wallet'] = "wallet/index";
$route['wallet/new'] = "wallet/requestNewWallet";
$route['user-password-chk'] = "user_account/user_password_chk";
$route['btc-address-chk'] = "wallet/checkAddress";
/* 14 april */
$route['btc-wallet-address-chk'] = "wallet/validateWalletAdress";
$route['btc-wallet-balance-chk'] = "wallet/validateWalletBalance";
$route['send-bitcoin'] = "wallet/send_bitcoins";
$route['wallet-transations-monthly/(:num)/(:num)'] = "wallet/wallet_transactions_monthly/$1/$2";
/* Wallet creation end here */

/* User login and registration section start */
$route['signup'] = "register/userRegistrationOptions";
$route['signupasindividual'] = "register/userRegistrationIndividual";
$route['signupasbusiness'] = "register/userRegistrationBusiness";
$route['signupassupplier'] = "register/userRegistrationSupplier";
$route['signupoptions'] = "register/userRegistrationOptions";
$route['fb-signup'] = "register/fbUserRegistration";
$route['chk-email-duplicate'] = "register/chkEmailDuplicate";
$route['chk-email-exist'] = "register/chkEmailExist";
$route['generate-captcha/(:any)'] = "register/generateCaptcha/$1";
$route['check-captcha'] = "register/checkCaptcha";
$route['chk-username-duplicate'] = "register/chkUserDuplicate";
$route['user-activation/(:any)'] = "register/userActivation/$1";
$route['user-activation/(:any)'] = "register/userActivation/$1";
$route['signin'] = "register/signin";
$route['password-recovery'] = "register/passwordRecovery";
$route['terms-and-conditions/(:any)'] = "register/termsConditions/$1/$2";
/* forgot password 4 feb 14 */
$route['reset-password/([0-9]+)'] = "register/resetPassword/$1";
/* 5 feb */
$route['reset-password-action'] = "register/resetPasswordAction";
/* 25 feb */
$route['resend-verfication-link/([0-9]+)'] = 'register/resendEmailVerficationLink/$1';


/* User login and registration section end */
/* User account section start */
//$route['profile'] = "user_account/profile";
$route['profile/([a-zA-Z0-9_\-\.]+)/feedback/([a-zA-Z]+)'] = "trusted_contacts/userFeedback/$1/$2";
$route['profile/([a-zA-Z0-9_\-\.]+)/(:any)'] = "user_account/userAdsForBuyOrSell/$1/$2/$3";
$route['profile/(:any)'] = "user_account/profile/$1";
//$route['profile/(:any)'] = "user_account/trustprofile/$1";
$route['p/(:any)'] = "user_account/trustprofile/$1";



/* Client api app start here */
$route['apps'] = "user_account/manageApps";
$route['api-token-revoke/(:any)'] = "user_account/revokeToken/$1/$2";
$route['api-token-revoke-all'] = "user_account/revokeTokenAll";
$route['api-client'] = "user_account/createApiClient";
$route['api-client/(:any)'] = "user_account/editApiClient/$1";
$route['api-client-regen/(:any)'] = "user_account/regenerateApiClientSecret/$1";
$route['authorize/(:any)'] = "user_account/authorizeApp/$1";
$route['confirm/(:any)'] = "user_account/authorizeConfirm/$1";


/* Client api app end here */

$route['profile/edit'] = "user_account/edit_profile";
$route['profile/delete'] = "user_account/delete_profile";
$route['profile/delete-request'] = "user_account/delete_request";
$route['chk-edit-email-duplicate'] = "user_account/chkEditEmailDuplicate";
$route['chk-edit-username-duplicate'] = "user_account/chkEditUSernameDuplicate";
$route['profile/account-setting'] = "user_account/account_setting";
$route['profile/edit-user-password-chk'] = "user_account/edit_user_password_chk";
$route['profile/change-profile-picture'] = "user_account/change_profile_picture";
$route['profile/change-profile-picture-action'] = "user_account/change_profile_picture_action";
$route['logout'] = "user_account/logout";

/* trusted people */
$route['trusted-contacts/invite-friend'] = 'trusted_contacts/inviteFriend';
$route['trusted/register/(:any)'] = 'trusted_contacts/trustedRegister/$1';
$route['trusted/feedback/(:any)'] = 'trusted_contacts/trustedFeedback/$1';
$route['trusted/feedbackRequest/(:any)'] = 'trusted_contacts/trustedFeedbackRequest/$1';
$route['trusted-bitcoins'] = 'trusted_contacts/trustedBitcoins';
$route['trusted/feedback/(:any)'] = 'trusted_contacts/trustedFeedback/$1';
$route['trusted/feedback'] = 'trusted_contacts/updateFeedback';
/* frontend :  Advertise or post a trade section start */
$route['advertise'] = "advertise/post_trade";
$route['advertise/add'] = "advertise/post_trade_add";
$route['payment-desc'] = "advertise/getPaymentdescription";
/* 4 march */
$route['advertise-edit/(:any)'] = "advertise/advertise_edit/$1";
$route['advertise-edit-action'] = "advertise/advertise_edit_action";

/* 8 march  start: buy sell bitcoin section */
$route['buy-sell-bitcoin/(:any)'] = 'advertise/buySellBitcoin/$1';
/* 10 mar */
$route['trade-request'] = 'advertise/buySellBitcoin';
/* 8 march  end  : buy sell bitcoin section */

/* 6 march */
$route['ajax-change-currency'] = 'advertise/changeCurrency';
/* 3 march  : dashboard */
$route['user-dashboard/(:any)'] = 'dashboard/userDashboard/$1';
$route['user-dashboard'] = 'dashboard/userDashboard';
$route['ads/active/(:any)'] = 'dashboard/activeContacts/$1';
$route['ads/active'] = 'dashboard/activeContacts';
$route['ads/closed/(:any)'] = 'dashboard/closedContacts/$1';
$route['ads/closed'] = 'dashboard/closedContacts';
$route['ads/released'] = 'dashboard/releasedContacts';
$route['ads/released/(:any)'] = 'dashboard/releasedContacts/$1';
$route['ads/canceled'] = 'dashboard/canceledContacts';
$route['ads/canceled/(:any)'] = 'dashboard/canceledContacts/$1';
$route['ads/detailed-info/(:any)'] = 'dashboard/advertise_detailed_info/$1/$2';
$route['cancel-deal'] = 'dashboard/cancelDeal';
$route['send-reply-to-trade-request'] = 'dashboard/send_reply_to_trade_request';
/* 4 march  : dashboard */
$route['ajax-change-status'] = 'dashboard/changeStatus';
/* 5 april */
$route['dashboard/change-trade-request-status'] = 'dashboard/change_trade_request_status';

/* Contact receipt */
$route['contact-receipt/(:num)'] = 'dashboard/contact_receipt/$1';

/* escrow management */
$route['contact-enable-escrow/(:num)'] = 'dashboard/enableEscrow/$1';
$route['make-escrow-payment'] = 'dashboard/makeEscrowPayment';
$route['make-escrow-release'] = 'dashboard/makeEscrowRelease';

/* Advertise or post a trade section end */
/* Two factor authentication starts here */
//$route['accounts/two-factor'] = "account/two_factor";
//$route['accounts/gridcard'] = "account/generate_gridcard";
//$route['accounts/enable-two-factor-auth-paper'] = "account/enable_two_factor_paper";
//$route['accounts/enable-two-factor-auth-mobile'] = "account/enable_two_factor_mobile";
/* Two factor authentication starts here */
/* start : user edit profile : 3 feb 14 */
$route['profile/change-email'] = 'user_account/changeEmailId';
$route['profile/change-real-name'] = 'user_account/changeRealName';
$route['profile/update-email/(:any)'] = 'user_account/updateUserEmail/$1';
$route['chk-realname-duplicate'] = "user_account/chkUserRealNameDuplicate";
/* end : user edit profile */

/* User account section end */

/* back end cms section */
$route['cms/(:any)'] = "cms/cmsDetails/$1";
$route['backend/cms'] = "cms/listCMS";
$route['backend/cms/edit-cms/(:any)'] = "cms/editCMS/$1";
/* 26 feb */
$route['support-and-contact'] = "cms/supportAndContact";
$route['payment-dispute'] = "cms/paymentDispute";

/* --------------  user module route end here -------------------- */
/* ----------------------strat : front end cms section-------------------------- */
$route['cms/(:any)'] = "cms/getCmsPage/$1/$2";
$route['contact-us'] = "cms/contactUs";
$route['chat'] = "cms/chat";
/* ----------------------end : front end cms section---------------------------- */


/* * **********************************start : payment section******************************************** */

/* 8 april 2014 */
$route['payment/btc-make-payment/(:any)'] = 'payment/btc_make_payment/$1';
$route['payment/btc-make-payment-action'] = 'payment/btc_make_payment_action';

/* * **********************************end : payment section******************************************** */




$route['404_override'] = '';
/* End of file routes.php */
/* Location: ./application/config/routes.php */
