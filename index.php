<?php
require __DIR__ . '/public/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
// Load config and all controllers
require_once('app/controllers/db_controller.php');
require_once('app/controllers/view_controller.php');
require_once('app/controllers/core_controller.php');
require_once('app/models/core_model.php');
require_once('app/models/user_model.php');

// Initialize database and get root URL
$db = (new DBController())->connect();
$rootUrl = (new CoreModel($db))->getCurrentUrl();
$viewController = new ViewController($rootUrl,$db);
$coreController = new CoreController($db);


// Base directory configuration
$baseDir = '/orchidbackery';  // Base directory where your app is located
$url = str_replace($baseDir, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Helper function to handle route matching
function matchRoute($pattern, $url)
{
    // Simple exact match for now
    return $pattern === $url;
}

// Define routes in a more structured way
$routes = [
    // GET Routes (Page Views)
    'GET' => [
        // Home & Auth Pages
        '/login' => fn() => $viewController->showLoginPage($rootUrl),
        '/register' => fn() => $viewController->showRegistrationPage($rootUrl),
        '/dashboard' => fn() => $viewController->showDashboardPage($rootUrl),
        '/profile' => fn() => $viewController->showProfilePage($rootUrl),
        '/activate_account' => fn() => $viewController->showAccountActivationPage($rootUrl),
        '/transaction_history' => fn() => $viewController->showTransactionHistoryPage($rootUrl),
        '/partners' => fn() => $viewController->showOurPartnersPage($rootUrl),
        '/logout' => fn() => $coreController->logoutUser(),
        '/redeem' => fn() => $viewController->showRedeemPointsPage($rootUrl),
        '/manage_users' => fn() => $viewController->showManageUsersPage($rootUrl),
        '/manage_partners' => fn() => $viewController->showManagePartnersPage($rootUrl),
        '/point_configuration' => fn() => $viewController->showPointConfigurationPage($rootUrl),
        '/code_redemption' => fn() => $viewController->showCodeRedemptionPage($rootUrl),
        '/404' => fn() => $viewController->show404Page($rootUrl),
        '/activity_logs' => fn() => $viewController->showActivityLogsPage($rootUrl),
        '/withdrawal_requests' => fn() => $viewController->showWithdrawalTransactionsPage($rootUrl),
        '/point_award' => fn() => $viewController->showPointAwardPage($rootUrl),
        '/control_access' => fn() => $viewController->showControlAccessPage($rootUrl),
        '/forgot_password' => fn() => $viewController->showForgotPasswordPage($rootUrl),
    ],

    // POST Routes (API/Actions)
    'POST' => [
        '/register' => fn() => $coreController->registerUser(),
        '/activateAccount' => fn() => $coreController->activateAccount(),
        '/login' => fn() => $coreController->loginUser(),
        '/fetchprofileInfo' => fn() => $coreController->fetchProfileInfo(),
        '/logout' => fn() => $coreController->logoutUser(),
        '/updateprofile' => fn() => $coreController->updateProfile(),
        '/changepassword' => fn() => $coreController->changePassword(),
        '/fetchtransactionshistory' => fn() => $coreController->fetchUserTransactionHistory(),
        '/getexchangeRate' => fn() => $coreController->fetchExchangeRates(),
        '/fetchallusers' => fn() => $coreController->fetchAllUsers(),
        '/fetchallpartners' => fn() => $coreController->fetchAllPartners(),
        '/addpartner' => fn() => $coreController->createPartnerAccount(),
        '/get_user_info' => fn() => $coreController->fetchUserInfo(),
        '/delete_user' => fn() => $coreController->processUserDeletion(),
        '/update_partner' => fn() => $coreController->updatePartnerAccount(),
        '/update_account_status' => fn() => $coreController->updateAccountStatus(),
        '/adjust_partner_balance' => fn() => $coreController->adjustPartnerWallet(),
        '/update_user' => fn() => $coreController->updateUserAccount(),
        '/update_system_settings' => fn() => $coreController->updatePointConfiguration(),
        '/update_partner_logo' => fn() => $coreController->updatePartnerLogo(),
        '/validate_redemption_code' => fn() => $coreController->validateRedemptionCode(),
        '/fetch_activity_logs' => fn() => $coreController->fetchAdminLogs(),
        '/fetch_withdrawal_requests' => fn() => $coreController->fetchWithdrawalRequests(),
        '/process_point_award' => fn() => $coreController->pointAwardRequest(),
        '/fetch_admins_with_permissions' => fn() => $coreController->getAdminsWithPermissions(),
        '/update_role_permissions' => fn() => $coreController->rolePermissionUpdate(),
        '/forgot_code_verification' => fn() => $coreController->forgotPasswordCodeVerficationRequest(),
        '/forgot_email_verification' => fn() => $coreController->forgotEmailVerificationRequest(),
        '/forgot_password_reset' => fn() => $coreController->forgotPasswordResetRequest(),
        '/redeem_code' => fn() => $coreController->redeemCode(),
        '/process_code_redemption' => fn() => $coreController->partnerCodeRedemption(),

    ]
];

// Handle the request
try {
    // Check if route exists for current method and URL
    if (isset($routes[$requestMethod]) && isset($routes[$requestMethod][$url])) {
        $handler = $routes[$requestMethod][$url];
        $handler();
    } else {
        // Handle 404 - Page not found
        http_response_code(404);
        //echo 'Page not found';

        // You could also log this or redirect to a custom 404 page
        // error_log("404 - Route not found: $requestMethod $url");
         header("Location: 404");
    }
} catch (Exception $e) {
    // Handle exceptions
    http_response_code(500);
    echo 'An error occurred: ' . $e->getMessage();

    // Log the error
    error_log("Route handler error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
}