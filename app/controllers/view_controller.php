<?php

class ViewController
{
    private $coreModel, $db;

    public function __construct($root, $db)
    {
        $this->db = $db;
        $this->coreModel = new CoreModel($this->db);
    }
    public function showLoginPage($root)
    {
        $metaData = [
            'title' => 'Orchid Bakery - Login',
            'description' => 'Login to the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Login, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'index, follow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];

        $metaTags = $this->coreModel->metaTags($metaData);
        require_once 'app/views/login.php';
    }

    public function showForgotPasswordPage($root)
    {
        $metaData = [
            'title' => 'Orchid Bakery - Forgot Password',
            'description' => 'Reset your password for the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Forgot Password, Reset Password, Loyalty Portal',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];

        $metaTags = $this->coreModel->metaTags($metaData);
        require_once 'app/views/forgot_password.php';
    }

    public function showRegistrationPage($root)
    {
        $metaData = [
            'title' => 'Orchid Bakery - Register',
            'description' => 'Register for the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Register, Sign Up, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'index, follow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];

        $metaTags = $this->coreModel->metaTags($metaData);
        require_once 'app/views/registration.php';
    }

    public function showDashboardPage($root)
    {
        $metaData = [
            'title' => 'Orchid Bakery - Dashboard',
            'description' => 'Your dashboard for the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Dashboard, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];

        $MetaTagsAdmin = [
            'title' => 'Orchid Bakery - Admin Dashboard',
            'description' => 'Admin dashboard for the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Admin Dashboard, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];

        $metaTags = $this->coreModel->metaTags($metaData);
        $adminMetaTags = $this->coreModel->metaTags($MetaTagsAdmin);
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['orchid_session']) || empty($_SESSION['orchid_session'])){
            header("Location: " . $root . "/login");
            exit();
        }
        $email = $_SESSION['orchid_session'];
        $fetchuserdetails = $this->coreModel->fetchUserData($email);
        $initials = $this->coreModel->getInitials($fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name']);
        $tier = $this->coreModel->getUserTier($fetchuserdetails['points_balance']);
        $allpartners = $this->coreModel->fetchAllPartners();
        $summary = $this->coreModel->getTransactionSummary($fetchuserdetails['id'], 'month');
        $fetchtransactions = $this->coreModel->getUserTransactions($fetchuserdetails['id'], 0, 5);

        //Admin stats
        $userStats = $this->coreModel->getUserRegistrationStats();
        $pointsStats = $this->coreModel->getPointsRedemptionStats('week'); // Use 'month' for monthly comparison
        $partnerStats = $this->coreModel->getActivePartnersStats();
        $withdrawalStats = $this->coreModel->getPendingWithdrawalsStats();
        $currentPointStats = $this->coreModel->formatPointsForDisplay($pointsStats['current']);
        $partnersStat = $this->coreModel->getPartnerStats($fetchuserdetails['id']);
        $recentRedemptions = [];
        $fetchexchangerate = $this->coreModel->fetchRate('redeem_points_rate');
        $recentRegistrations = $this->coreModel->fetchRecentRegistrations();
        $recentActivity = $this->coreModel->fetchRecentActivity();
        switch($fetchuserdetails['acct_type']){
            case 'admin':
                require_once 'app/views/admin/dashboard.php';
                break;
            case 'partner':
                require_once 'app/views/partners/dashboard.php';
                break;
            default:
                require_once 'app/views/dashboard.php';
                break;
        }
        
    }

    public function showProfilePage($root)
    {
        $metaData = [
            'title' => 'Orchid Bakery - Profile',
            'description' => 'Your profile page for the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Profile, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];

        $metaTags = $this->coreModel->metaTags($metaData);
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['orchid_session']) || empty($_SESSION['orchid_session'])){
            header("Location: " . $root . "/login");
            exit();
        }
        $email = $_SESSION['orchid_session'];
        $fetchuserdetails = $this->coreModel->fetchUserData($email);
        $initials = $this->coreModel->getInitials($fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name']);
        $tier = $this->coreModel->getUserTier($fetchuserdetails['points_balance']);
        $allpartners = $this->coreModel->fetchAllPartners();
        switch($fetchuserdetails['acct_type']){
            case 'admin':
                require_once 'app/views/admin/profile.php';
                break;
            case 'partner':
                require_once 'app/views/partners/profile.php';
                break;
            default:
                require_once 'app/views/profile.php';
                break;
        }
    }

    public function showAccountActivationPage($root)
    {
        $metaData = [
            'title' => 'Orchid Bakery - Account Activation',
            'description' => 'Activate your account for the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Account Activation, Activate Account, Loyalty Portal',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];

        $metaTags = $this->coreModel->metaTags($metaData);
        require_once 'app/views/account_activation.php';
    }

    public function showTransactionHistoryPage($root)
    {
        $metaData = [
            'title' => 'Orchid Bakery - Transaction History',
            'description' => 'View your transaction history in the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Transaction History, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];

        $metaTags = $this->coreModel->metaTags($metaData);
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['orchid_session']) || empty($_SESSION['orchid_session'])){
            header("Location: login");
            exit();
        }
        $email = $_SESSION['orchid_session'];
        $fetchuserdetails = $this->coreModel->fetchUserData($email);
        $initials = $this->coreModel->getInitials($fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name']);
        $tier = $this->coreModel->getUserTier($fetchuserdetails['points_balance']);
        $allpartners = $this->coreModel->fetchAllPartners();
        if($fetchuserdetails['acct_type'] !== 'user'){
            header("Location: 404");
        }
        require_once 'app/views/trans_history.php';
    }

    public function showOurPartnersPage($root)
    {
        $metaData = [
            'title' => 'Orchid Bakery - Our Partners',
            'description' => 'Explore our partners in the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Our Partners, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'index, follow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];

        $metaTags = $this->coreModel->metaTags($metaData);
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['orchid_session']) || empty($_SESSION['orchid_session'])){
            header("Location: " . $root . "/login");
            exit();
        }
        $email = $_SESSION['orchid_session'];
        $fetchuserdetails = $this->coreModel->fetchUserData($email);
        $initials = $this->coreModel->getInitials($fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name']);
        $tier = $this->coreModel->getUserTier($fetchuserdetails['points_balance']);
        $allpartners = $this->coreModel->fetchAllPartners();
        if($fetchuserdetails['acct_type'] !== 'user'){
            header("Location: 404");
        }
        require_once 'app/views/our_partners.php';
    }

    public function showRedeemPointsPage($root)
    {
        $metaData = [
            'title' => 'Orchid Bakery - Redeem Points',
            'description' => 'Redeem your points in the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Redeem Points, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'index, follow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];

        $metaTags = $this->coreModel->metaTags($metaData);
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['orchid_session']) || empty($_SESSION['orchid_session'])){
            header("Location: " . $root . "/login");
            exit();
        }
        $email = $_SESSION['orchid_session'];
        $fetchuserdetails = $this->coreModel->fetchUserData($email);
        $initials = $this->coreModel->getInitials($fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name']);
        $tier = $this->coreModel->getUserTier($fetchuserdetails['points_balance']);
        $allpartners = $this->coreModel->fetchAllPartners();
        if($fetchuserdetails['acct_type'] !== 'user'){
            header("Location: 404");
        }
        require_once 'app/views/redeem_points.php';
    }

    public function showManageUsersPage($root)
    {
        $metaData = [
            'title' => 'Orchid Bakery - Manage Users',
            'description' => 'Manage users in the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Manage Users, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];

        $metaTags = $this->coreModel->metaTags($metaData);
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['orchid_session']) || empty($_SESSION['orchid_session'])){
            header("Location: " . $root . "/login");
            exit();
        }
        $email = $_SESSION['orchid_session'];
        $fetchuserdetails = $this->coreModel->fetchUserData($email);
        $initials = $this->coreModel->getInitials($fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name']);
        $tier = $this->coreModel->getUserTier($fetchuserdetails['points_balance']);
        $allpartners = $this->coreModel->fetchAllPartners();
        $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'users.view');

        if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
            header("Location: " . "404");
        }

        require_once 'app/views/admin/manage_users.php';
    }

    public function showManagePartnersPage($root)
    {
        $metaData = [
            'title' => 'Orchid Bakery - Manage Partners',
            'description' => 'Manage partners in the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Manage Partners, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];

        $metaTags = $this->coreModel->metaTags($metaData);
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['orchid_session']) || empty($_SESSION['orchid_session'])){
            header("Location: " . $root . "/login");
            exit();
        }
        $email = $_SESSION['orchid_session'];
        $fetchuserdetails = $this->coreModel->fetchUserData($email);
        $initials = $this->coreModel->getInitials($fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name']);
        $tier = $this->coreModel->getUserTier($fetchuserdetails['points_balance']);
        $allpartners = $this->coreModel->fetchAllPartners();
        $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'partners.view');
        if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
            header("Location: " . "404");
        }
        require_once 'app/views/admin/manage_partners.php';
    }

    public function show404Page($root)
    {
        $metaData = [
            'title' => 'Orchid Bakery - Page Not Found',
            'description' => 'The page you are looking for does not exist in the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, 404, Page Not Found, Loyalty Portal',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];

        $metaTags = $this->coreModel->metaTags($metaData);
        require_once 'app/views/404.php';
    }

    public function showPointConfigurationPage($root){
        $metaData = [
            'title' => 'Orchid Bakery - Point Configuration',
            'description' => 'Configure points in the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Point Configuration, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];
        $metaTags = $this->coreModel->metaTags($metaData);
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['orchid_session']) || empty($_SESSION['orchid_session'])){
            header("Location: " . $root . "/login");
            exit();
        }
        $email = $_SESSION['orchid_session'];
        $fetchuserdetails = $this->coreModel->fetchUserData($email);
        $initials = $this->coreModel->getInitials($fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name']);
        $tier = $this->coreModel->getUserTier($fetchuserdetails['points_balance']);
        $allpartners = $this->coreModel->fetchAllPartners();
        $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'settings.points_rate');
        if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
            header("Location: " . "404");
        }
        require_once 'app/views/admin/points_configuration.php';
    }

    public function showCodeRedemptionPage($root){
        $metaData = [
            'title' => 'Orchid Bakery - Code Redemption',
            'description' => 'Redeem codes in the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Code Redemption, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];
        $metaTags = $this->coreModel->metaTags($metaData);
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['orchid_session']) || empty($_SESSION['orchid_session'])){
            header("Location: " . $root . "/login");
            exit();
        }
        $email = $_SESSION['orchid_session'];
        $fetchuserdetails = $this->coreModel->fetchUserData($email);
        $initials = $this->coreModel->getInitials($fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name']);
        $tier = $this->coreModel->getUserTier($fetchuserdetails['points_balance']);
        $allpartners = $this->coreModel->fetchAllPartners();
        if($fetchuserdetails['acct_type'] !== 'partner'){
            header("Location: 404");
        }
        require_once 'app/views/partners/code_redemption.php';
    }

    public function showActivityLogsPage($root){
        $metaData = [
            'title' => 'Orchid Bakery - Activity Logs',
            'description' => 'View activity logs in the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Activity Logs, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];
        $metaTags = $this->coreModel->metaTags($metaData);
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['orchid_session']) || empty($_SESSION['orchid_session'])){
            header("Location: " . $root . "/login");
            exit();
        }
        $email = $_SESSION['orchid_session'];
        $fetchuserdetails = $this->coreModel->fetchUserData($email);
        $initials = $this->coreModel->getInitials($fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name']);
        $tier = $this->coreModel->getUserTier($fetchuserdetails['points_balance']);
        $allpartners = $this->coreModel->fetchAllPartners();
        $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'activity.views');
        if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
            header("Location: " . "404");
        }
        require_once 'app/views/admin/activity_logs.php';
    }

    public function showWithdrawalTransactionsPage($root){
        $metaData = [
            'title' => 'Orchid Bakery - Withdrawal Transactions',
            'description' => 'View withdrawal transactions in the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Withdrawal Transactions, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];
        $metaTags = $this->coreModel->metaTags($metaData);
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['orchid_session']) || empty($_SESSION['orchid_session'])){
            header("Location: " . $root . "/login");
            exit();
        }

        $email = $_SESSION['orchid_session'];
        $fetchuserdetails = $this->coreModel->fetchUserData($email);
        $initials = $this->coreModel->getInitials($fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name']);
        $tier = $this->coreModel->getUserTier($fetchuserdetails['points_balance']);
        $allpartners = $this->coreModel->fetchAllPartners();
        $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'withdrawals.view');
        if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
            header("Location: " . "404");
        }
        require_once 'app/views/admin/withdrawal_request.php';
    }

    public function showPointAwardPage($root){
        $metaData = [
            'title' => 'Orchid Bakery - Point Award',
            'description' => 'View point award in the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Point Award, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];
        $metaTags = $this->coreModel->metaTags($metaData);
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['orchid_session']) || empty($_SESSION['orchid_session'])){
            header("Location: " . $root . "/login");
            exit();
        }
        $email = $_SESSION['orchid_session'];
        $fetchuserdetails = $this->coreModel->fetchUserData($email);
        $initials = $this->coreModel->getInitials($fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name']);
        $tier = $this->coreModel->getUserTier($fetchuserdetails['points_balance']);
        $allpartners = $this->coreModel->fetchAllPartners();
        $awardStats = $this->coreModel->pointAwardsStats();
        $rates = $this->coreModel->fetchRate('redemption_point_rate');
        $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'points.view');
        if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
            header("Location: " . "404");
        }
        require_once 'app/views/admin/point_award.php';
    }

    public function showControlAccessPage($root){
        $metaData = [
            'title' => 'Orchid Bakery - Control Access',
            'description' => 'View control access in the Orchid Bakery Loyalty & Rewards Portal',
            'keywords' => 'Orchid Bakery, Control Access, Loyalty Portal, Rewards',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'robots' => 'noindex, nofollow',
            'image' => $this->coreModel->getCurrentUrl() . '/public/logo/logo.png',
            'author' => 'Orchid Bakery',
            'canonical' => $this->coreModel->getCurrentUrl()
        ];
        $metaTags = $this->coreModel->metaTags($metaData);
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if(!isset($_SESSION['orchid_session']) || empty($_SESSION['orchid_session'])){
            header("Location: " . "login");
            exit();
        }
        $email = $_SESSION['orchid_session'];
        $fetchuserdetails = $this->coreModel->fetchUserData($email);
        $initials = $this->coreModel->getInitials($fetchuserdetails['first_name'] . ' ' . $fetchuserdetails['last_name']);
        $tier = $this->coreModel->getUserTier($fetchuserdetails['points_balance']);
        $allpartners = $this->coreModel->fetchAllPartners();
        $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'admins.view');
        if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
            header("Location: " . "404");
        }
        require_once 'app/views/admin/control_access.php';
    }

    

}
