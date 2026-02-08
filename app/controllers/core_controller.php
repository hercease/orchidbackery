<?php
class CoreController {
    private $db, $coreModel, $userModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->coreModel = new CoreModel($db);
        $this->userModel = new UserModel($db);
    }

    public function registerUser(){
        try{

            foreach (['first_name', 'last_name', 'email', 'password', 'phone'] as $field) {
                if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                    throw new Exception("Missing required field: $field");
                }
            }

            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $response = $this->userModel->processRegistration($first_name, $last_name, $email, $password, $phone);

            echo json_encode($response);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
        
    }

    public function loginUser(){
        try{

            foreach (['email', 'password'] as $field) {
                if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                    throw new Exception("Missing required field: $field");
                }
            }

            $email = $_POST['email'];
            $password = $_POST['password'];

            $response = $this->userModel->processLogin($email, $password);

            if (!$response['status']) {
                throw new Exception($response['message']);
            } else {
                // Start session and set user data
                session_start();
                $_SESSION['orchid_session'] = $email;
            }

            echo json_encode($response);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function fetchProfileInfo(){
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        $email = $_SESSION['orchid_session'];
        $response = $this->coreModel->fetchUserData($email);
        echo json_encode($response);
    }

    public function fetchUserInfo(){

        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $id = $_POST['partner_id'];
        $response = $this->coreModel->fetchUser($id);
        $response['total_points_earned'] = $this->coreModel->fetchUserTotalPoints($id);
        $response['status'] = $response ? true : false;
        echo json_encode($response);

    }

    public function logoutUser(){
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        session_unset();
        session_destroy();
        header("Location: login");
        exit();
    }

    public function processUserDeletion(){
        try {
            if (!isset($_POST['id']) || empty(trim($_POST['id']))) {
                throw new Exception("User ID is required.");
            }

            session_start();
            $email = $_SESSION['orchid_session'];
            $fetchuserdetails = $this->coreModel->fetchUserData($email);
            if (!$fetchuserdetails) {
                throw new Exception("Session not found.");
            }

            $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'users.delete');
            if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
                throw new Exception("You do not have permission to delete users.");
            }

            $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'partners.delete');
            if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
                throw new Exception("You do not have permission to delete partners.");
            }

            $id = (int)$_POST['id'];

            $deletionResult = $this->coreModel->deleteUser($id);

            if ($deletionResult) {
                echo json_encode(['status' => true, 'message' => 'User deleted successfully.']);
            } else {
                throw new Exception("Failed to delete user. Please try again.");
            }

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateProfile(){
        try {

            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }

            $email = $_SESSION['orchid_session'];

            error_log(json_encode($_POST));

            foreach (['first_name', 'last_name', 'phone'] as $field) {
                if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                    throw new Exception("Missing required field: $field");
                }
            }

            $first_name = $_POST['first_name'] ?? '';
            $last_name = $_POST['last_name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $location = $_POST['location'] ?? '';

            $response = $this->userModel->processProfileUpdate($email, $first_name, $last_name, $phone, $location);

            echo json_encode($response);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function changePassword(){
        try {
            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }
            $email = $_SESSION['orchid_session'];

            foreach (['current_password', 'new_password', 'confirm_password'] as $field) {
                if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                    throw new Exception("Missing required field: $field");
                }
            }

            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password !== $confirm_password) {
                throw new Exception("New password and confirmation do not match.");
            }

            $response = $this->userModel->processPasswordChange($email, $current_password, $new_password);

            echo json_encode($response);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

     public function fetchUserTransactionHistory() {
        try {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['orchid_session'])) {
           throw new Exception("User not logged in.");
        }
        
        $userEmail = $_SESSION['orchid_session'];
        
        // Get request parameters with defaults
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $perPage = isset($_POST['per_page']) ? (int)$_POST['per_page'] : 10;
        $transactionType = isset($_POST['type']) ? $this->coreModel->sanitizeInput($_POST['type']) : null;
        $search = isset($_POST['search']) ? $this->coreModel->sanitizeInput($_POST['search']) : null;
        $dateFilter = isset($_POST['date_filter']) ? $this->coreModel->sanitizeInput($_POST['date_filter']) : null;
        
        // Validate pagination parameters
        if ($page < 1) $page = 1;
        if ($perPage < 1 || $perPage > 50) $perPage = 10;
        
       
            // Get user ID from email
            $userId = $this->coreModel->fetchUserData($userEmail);
            $userId = $userId['id'];
            
            if (!$userId) {
                throw new Exception("User not found.");
            }
            
            // Calculate offset for pagination
            $offset = ($page - 1) * $perPage;
            
            // Fetch transactions from database
            $transactions = $this->coreModel->getUserTransactions(
                $userId, 
                $offset, 
                $perPage,
                $transactionType,
                $search,
                $dateFilter
            );
            
            // Get total count for pagination info
            $totalTransactions = $this->coreModel->getTotalUserTransactions(
                $userId,
                $transactionType,
                $search,
                $dateFilter
            );
            
            // Calculate summary statistics
            $summary = $this->coreModel->getTransactionSummary($userId);
            
            // Prepare response
            $response = [
                'status' => true,
                'message' => 'Transactions fetched successfully',
                'data' => [
                    'transactions' => $transactions,
                    'pagination' => [
                        'total' => (int)$totalTransactions,
                        'per_page' => $perPage,
                        'current_page' => $page,
                        'total_pages' => ceil($totalTransactions / $perPage),
                        'has_more' => ($page * $perPage) < $totalTransactions
                    ],
                    'summary' => $summary
                ]
            ];
            
            echo json_encode($response);
            
        } catch (Exception $e) {
            error_log('Transaction history error: ' . $e->getMessage());
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function activateAccount(){
        try {
            if (!isset($_POST['userid']) || empty(trim($_POST['userid']))) {
                throw new Exception("Invalid verification link.");
            }

            $email = $_POST['userid'];
            $email = $this->coreModel->sanitizeInput($email);
            $status = '';

            if (!$this->coreModel->checkEmail($email)) {
                throw new Exception("User does not exist.");
            }

            // Use separate variables for each statement
            $selectStmt = $this->db->prepare("SELECT status FROM users WHERE email = ?");
            $selectStmt->bind_param("s", $email);
            $selectStmt->execute();
            $selectStmt->bind_result($status);
            $selectStmt->fetch();
            $selectStmt->close(); // Close SELECT
            
            if ($status === 'active') {
                throw new Exception("Account is already verified.");
            }

            $updateStmt = $this->db->prepare("UPDATE users SET status = 'active' WHERE email = ?");
            $updateStmt->bind_param("s", $email);
            $updateStmt->execute();

            if ($updateStmt->affected_rows > 0) {
                echo json_encode(['status' => true, 'message' => 'Account successfully verified. You can now log in.']);
            } else {
                throw new Exception("Account verification failed.");
            }
            
            $updateStmt->close();

        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function fetchAllUsers() {
        try {
             // Get parameters
            $currentPage = max(1, (int)($_POST['page'] ?? 1));
            $perPage = max(1, (int)($_POST['per_page'] ?? 10));
            $search = trim($_POST['search'] ?? '');
            $accountType = 'user';
            $status = $_POST['status'] ?? 'all';
            $dateFrom = $_POST['date_from'] ?? '';
            $dateTo = $_POST['date_to'] ?? '';
            $sortBy = $_POST['sort_by'] ?? 'created_at';
            $sortOrder = $_POST['sort_order'] ?? 'desc';

            $result = $this->coreModel->getAllUsers($currentPage, $perPage, $search, $accountType, $status, $dateFrom, $dateTo, $sortBy, $sortOrder);
            // Calculate statistics
            

            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function fetchAllPartners() {
        try {
             // Get parameters
            $currentPage = max(1, (int)($_POST['page'] ?? 1));
            $perPage = max(1, (int)($_POST['per_page'] ?? 10));
            $search = trim($_POST['search'] ?? '');
            $accountType = 'partner';
            $status = $_POST['status'] ?? 'all';
            $dateFrom = $_POST['date_from'] ?? '';
            $dateTo = $_POST['date_to'] ?? '';
            $sortBy = $_POST['sort_by'] ?? 'created_at';
            $sortOrder = $_POST['sort_order'] ?? 'desc';

            $result = $this->coreModel->getAllPartners($currentPage, $perPage, $search, $accountType, $status, $dateFrom, $dateTo, $sortBy, $sortOrder);

            $stats = [];

            if ($result['status']) {

                $partners = $result['partners'];
                
                // Total partners
                $stats['total_partners'] = $result['pagination']['total_partners'];
                
                // Calculate total wallet balance
                $totalBalance = 0;
                $activeCount = 0;
                
                foreach ($partners as $partner) {
                    $balance = floatval($partner['wallet_balance'] ?? 0);
                    $totalBalance += $balance;
                    
                    if ($partner['status'] === 'active') {
                        $activeCount++;
                    }
                }
                
                $stats['total_wallet_balance'] = $totalBalance;
                $stats['active_partners'] = $activeCount;
                $stats['active_percentage'] = $stats['total_partners'] > 0 
                    ? round(($activeCount / $stats['total_partners']) * 100) . '%' 
                    : '0%';
                $stats['average_balance'] = $stats['total_partners'] > 0 
                    ? $totalBalance / $stats['total_partners'] 
                    : 0;
            }
            
            // Add stats to response
            $result['stats'] = $stats;

            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function fetchExchangeRates(){
        try {
            $value = $_POST['action'] ?? null;
            if (!$value) {
                throw new Exception("Value parameter is required.");
            }
            $rates = $this->coreModel->fetchRate($value);
            echo json_encode(['status' => true, 'rates' => $rates]);
        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function createPartnerAccount(){
        try {

            foreach (['first_name', 'last_name', 'email', 'phone', 'location'] as $field) {
                if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                    throw new Exception("Missing required field: $field");
                }
            }

            session_start();
            $email = $_SESSION['orchid_session'] ?? null;
            $fetchuserdetails = $this->coreModel->fetchUserData($email);

            $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'partners.create');
            if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
                throw new Exception("You do not have permission to edit partners.");
            }

            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $location = trim($_POST['location'] ?? '');
            $status = $_POST['status'] ?? 'active';
            $password = random_int(100000, 999999); // Generate a random 6-digit password
            $logoUrl = $_POST['logo_url'] ?? '';

            $result = $this->coreModel->processPartnerRegistration($firstName, $lastName, $email, $phone, $location, $status, $password, $logoUrl);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updatePartnerAccount(){
        try {

            foreach (['partner_id', 'first_name', 'last_name', 'email', 'phone', 'location'] as $field) {
                if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                    throw new Exception("Missing required field: $field");
                }
            }

            session_start();
            $email = $_SESSION['orchid_session'] ?? null;
            $fetchuserdetails = $this->coreModel->fetchUserData($email);

            $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'partners.edit');
            if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
                throw new Exception("You do not have permission to edit partners.");
            }

            $partnerId = trim($_POST['partner_id'] ?? '');
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $location = trim($_POST['location'] ?? '');

            $result = $this->coreModel->processPartnerUpdate($partnerId, $firstName, $lastName, $email, $phone, $location);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateUserAccount(){
        try {

            foreach (['user_id', 'first_name', 'last_name', 'email', 'phone'] as $field) {
                if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                    throw new Exception("Missing required field: $field");
                }
            }

            session_start();
            $email = $_SESSION['orchid_session'] ?? null;
            $fetchuserdetails = $this->coreModel->fetchUserData($email);

            $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'users.edit');
            if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
                throw new Exception("You do not have permission to edit users.");
            }

            $userId = trim($_POST['user_id'] ?? '');
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');

            $result = $this->coreModel->processUserUpdate($userId, $firstName, $lastName, $email, $phone);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateAccountStatus(){
        try {

            foreach (['partner_id', 'status'] as $field) {
                if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                    throw new Exception("Missing required field: $field");
                }
            }

            session_start();
            $email = $_SESSION['orchid_session'] ?? null;
            $fetchuserdetails = $this->coreModel->fetchUserData($email);

            $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'users.update_status');
            if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
                throw new Exception("You do not have permission to update users status.");
            }

            $partnerId = trim($_POST['partner_id'] ?? '');
            $status = trim($_POST['status'] ?? '');

            $result = $this->coreModel->processAccountStatusUpdate($partnerId, $status);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function adjustPartnerWallet(){
        try {

            foreach (['partner_id', 'amount', 'type', 'reason'] as $field) {
                if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                    throw new Exception("Missing required field: $field");
                }
            }

            session_start();
            $email = $_SESSION['orchid_session'] ?? null;
            $fetchuserdetails = $this->coreModel->fetchUserData($email);

            $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'points.adjust');
            if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
                throw new Exception("You do not have permission to adjust partner points.");
            }

            $partnerId = trim($_POST['partner_id'] ?? '');
            $amount = trim($_POST['amount'] ?? '');
            $type = trim($_POST['type'] ?? '');
            $reason = trim($_POST['reason'] ?? '');

            $result = $this->coreModel->processBalanceAdjustment($partnerId, $amount, $type, $reason);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updatePointConfiguration(){
        try {

            foreach (['amount', 'point', 'key'] as $field) {
                if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                    throw new Exception("Missing required field: $field");
                }
            }

            session_start();
            $email = $_SESSION['orchid_session'] ?? null;
            $fetchuserdetails = $this->coreModel->fetchUserData($email);

            $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'settings.points_rate');
            if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
                throw new Exception("You do not have permission to update points configuration.");
            }


            $amount = trim($_POST['amount'] ?? '');
            $points = trim($_POST['point'] ?? '');
            $key = trim($_POST['key'] ?? '');

            $result = $this->coreModel->processPointConfigurationUpdate($amount, $points, $key);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updatePartnerLogo(){
        try {

            session_start();
            $email = $_SESSION['orchid_session'];

            $user = $this->coreModel->fetchUserData($email);
            if (!$user['status']) {
                throw new Exception($user['message']);
            }

            if (!isset($_FILES['logo'])) {
                return ['status' => false, 'message' => 'No file uploaded'];
            }

            $result = $this->coreModel->uploadPartnerLogo($_FILES['logo']);
            if(!$result['status']){
                throw new Exception($result['message']);
            }

            $stmt = $this->db->prepare("UPDATE users SET logo = ? WHERE id = ?");
            $stmt->bind_param("si", $result['file_name'], $user['id']);
            $stmt->execute();
            $stmt->close();

            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }

    }

    public function validateRedemptionCode(){
        try {

            foreach (['code'] as $field) {
                if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                    throw new Exception("Missing required field: $field");
                }
            }

            $code = trim($_POST['code'] ?? '');

            $result = $this->coreModel->processRedemptionCodeValidation($code);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function fetchAdminLogs(){
        try {

            $page = max(1, (int)($_POST['page'] ?? 1));
            $limit = max(1, (int)($_POST['limit'] ?? 10));
            $search = trim($_POST['search'] ?? '');
            $actions = trim($_POST['actions'] ?? '');
            $admins = trim($_POST['admins'] ?? '');
            $dateFrom = trim($_POST['date_from'] ?? '');
            $dateTo = trim($_POST['date_to'] ?? '');

            $result = $this->coreModel->fetchActivitylogs($page, $limit, $search, $actions, $admins, $dateFrom, $dateTo);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function fetchWithdrawalRequests(){
        try {
            $page = max(1, (int)($_POST['page'] ?? 1));
            $limit = max(1, (int)($_POST['limit'] ?? 10));
            $search = trim($_POST['search'] ?? '');
            $status = trim($_POST['status'] ?? '');
            $dateFilter = trim($_POST['date_filter'] ?? '');

            $result = $this->coreModel->fetchWithdrawalRequests($page, $limit, $search, $status, $dateFilter);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function pointAwardRequest(){
        try {

            session_start();
            $email = $_SESSION['orchid_session'];

            $user = $this->coreModel->fetchUserData($email);
            if (!$user) {
                throw new Exception('Session not found.');
            }

            $email = $_SESSION['orchid_session'] ?? null;
            $fetchuserdetails = $this->coreModel->fetchUserData($email);

            $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'points.award');
            if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
                throw new Exception("You do not have permission to update users status.");
            }

            $points = trim($_POST['points'] ?? '');
            $amount = trim($_POST['amount'] ?? '');
            $user_email = trim($_POST['user_email'] ?? '');


            $result = $this->coreModel->processPointAwardRequest($user['id'], $points, $amount, $user_email);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }

    }

    public function getAdminsWithPermissions(){
        try {

            $result = $this->coreModel->fetchAdminUsersWithPermissions();
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function rolePermissionUpdate(){
        try {

            session_start();
            $email = $_SESSION['orchid_session'];

            $user = $this->coreModel->fetchUserData($email);
            if (!$user) {
                throw new Exception('Session not found.');
            }


            $admin_id = $user['id'];

            $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
            $permissionId = isset($_POST['permission_id']) ? intval($_POST['permission_id']) : 0;
            $active = isset($_POST['active']) ? boolval($_POST['active']) : false;

            $result = $this->coreModel->processPermissionUpdate($admin_id, $userId, $permissionId, $active);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function forgotEmailVerificationRequest(){
        try {

            session_start();
            $email = $this->coreModel->sanitizeInput($_POST['email']);

            $user = $this->coreModel->fetchUserData($email);
            if (!$user) {
                throw new Exception('Email address not found.');
            }

            $result = $this->coreModel->processEmailVerificationRequest($email);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function forgotPasswordCodeVerficationRequest(){
        try {

            session_start();
            $email = $this->coreModel->sanitizeInput($_POST['email']);
            $code = $this->coreModel->sanitizeInput($_POST['code']);

            $user = $this->coreModel->fetchUserData($email);
            if (!$user) {
                throw new Exception('Email address not found.');
            }

            $result = $this->coreModel->processconfirmVerificationCode($email, $code);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function forgotPasswordResetRequest(){
        try {

            session_start();
            $email = $this->coreModel->sanitizeInput($_POST['email']);
            $password = $this->coreModel->sanitizeInput($_POST['password']);
            $confirmpassword = $this->coreModel->sanitizeInput($_POST['confirmPassword']);

            $user = $this->coreModel->fetchUserData($email);
            if (!$user) {
                throw new Exception('Email address not found.');
            }

            if ($password !== $confirmpassword) {
                throw new Exception('Passwords do not match.');
            }

            $result = $this->coreModel->processForgotPasswordResetRequest($email, $password);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function createAdmin(){
        try {

            session_start();
            $email = $this->coreModel->sanitizeInput($_POST['email']);
            $first_name = $this->coreModel->sanitizeInput($_POST['first_name']);
            $last_name = $this->coreModel->sanitizeInput($_POST['last_name']);

            $user = $this->coreModel->fetchUserData($email);
            if ($user) {
                throw new Exception('Email address already exists.');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid email format.');
            }

            if (!preg_match("/^[a-zA-Z'-]+$/", $first_name)) {
                throw new Exception("First name can only contain letters, apostrophes, and hyphens.");
            }

            if (!preg_match("/^[a-zA-Z'-]+$/", $last_name)) {
                throw new Exception("Last name can only contain letters, apostrophes, and hyphens.");
            }

            $email = $_SESSION['orchid_session'] ?? null;
            $fetchuserdetails = $this->coreModel->fetchUserData($email);

            $permission = $this->coreModel->checkPermissionRole($fetchuserdetails['id'], 'admins.create');
            if($fetchuserdetails['isAdmin'] == 0 && $permission == false){
                throw new Exception("You do not have permission to update users status.");
            }

            $result = $this->coreModel->processCreateAdmin($first_name, $last_name, $email);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }

    }

    public function redeemCode(){
        try {
            session_start();
            $email = $_SESSION['orchid_session'] ?? null;
            $fetchuserdetails = $this->coreModel->fetchUserData($email);

            $points = trim($_POST['points'] ?? '');
            $amount = trim($_POST['amount'] ?? '');

            $result = $this->coreModel->processPointRedeem($fetchuserdetails['id'], $points, $amount);
            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function partnerCodeRedemption(){
        try {

            session_start();
            $email = $_SESSION['orchid_session'] ?? null;
            $fetchuserdetails = $this->coreModel->fetchUserData($email);
            $amount = trim($_POST['amount'] ?? '');
            $points = trim($_POST['points'] ?? '');
            $code_id = trim($_POST['code_id'] ?? '');
            $code = trim($_POST['code'] ?? '');
            $new_wallet_balance = $amount + $fetchuserdetails['wallet_balance'];

            $result = $this->coreModel->processCodeRedemption($fetchuserdetails['id'], $amount, $points, $code_id, $code, $new_wallet_balance);

            echo json_encode($result);

        } catch (Exception $e){
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }






    
    
    
}