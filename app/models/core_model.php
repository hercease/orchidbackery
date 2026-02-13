<?php
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\SMTP;
class CoreModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCurrentUrl()
    {
        // Check if HTTPS is on or not
        $isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? true : false;
        // Get the host (domain name) and the requested URI
        $host = $_SERVER['HTTP_HOST'];
        // Get the HTTP protocol (http or https)
        $protocol = $isHttps ? 'https://' . $host : 'http://' . $host . '/orchidbackery';

        //$uri = $_SERVER['REQUEST_URI'];

        // Build the full URL
        $fullUrl = $protocol;

        // Return an associative array with the information
        return $fullUrl;
    }

    public function getInitials($name) {
        // Split the name into an array of words
        $words = explode(' ', $name);
    
        // Extract the first letter of each word
        $initials = array_map(function($word) {
            return strtoupper($word[0]); // Convert to uppercase for consistency
        }, $words);
    
        // Join the initials into a single string
        return implode('', $initials);
    }

    public function fetchAllPartners() {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE acct_type = 'partner' ORDER BY id DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        $partners = [];
        while ($row = $result->fetch_assoc()) {
            $partners[] = $row;
        }
        $stmt->close();
        return $partners;
    }

    

    public function getUserTier(int $points): string
    {
        if ($points >= 5001) {
            return 'Platinum';
        }

        if ($points >= 2001) {
            return 'Gold';
        }

        if ($points >= 501) {
            return 'Silver';
        }

        return 'Bronze';
    }


    public function metaTags($pageData = [])
    {
        $defaultMeta = [
            'title' => 'Orchid Bakery Loyalty Platform',
            'description' => 'Orchid Bakery Loyalty Platform',
            'keywords' => 'Orchid Bakery, Loyalty Platform, Rewards, Customer Engagement, Bakery Rewards Program',
            'author' => 'Orchid Bakery',
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_site_name' => 'Orchid Bakery',
            'twitter_card' => 'summary_large_image',
            'canonical' => $this->getCurrentUrl(),
            'image' => $this->getCurrentUrl() . '/public/logo/logo.png',
            'theme_color' => '#013220',
            'app_name' => 'Orchid Bakery',
            'app_short_name' => 'Orchid Bakery'
        ];

        // Merge default with page-specific data
        $meta = array_merge($defaultMeta, $pageData);

        // Generate the meta tags HTML
        $metaTags = '';
    
        // Basic meta tags
        $metaTags .= '<title>' . htmlspecialchars($meta['title']) . '</title>' . PHP_EOL;
        $metaTags .= '<meta charset="UTF-8">' . PHP_EOL;
        $metaTags .= '<meta name="description" content="' . htmlspecialchars($meta['description']) . '">' . PHP_EOL;
        $metaTags .= '<meta name="keywords" content="' . htmlspecialchars($meta['keywords']) . '">' . PHP_EOL;
        $metaTags .= '<meta name="author" content="' . htmlspecialchars($meta['author']) . '">' . PHP_EOL;
        $metaTags .= '<meta name="robots" content="' . htmlspecialchars($meta['robots']) . '">' . PHP_EOL;
    
        // Open Graph meta tags
        $metaTags .= '<meta property="og:title" content="' . htmlspecialchars($meta['title']) . '">' . PHP_EOL;
        $metaTags .= '<meta property="og:description" content="' . htmlspecialchars($meta['description']) . '">' . PHP_EOL;
        $metaTags .= '<meta property="og:type" content="' . htmlspecialchars($meta['og_type']) . '">' . PHP_EOL;
        $metaTags .= '<meta property="og:url" content="' . htmlspecialchars($meta['canonical']) . '">' . PHP_EOL;
        $metaTags .= '<meta property="og:image" content="' . htmlspecialchars($meta['image']) . '">' . PHP_EOL;
        $metaTags .= '<meta property="og:site_name" content="' . htmlspecialchars($meta['og_site_name']) . '">' . PHP_EOL;
    
        // Twitter Card meta tags
        $metaTags .= '<meta name="twitter:card" content="' . htmlspecialchars($meta['twitter_card']) . '">' . PHP_EOL;
        $metaTags .= '<meta name="twitter:title" content="' . htmlspecialchars($meta['title']) . '">' . PHP_EOL;
        $metaTags .= '<meta name="twitter:description" content="' . htmlspecialchars($meta['description']) . '">' . PHP_EOL;
        $metaTags .= '<meta name="twitter:image" content="' . htmlspecialchars($meta['image']) . '">' . PHP_EOL;
    
        // Additional important meta tags
        $metaTags .= '<link rel="canonical" href="' . htmlspecialchars($meta['canonical']) . '">' . PHP_EOL;
        $metaTags .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . PHP_EOL;
        
        // Favicon
        $metaTags .= '<link rel="shortcut icon" type="image/png" href="' . $this->getCurrentUrl() . '/public/favicon/favicon.ico">' . PHP_EOL;

        // Theme color
        $metaTags .= '<meta name="theme-color" content="' . htmlspecialchars($meta['theme_color']) . '">' . PHP_EOL;
        $metaTags .= '<meta name="mobile-web-app-capable" content="yes">' . PHP_EOL;

        return $metaTags;
    }

    public function sanitizeInput($input)
    {
        $data = trim($input); // Remove unnecessary spaces
		$data = stripslashes($data); // Remove backslashes
		$data = htmlspecialchars($data); // Convert special characters to HTML entities
		return $data;
    }

    public function checkPhone($phone){
        //Check if phone exist
        $stmt = $this->db->prepare("SELECT phone FROM users where phone=? ");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        //Check the rows if it exist
        if($result->num_rows > 0){
            return true;
        }else{
            //Return false if it doesn't exist
            return false;
        }
    }

    public function checkEmail($email){
        //Check if email exist
        $stmt = $this->db->prepare("SELECT email FROM users where email=? ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        //Check the rows if it exist
        if($result->num_rows > 0){
            return true;
        }else{
            //Return false if it doesn't exist
            return false;
        }
    }

    public function sendmail($email, $name, $body, $subject){
        require_once 'PHPMailer/src/Exception.php';
        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        
        $response = [
            'status' => false,
            'message' => '',
            'error' => null,
            'email' => $email,
            'subject' => $subject
        ];
        
        // Quick validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = 'Invalid email address';
            $response['error'] = 'VALIDATION_ERROR';
            return $response;
        }
       

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USERNAME'];
            $mail->Password   = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->Timeout    = 15; // 15 second timeout
            
            // Recipients
            $mail->setFrom($_ENV['SMTP_FROM_EMAIL'], 'Orchid Bakery');
            $mail->addAddress($email, $name);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body); // Plain text version

            // Send and capture result
            $sendResult = $mail->send();
            
            if ($sendResult) {
                $response['status'] = true;
                $response['message'] = 'Email sent successfully';
                $response['message_id'] = $mail->getLastMessageID();
            } else {
                $response['status'] = false;
                $response['error'] = $mail->ErrorInfo;
            }
            
            $mail->clearAddresses();
            
        } catch (Exception $e) {
            $response['message'] = 'Email sending failed';
            $response['error'] = $e->getMessage();
        }
        
        return $response;
    }

    public function fetchUserData($email){
        $stmt = $this->db->prepare("SELECT id, first_name, last_name, email, phone, points_balance, password_hash, wallet_balance, logo, location, status, created_at, acct_type, isAdmin FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function fetchUser($id){
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ? OR email = ?");
        $stmt->bind_param("is", $id,$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function fetchpermissiondetails($id){
        $stmt = $this->db->prepare("SELECT * FROM permissions WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function fetchUserTotalPoints($id){
        //Get total points
        $stmt = $this->db->prepare("SELECT SUM(points) as total FROM transaction_history WHERE user_id = ? AND type = 'purchase'");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function deleteUser($id){
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getTransactionTypeConfig($type = null) {
        $config = [
            'purchase' => [
                'icon' => 'fa-shopping-cart',
                'color' => 'bg-green-500',
                'text_color' => 'text-green-600',
                'bg_color' => 'bg-green-50',
                'label' => 'Purchase',
                'amount_prefix' => '+',
                'amount_suffix' => 'points'
            ],
            'redemption' => [
                'icon' => 'fa-gift',
                'color' => 'bg-purple-500',
                'text_color' => 'text-purple-600',
                'bg_color' => 'bg-purple-50',
                'label' => 'Redemption',
                'amount_prefix' => '-$',
                'amount_suffix' => ''
            ],
            'withdrawal' => [
                'icon' => 'fa-money-bill-wave',
                'color' => 'bg-blue-500',
                'text_color' => 'text-blue-600',
                'bg_color' => 'bg-blue-50',
                'label' => 'Withdrawal',
                'amount_prefix' => '-$',
                'amount_suffix' => ''
            ],
            'code_conversion' => [
                'icon' => 'fa-exchange-alt',
                'color' => 'bg-orange-500',
                'text_color' => 'text-orange-600',
                'bg_color' => 'bg-orange-50',
                'label' => 'Code Conversion',
                'amount_prefix' => '-',
                'amount_suffix' => 'points'
            ],
            'point_award' => [
                'icon' => 'fa-gift',
                'color' => 'bg-yellow-500',
                'text_color' => 'text-yellow-600',
                'bg_color' => 'bg-yellow-50',
                'label' => 'Point Award',
                'amount_prefix' => '+',
                'amount_suffix' => 'points'
            ],
            'adjustment' => [
                'icon' => 'fa-adjust',
                'color' => 'bg-gray-500',
                'text_color' => 'text-gray-600',
                'bg_color' => 'bg-gray-50',
                'label' => 'Adjustment',
                'amount_prefix' => '',
                'amount_suffix' => 'points'
            ]
        ];
        
        // If no specific type requested, return all configurations
        if ($type === null) {
            return  [
                'icon' => 'fa-question-circle',
                'color' => 'bg-gray-500',
                'text_color' => 'text-gray-600',
                'bg_color' => 'bg-gray-50',
                'label' => 'Unknown',
                'amount_prefix' => '',
                'amount_suffix' => ''
            ];
        }
        
        // If specific type requested, return that configuration or default
        return isset($config[$type]) ? $config[$type] : [
            'icon' => 'fa-question-circle',
            'color' => 'bg-gray-500',
            'text_color' => 'text-gray-600',
            'bg_color' => 'bg-gray-50',
            'label' => 'Unknown',
            'amount_prefix' => '',
            'amount_suffix' => ''
        ];
    }

    public function fetchRate($system_value) {

        $stmt = $this->db->prepare("SELECT setting_amount, setting_point, updated_at FROM system_settings WHERE setting_key = ?");
        $stmt->bind_param("s", $system_value);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){

            $row = $result->fetch_assoc();

            return [
                'amount' => $row['setting_amount'],
                'points' => $row['setting_point'],
                'exchange_rate' => $row['setting_point']== 0 || $row['setting_amount']== 0 ? 0 : $row['setting_amount'] / $row['setting_point'],
                'conversion_rate' =>  $row['setting_point']== 0 || $row['setting_amount']== 0 ? 0 : $row['setting_point'] / $row['setting_amount'],
                'updated_at' => $row['updated_at']
            ];

        } else {

            return [
                'amount' => 0,
                'points' => 0,
                'exchange_rate' => 0,
                'updated_at' => null
            ];

        }

    }

    public function getUserTransactions($userId, $offset, $limit, $type = null, $search = null, $dateFilter = null) {
        // Build base query
        $query = "SELECT 
                    t.id,
                    t.type,
                    t.title,
                    t.description,
                    t.points,
                    t.amount,
                    t.status,
                    t.reference,
                    t.code,
                    DATE_FORMAT(t.created_at, '%Y-%m-%dT%H:%i:%sZ') as date,
                    t.created_at as raw_date
                  FROM transaction_history t
                  WHERE t.user_id = ?";
        
        $params = [$userId];
        $types = "i"; // user_id is integer
        
        // Add type filter
        if ($type && in_array($type, ['purchase', 'redemption', 'withdrawal', 'point_redeem'])) {
            $query .= " AND t.type = ?";
            $params[] = $type;
            $types .= "s";
        }
        
        // Add search filter
        if ($search) {
            $searchParam = "%" . $search . "%";
            $query .= " AND (t.title LIKE ? OR t.description LIKE ? OR t.reference LIKE ?)";
            $params[] = $searchParam;
            $params[] = $searchParam;
            $params[] = $searchParam;
            $types .= "sss";
        }
        
        // Add date filter
        if ($dateFilter) {
            $dateCondition = $this->getDateCondition($dateFilter);
            if ($dateCondition) {
                $query .= " AND " . $dateCondition;
            }
        }
        
        // Order by date (newest first) and add pagination
        $query .= " ORDER BY t.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";
        
        $stmt = $this->db->prepare($query);
        
        if (!$stmt) {
            //error_log("Prepare failed: " . $this->db->error);
            return [];
        }
        
        // Bind parameters dynamically
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
        
        $stmt->close();
        return $transactions;
    }

    public function getTransactionSummary($userId, $timeframe = 'all') {
        $summary = [];
        $currentMonth = date('m');
        $currentYear = date('Y');
        
        // Get current points balance (always current, not filtered by timeframe)
        $balanceQuery = "SELECT points_balance FROM users WHERE id = ?";
        $stmt = $this->db->prepare($balanceQuery);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $balanceResult = $stmt->get_result();
        $balanceRow = $balanceResult->fetch_assoc();
        $summary['current_balance'] = $balanceRow['points_balance'] ?? 0;
        $stmt->close();
        
        // Build WHERE clause based on timeframe
        $timeWhereClause = "";
        if ($timeframe === 'month') {
            $timeWhereClause = "AND MONTH(created_at) = ? AND YEAR(created_at) = ?";
        }
        
        // Get points earned (from purchases and bonuses)
        $earnedQuery = "SELECT COALESCE(SUM(points), 0) as earned
                    FROM transaction_history
                    WHERE user_id = ? 
                    AND type IN ('purchase')
                    AND points > 0
                    AND status = 'completed'";
        
        // Append timeframe condition if needed
        if ($timeframe === 'month') {
            $earnedQuery .= " $timeWhereClause";
        }
        
        $stmt = $this->db->prepare($earnedQuery);
        if ($timeframe === 'month') {
            $stmt->bind_param("iii", $userId, $currentMonth, $currentYear);
        } else {
            $stmt->bind_param("i", $userId);
        }
        $stmt->execute();
        $earnedResult = $stmt->get_result();
        $earnedRow = $earnedResult->fetch_assoc();
        $summary['points_earned'] = $earnedRow['earned'] ?? 0;
        $stmt->close();
        
        // Get points spent (from redemptions and conversions)
        $spentQuery = "SELECT COALESCE(SUM(ABS(points)), 0) as spent
                    FROM transaction_history
                    WHERE user_id = ? 
                    AND type IN ('redemption')
                    AND status = 'completed'";
        
        // Append timeframe condition if needed
        if ($timeframe === 'month') {
            $spentQuery .= " $timeWhereClause";
        }
        
        $stmt = $this->db->prepare($spentQuery);
        if ($timeframe === 'month') {
            $stmt->bind_param("iii", $userId, $currentMonth, $currentYear);
        } else {
            $stmt->bind_param("i", $userId);
        }
        $stmt->execute();
        $spentResult = $stmt->get_result();
        $spentRow = $spentResult->fetch_assoc();
        $summary['points_spent'] = $spentRow['spent'] ?? 0;
        $stmt->close();
        
        // Get total withdrawn amount
        $withdrawnQuery = "SELECT COALESCE(SUM(amount), 0) as withdrawn
                        FROM transaction_history 
                        WHERE user_id = ? 
                        AND type = 'withdrawal'
                        AND status = 'completed'";
        
        // Append timeframe condition if needed
        if ($timeframe === 'month') {
            $withdrawnQuery .= " $timeWhereClause";
        }
        
        $stmt = $this->db->prepare($withdrawnQuery);
        if ($timeframe === 'month') {
            $stmt->bind_param("iii", $userId, $currentMonth, $currentYear);
        } else {
            $stmt->bind_param("i", $userId);
        }
        $stmt->execute();
        $withdrawnResult = $stmt->get_result();
        $withdrawnRow = $withdrawnResult->fetch_assoc();
        $summary['total_withdrawn'] = $withdrawnRow['withdrawn'] ?? 0;
        $stmt->close();
        
        // Get total transactions count
        $totalQuery = "SELECT COUNT(*) as total 
                    FROM transaction_history
                    WHERE user_id = ? 
                    AND status = 'completed'";
        
        // Append timeframe condition if needed
        if ($timeframe === 'month') {
            $totalQuery .= " $timeWhereClause";
        }
        
        $stmt = $this->db->prepare($totalQuery);
        if ($timeframe === 'month') {
            $stmt->bind_param("iii", $userId, $currentMonth, $currentYear);
        } else {
            $stmt->bind_param("i", $userId);
        }
        $stmt->execute();
        $totalResult = $stmt->get_result();
        $totalRow = $totalResult->fetch_assoc();
        $summary['total_transactions'] = $totalRow['total'] ?? 0;
        $stmt->close();
        
        // Format the summary
        return [
            'total_transactions' => (int)$summary['total_transactions'],
            'points_earned' => (int)$summary['points_earned'],
            'points_spent' => (int)$summary['points_spent'],
            'total_withdrawn' => (float)number_format($summary['total_withdrawn'], 2, '.', ''),
            'current_balance' => (int)$summary['current_balance'],
            'timeframe' => $timeframe,
            'month' => $timeframe === 'month' ? date('F Y') : null
        ];
    }
    

    public function getTotalUserTransactions($userId, $type = null, $search = null, $dateFilter = null) {
        // Build base query
        $query = "SELECT COUNT(*) as total FROM transaction_history t WHERE t.user_id = ?";
        
        $params = [$userId];
        $types = "i";
        
        if ($type && in_array($type, ['purchase', 'redemption', 'withdrawal', 'point_redeem'])) {
            $query .= " AND t.type = ?";
            $params[] = $type;
            $types .= "s";
        }
        
        if ($search) {
            $searchParam = "%" . $search . "%";
            $query .= " AND (t.title LIKE ? OR t.description LIKE ? OR t.reference_id LIKE ?)";
            $params[] = $searchParam;
            $params[] = $searchParam;
            $params[] = $searchParam;
            $types .= "sss";
        }
        
        if ($dateFilter) {
            $dateCondition = $this->getDateCondition($dateFilter);
            if ($dateCondition) {
                $query .= " AND " . $dateCondition;
            }
        }
        
        $stmt = $this->db->prepare($query);
        
        if (!$stmt) {
            error_log("Prepare failed: " . $this->db->error);
            return 0;
        }
        
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $total = $row['total'] ?? 0;
        
        $stmt->close();
        return $total;
    }
    

    private function getDateCondition($dateFilter) {
        switch ($dateFilter) {
            case 'today':
                return "DATE(t.created_at) = CURDATE()";
            case 'week':
                return "t.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
            case 'month':
                return "t.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
            case 'quarter':
                return "t.created_at >= DATE_SUB(NOW(), INTERVAL 90 DAY)";
            case 'year':
                return "t.created_at >= DATE_SUB(NOW(), INTERVAL 365 DAY)";
            default:
                return null;
        }
    }


    /**
     * Calculate user registration statistics for admin dashboard
     * 
     * @param mysqli $db Database connection
     * @return array Statistics with current, previous, difference, and percentage
     */
    public function getUserRegistrationStats() {
        $stats = [
            'total' => 0,
            'current_month' => 0,
            'last_month' => 0,
            'difference' => 0,
            'percentage' => 0,
            'is_increase' => true,
            'text' => '0% from last month'
        ];
        
        try {
            // Get total users
            $totalQuery = "SELECT COUNT(*) as count FROM users";
            $result = $this->db->query($totalQuery);
            if ($result) {
                $row = $result->fetch_assoc();
                $stats['total'] = (int)$row['count'];
            }

            // Get current month registrations
            $currentMonthQuery = "SELECT COUNT(*) as count 
                                FROM users 
                                WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) 
                                AND YEAR(created_at) = YEAR(CURRENT_DATE())";
            
            $result = $this->db->query($currentMonthQuery);
            if ($result) {
                $row = $result->fetch_assoc();
                $stats['current_month'] = (int)$row['count'];
            }
            
            // Get last month registrations
            $lastMonthQuery = "SELECT COUNT(*) as count 
                            FROM users 
                            WHERE MONTH(created_at) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH))
                            AND YEAR(created_at) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH))";
            
            $result = $this->db->query($lastMonthQuery);
            if ($result) {
                $row = $result->fetch_assoc();
                $stats['last_month'] = (int)$row['count'];
            }
            
            // Calculate difference and percentage
            if ($stats['last_month'] > 0) {
                $stats['difference'] = $stats['current_month'] - $stats['last_month'];
                $stats['percentage'] = round(($stats['difference'] / $stats['last_month']) * 100);
                $stats['is_increase'] = $stats['difference'] >= 0;
            } else {
                // If last month was 0 and this month has registrations, it's 100% increase
                if ($stats['current_month'] > 0) {
                    $stats['percentage'] = 100;
                    $stats['is_increase'] = true;
                }
                $stats['difference'] = $stats['current_month'];
            }
            
            // Generate text description
            $direction = $stats['is_increase'] ? 'increase' : 'decrease';
            $stats['text'] = abs($stats['percentage']) . "% $direction from last month";
            
        } catch (Exception $e) {
            error_log("Error calculating registration stats: " . $e->getMessage());
        }
        
        return $stats;
    }

    /**
     * Calculate points redemption statistics for admin dashboard
     * 
     * @param mysqli $db Database connection
     * @param string $period 'month' or 'week' for comparison period
     * @return array Statistics with current, previous, difference, and percentage
     */
    public function getPointsRedemptionStats($period = 'month') {
        $stats = [
            'current' => 0,
            'previous' => 0,
            'difference' => 0,
            'percentage' => 0,
            'is_increase' => true,
            'text' => '0% from last period',
            'period_label' => $period === 'week' ? 'week' : 'month'
        ];
        
        try {
            if ($period === 'month') {
                // Monthly comparison
                
                // Get current month redemptions (sum of points)
                $currentQuery = "SELECT COALESCE(SUM(points), 0) as total 
                                FROM transaction_history 
                                WHERE type = 'redemption'
                                AND status = 'completed'
                                AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
                                AND YEAR(created_at) = YEAR(CURRENT_DATE())";
                
                $result = $this->db->query($currentQuery);
                if ($result) {
                    $row = $result->fetch_assoc();
                    $stats['current'] = abs((int)$row['total']); // Convert to positive number
                }
                
                // Get last month redemptions
                $previousQuery = "SELECT COALESCE(SUM(points), 0) as total 
                                FROM transaction_history 
                                WHERE type = 'redemption'
                                AND status = 'completed'
                                AND MONTH(created_at) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH))
                                AND YEAR(created_at) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH))";
                
            } else {
                // Weekly comparison
                
                // Get current week (Monday to Sunday)
                $currentQuery = "SELECT COALESCE(SUM(points), 0) as total 
                                FROM transaction_history 
                                WHERE type = 'redemption'
                                AND status = 'completed'
                                AND YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
                
                $result = $this->db->query($currentQuery);
                if ($result) {
                    $row = $result->fetch_assoc();
                    $stats['current'] = abs((int)$row['total']);
                }
                
                // Get previous week
                $previousQuery = "SELECT COALESCE(SUM(points), 0) as total 
                                FROM transaction_history 
                                WHERE type = 'redemption'
                                AND status = 'completed'
                                AND YEARWEEK(created_at, 1) = YEARWEEK(DATE_SUB(CURDATE(), INTERVAL 1 WEEK), 1)";
            }
            
            $result = $this->db->query($previousQuery);
            if ($result) {
                $row = $result->fetch_assoc();
                $stats['previous'] = abs((int)$row['total']);
            }
            
            // Calculate difference and percentage
            if ($stats['previous'] > 0) {
                $stats['difference'] = $stats['current'] - $stats['previous'];
                $stats['percentage'] = round(($stats['difference'] / $stats['previous']) * 100);
                $stats['is_increase'] = $stats['difference'] >= 0;
            } else {
                // If previous period was 0 and this period has redemptions, it's 100% increase
                if ($stats['current'] > 0) {
                    $stats['percentage'] = 100;
                    $stats['is_increase'] = true;
                }
                $stats['difference'] = $stats['current'];
            }
            
            // Generate text description
            $direction = $stats['is_increase'] ? 'increase' : 'decrease';
            $periodText = $period === 'week' ? 'last week' : 'last month';
            $stats['text'] = abs($stats['percentage']) . "% $direction from $periodText";
            
        } catch (Exception $e) {
            error_log("Error calculating redemption stats: " . $e->getMessage());
        }
        
        return $stats;
    }

    /**
     * Format points for display (e.g., 124.5K for 124,500)
     * 
     * @param int $points Number of points
     * @return string Formatted points string
     */
    function formatPointsForDisplay($points) {
        if ($points >= 1000000) {
            return round($points / 1000000, 1) . 'M';
        } elseif ($points >= 1000) {
            return round($points / 1000, 1) . 'K';
        }
        return (string)$points;
    }

    /**
     * Get active partners count (partners with status = active)
     * 
     * @param mysqli $db Database connection
     * @return array Partners statistics
     */
    public function getActivePartnersStats() {
        $stats = [
            'total' => 0,
            'new_this_week' => 0,
            'text' => '0 new this week'
        ];
        
        try {
            // Get total active partners
            $totalQuery = "SELECT COUNT(*) as count 
                        FROM users  
                        WHERE acct_type = 'partner' AND status = 'active'";
            
            $result = $this->db->query($totalQuery);
            if ($result) {
                $row = $result->fetch_assoc();
                $stats['total'] = (int)$row['count'];
            }
            
            // Get partners added this week
            $weekQuery = "SELECT COUNT(*) as count 
                        FROM users 
                        WHERE acct_type = 'partner' AND status = 'active'
                        AND YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
            
            $result = $this->db->query($weekQuery);
            if ($result) {
                $row = $result->fetch_assoc();
                $stats['new_this_week'] = (int)$row['count'];
            }
            
            // Generate text
            if ($stats['new_this_week'] > 0) {
                $stats['text'] = $stats['new_this_week'] . " new this week";
            }
            
        } catch (Exception $e) {
            error_log("Error calculating partners stats: " . $e->getMessage());
        }
        
        return $stats;
    }

    public function getPartnerStats($partner_id) {
        $stats = [
            'total_redemptions' => 0,
            'monthly_redemptions' => 0,
            'redemption_growth' => 0,
            'today_redemptions' => 0,
            'total_processed' => 0,
            'last_withdrawal_date' => null,
            'active_customers' => 0,
            'today_revenue' => 0,
            'monthly_revenue' => 0,
            'pending_withdrawals' => 0
        ];
        
        try {
            // 1. Get total redemptions (all time)
            $stats['total_redemptions'] = $this->getTotalRedemptions($partner_id);
            
            // 2. Get monthly redemptions (current month)
            $stats['monthly_redemptions'] = $this->getMonthlyRedemptions($partner_id);
            
            // 3. Calculate redemption growth compared to last month
            $stats['redemption_growth'] = $this->calculateRedemptionGrowth($partner_id);
            
            // 4. Get today's redemptions
            $stats['today_redemptions'] = $this->getTodayRedemptions($partner_id);
            
            // 5. Get total processed amount (sum of all completed redemptions)
            $stats['total_processed'] = $this->getTotalProcessed($partner_id);
            
            // 6. Get last withdrawal date from partner_withdrawals table
            $stats['last_withdrawal_date'] = $this->getLastWithdrawalDate($partner_id);
            
            // 7. Get active customers count (unique customers)
            $stats['active_customers'] = $this->getActiveCustomers($partner_id);
            
            // 8. Get today's revenue
            $stats['today_revenue'] = $this->getTodayRevenue($partner_id);
            
            // 9. Get monthly revenue
            $stats['monthly_revenue'] = $this->getMonthlyRevenue($partner_id);
            
            // 10. Get pending withdrawals amount
            $stats['pending_withdrawals'] = $this->getPendingWithdrawals($partner_id);
            
        } catch (Exception $e) {
            // Log error and return empty stats
            error_log("Error getting partner stats for partner_id {$partner_id}: " . $e->getMessage());
        }
        
        return $stats;
    }

        
    /**
     * Get total redemptions count (all time)
     */
    public function getTotalRedemptions($partner_id) {
        $sql = "SELECT COUNT(*) as total 
                FROM transaction_history 
                WHERE user_id = ? 
                AND type = 'redemption'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $partner_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['total'] ?? 0;
    }
    
    /**
     * Get redemptions for current month
     */
    public function getMonthlyRedemptions($partner_id) {

        $currentMonth = date('Y-m');
        
        $sql = "SELECT COUNT(*) as monthly_total 
                FROM transaction_history 
                WHERE user_id = ? 
                AND type = 'redemption' 
                AND DATE_FORMAT(created_at, '%Y-%m') = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('is', $partner_id, $currentMonth);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['monthly_total'] ?? 0;

    }
    
    /**
     * Calculate redemption growth percentage compared to last month
     */
    public function calculateRedemptionGrowth($partner_id) {
        $currentMonth = date('Y-m');
        $lastMonth = date('Y-m', strtotime('-1 month'));
        
        // Get current month redemptions
        $currentMonthCount = $this->getRedemptionsForMonth($partner_id, $currentMonth);
        
        // Get last month redemptions
        $lastMonthCount = $this->getRedemptionsForMonth($partner_id, $lastMonth);
        
        // Calculate growth percentage
        if ($lastMonthCount == 0) {
            // If last month had 0 redemptions, growth is 100% if current has any, else 0%
            return $currentMonthCount > 0 ? 100 : 0;
        }
        
        $growth = (($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100;
        return round($growth, 2);
    }
    
    /**
     * Helper method to get redemptions for specific month
     */
    public function getRedemptionsForMonth($partner_id, $month) {
        $sql = "SELECT COUNT(*) as count 
                FROM transaction_history 
                WHERE user_id = ? 
                AND type = 'redemption' 
                AND DATE_FORMAT(created_at, '%Y-%m') = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('is', $partner_id, $month);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['count'] ?? 0;
    }
    
    /**
     * Get today's redemptions count
     */
    public function getTodayRedemptions($partner_id) {
        $today = date('Y-m-d');
        
        $sql = "SELECT COUNT(*) as today_total 
                FROM transaction_history 
                WHERE user_id = ? 
                AND type = 'redemption' 
                AND DATE(created_at) = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('is', $partner_id, $today);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['today_total'] ?? 0;
    }
    
    /**
     * Get total processed amount (sum of all completed redemptions)
     */
    public function getTotalProcessed($partner_id) {
        $sql = "SELECT SUM(amount) as total_amount 
                FROM transaction_history 
                WHERE user_id = ? 
                AND type = 'redemption' 
                AND status = 'completed'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $partner_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['total_amount'] ?? 0;
    }
    
    /**
     * Get last withdrawal date from partner_withdrawals table
     */
    public function getLastWithdrawalDate($partner_id) {
        $sql = "SELECT created_at 
                FROM transaction_history 
                WHERE user_id = ? 
                AND status = 'completed'
                AND type = 'withdrawal'
                ORDER BY created_at DESC 
                LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $partner_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['created_at'] ?? null;
    }
    
    /**
     * Get count of unique active customers
     */
    public function getActiveCustomers($partner_id) {
        $sql = "SELECT COUNT(DISTINCT user_id) as unique_customers 
                FROM transaction_history 
                WHERE user_id = ? 
                AND type = 'redemption' 
                AND status = 'completed'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $partner_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['unique_customers'] ?? 0;
    }
    
    /**
     * Get today's revenue from redemptions
     */
    public function getTodayRevenue($partner_id) {

        $today = date('Y-m-d');
        
        $sql = "SELECT SUM(amount) as today_revenue 
                FROM transaction_history 
                WHERE user_id = ? 
                AND type = 'redemption' 
                AND status = 'completed' 
                AND DATE(created_at) = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('is', $partner_id, $today);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['today_revenue'] ?? 0;
    }
    
    /**
     * Get monthly revenue
     */
    public function getMonthlyRevenue($partner_id) {
        $currentMonth = date('Y-m');
        
        $sql = "SELECT SUM(amount) as monthly_revenue 
                FROM transaction_history 
                WHERE user_id = ? 
                AND type = 'redemption' 
                AND status = 'completed' 
                AND DATE_FORMAT(created_at, '%Y-%m') = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('is', $partner_id, $currentMonth);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['monthly_revenue'] ?? 0;
    }
    
    /**
     * Get pending withdrawals amount
     */
    public function getPendingWithdrawals($partner_id) {
        $sql = "SELECT SUM(amount) as pending_amount 
                FROM partner_withdrawals 
                WHERE partner_id = ? 
                AND status = 'pending'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $partner_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row['pending_amount'] ?? 0;
    }
    
    /**
     * Get recent redemptions for the partner
     * 
     * @param int $partner_id Partner ID
     * @param int $limit Number of records to return
     * @return array Recent redemptions
     */
    public function getRecentRedemptions($partner_id, $limit = 10) {
        $sql = "SELECT 
                    th.id,
                    th.user_id,
                    u.first_name as customer_name,
                    u.phone as customer_phone,
                    th.amount,
                    th.points,
                    th.status,
                    th.created_at
                FROM transaction_history th
                LEFT JOIN users u ON th.user_id = u.id
                WHERE th.user_id = ? 
                AND th.type = 'redemption'
                ORDER BY th.created_at DESC 
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ii', $partner_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $redemptions = [];
        
        while ($row = $result->fetch_assoc()) {
            $redemptions[] = $row;
        }
        
        $stmt->close();
        return $redemptions;
    }

    /**
     * Get pending withdrawals count
     * 
     * @param mysqli $db Database connection
     * @return array Withdrawal statistics
     */
    public function getPendingWithdrawalsStats() {
        $stats = [
            'total' => 0,
            'text' => 'Require action'
        ];
        
        try {
            // Get total pending withdrawals
            $query = "SELECT COUNT(*) as count 
                    FROM partner_withdrawals 
                    WHERE status = 'pending'";
            
            $result = $this->db->query($query);
            if ($result) {
                $row = $result->fetch_assoc();
                $stats['total'] = (int)$row['count'];
            }
            
        } catch (Exception $e) {
            error_log("Error calculating withdrawal stats: " . $e->getMessage());
        }
        
        return $stats;
    }

    public function getAllUsers($currentPage, $perPage, $search, $accountType, $status, $dateFrom, $dateTo, $sortBy, $sortOrder) {

        // Calculate offset
        $offset = ($currentPage - 1) * $perPage;
        
        // Build WHERE conditions - Only show partner and user accounts, exclude admin
        $whereConditions = ["acct_type IN ('user')"];
        $params = [];
        $paramTypes = '';
        
        if (!empty($search)) {
            $whereConditions[] = "(first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR phone LIKE ?)";
            $searchTerm = "%$search%";
            $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
            $paramTypes .= 'ssss';
        }
        
        // If a specific account type is selected, override the default filter
        if ($accountType !== 'all') {
            // Remove the default filter and add the specific one
            $whereConditions = array_filter($whereConditions, function($condition) {
                return !str_contains($condition, 'acct_type IN');
            });
            $whereConditions[] = "acct_type = ?";
            $params[] = $accountType;
            $paramTypes .= 's';
        }
        
        if ($status !== 'all') {
            $whereConditions[] = "status = ?";
            $params[] = $status;
            $paramTypes .= 's';
        }
        
        if (!empty($dateFrom)) {
            $whereConditions[] = "DATE(created_at) >= ?";
            $params[] = $dateFrom;
            $paramTypes .= 's';
        }
        
        if (!empty($dateTo)) {
            $whereConditions[] = "DATE(created_at) <= ?";
            $params[] = $dateTo;
            $paramTypes .= 's';
        }
        
        $whereClause = empty($whereConditions) ? '' : 'WHERE ' . implode(' AND ', $whereConditions);
        
        // Validate sort parameters
        $allowedSortColumns = ['first_name', 'last_name', 'email', 'acct_type', 'status', 'points_balance', 'created_at'];
        $sortBy = in_array($sortBy, $allowedSortColumns) ? $sortBy : 'created_at';
        $sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';
        $orderClause = "ORDER BY $sortBy $sortOrder";
        
        // Get total count
        $countQuery = "SELECT COUNT(*) as total FROM users $whereClause";
        $stmt = $this->db->prepare($countQuery);
        
        if (!empty($params)) {
            $stmt->bind_param($paramTypes, ...$params);
        }
        
        $stmt->execute();
        $countResult = $stmt->get_result();
        $totalRow = $countResult->fetch_assoc();
        $totalUsers = $totalRow['total'];
        $stmt->close();
        
        // Calculate pagination
        $totalPages = ceil($totalUsers / $perPage);
        
        // Get users
        $usersQuery = "SELECT id, first_name, last_name, email, phone, acct_type, status, points_balance, created_at 
                    FROM users 
                    $whereClause 
                    $orderClause 
                    LIMIT ? OFFSET ?";
        
        $params[] = $perPage;
        $params[] = $offset;
        $paramTypes .= 'ii';
        
        $stmt = $this->db->prepare($usersQuery);
        $stmt->bind_param($paramTypes, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        $stmt->close();
        
        // Prepare response
        $response = [
            'status' => true,
            'users' => $users,
            'pagination' => [
                'current_page' => $currentPage,
                'per_page' => $perPage,
                'total_users' => $totalUsers,
                'total_pages' => $totalPages,
                'has_previous_page' => $currentPage > 1,
                'has_next_page' => $currentPage < $totalPages,
                'from' => $offset + 1,
                'to' => min($offset + $perPage, $totalUsers)
            ],
            'filters' => [
                'search' => $search,
                'acct_type' => $accountType,
                'status' => $status,
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder
            ]
        ];
        
        return $response;
    }

    public function getAllPartners($currentPage, $perPage, $search, $accountType, $status, $dateFrom, $dateTo, $sortBy, $sortOrder) {

        // Calculate offset
        $offset = ($currentPage - 1) * $perPage;
        
        // Build WHERE conditions - Only show partner and user accounts, exclude admin
        $whereConditions = ["acct_type IN ('partner')"];
        $params = [];
        $paramTypes = '';
        
        if (!empty($search)) {
            $whereConditions[] = "(first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR phone LIKE ?)";
            $searchTerm = "%$search%";
            $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
            $paramTypes .= 'ssss';
        }
        
        // If a specific account type is selected, override the default filter
        if ($accountType !== 'all') {
            // Remove the default filter and add the specific one
            $whereConditions = array_filter($whereConditions, function($condition) {
                return !str_contains($condition, 'acct_type IN');
            });
            $whereConditions[] = "acct_type = ?";
            $params[] = $accountType;
            $paramTypes .= 's';
        }
        
        if ($status !== 'all') {
            $whereConditions[] = "status = ?";
            $params[] = $status;
            $paramTypes .= 's';
        }
        
        if (!empty($dateFrom)) {
            $whereConditions[] = "DATE(created_at) >= ?";
            $params[] = $dateFrom;
            $paramTypes .= 's';
        }
        
        if (!empty($dateTo)) {
            $whereConditions[] = "DATE(created_at) <= ?";
            $params[] = $dateTo;
            $paramTypes .= 's';
        }
        
        $whereClause = empty($whereConditions) ? '' : 'WHERE ' . implode(' AND ', $whereConditions);
        
        // Validate sort parameters
        $allowedSortColumns = ['first_name', 'last_name', 'email', 'status', 'wallet_balance', 'created_at'];
        $sortBy = in_array($sortBy, $allowedSortColumns) ? $sortBy : 'created_at';
        $sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';
        $orderClause = "ORDER BY $sortBy $sortOrder";
        
        // Get total count
        $countQuery = "SELECT COUNT(*) as total FROM users $whereClause";
        $stmt = $this->db->prepare($countQuery);
        
        if (!empty($params)) {
            $stmt->bind_param($paramTypes, ...$params);
        }
        
        $stmt->execute();
        $countResult = $stmt->get_result();
        $totalRow = $countResult->fetch_assoc();
        $totalUsers = $totalRow['total'];
        $stmt->close();
        
        // Calculate pagination
        $totalPages = ceil($totalUsers / $perPage);
        
        // Get users
        $usersQuery = "SELECT id, first_name, last_name, email, phone, acct_type, status, logo, location, wallet_balance, created_at 
                    FROM users 
                    $whereClause 
                    $orderClause 
                    LIMIT ? OFFSET ?";
        
        $params[] = $perPage;
        $params[] = $offset;
        $paramTypes .= 'ii';
        
        $stmt = $this->db->prepare($usersQuery);
        $stmt->bind_param($paramTypes, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $partners = [];
        while ($row = $result->fetch_assoc()) {
            $partners[] = $row;
        }
        $stmt->close();
        
        // Prepare response
        $response = [
            'status' => true,
            'partners' => $partners,
            'pagination' => [
                'current_page' => $currentPage,
                'per_page' => $perPage,
                'total_partners' => $totalUsers,
                'total_pages' => $totalPages,
                'has_previous_page' => $currentPage > 1,
                'has_next_page' => $currentPage < $totalPages,
                'from' => $offset + 1,
                'to' => min($offset + $perPage, $totalUsers)
            ],
            'filters' => [
                'search' => $search,
                'acct_type' => $accountType,
                'status' => $status,
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder
            ]
        ];
        
        return $response;
    }

    public function uploadPartnerLogo($file) {
        $result = [
            'status' => false,
            'message' => '',
            'file_name' => ''
        ];
        
        try {
            // File validation
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            $maxSize = 5 * 1024 * 1024; // 2MB
            
            if (!in_array($file['type'], $allowedTypes)) {
                throw new Exception('Invalid file type. Only JPG, JPEG and PNG are allowed.');
            }
            
            if ($file['size'] > $maxSize) {
                throw new Exception('File size must be less than 2MB.');
            }
            
            // Create upload directory if it doesn't exist
            $uploadDir = __DIR__ . '/../../public/images/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Generate unique filename
            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $uniqueName = uniqid('partner_logo_', true) . '.' . $fileExtension;
            $uploadPath = $uploadDir . $uniqueName;
            
            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                // Create thumbnail version if needed
                
                $result['status'] = true;
                $result['file_name'] = $uniqueName;
                $result['message'] = 'Logo uploaded successfully';

            } else {
                throw new Exception('Failed to upload file. Please try again.');
            }
            
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }

        return $result;

    }

    public function processPartnerRegistration($firstName, $lastName, $email, $phone, $location, $status, $password, $logoUrl){
 
        $response = ['status' => false, 'message' => ''];
        session_start();
        $adminInfo = $this->fetchUserData($_SESSION['orchid_session']);
        
        try {
            // Validate required fields
            if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
                throw new Exception('Please fill in all required fields');
            }
            
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Please enter a valid email address');
            }
            
            // Check if email already exists
            $checkQuery = "SELECT id FROM users WHERE email = ?";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows > 0) {
                throw new Exception('An account with this email already exists');
            }
            $stmt->close();
            
            // Handle logo upload
            $finalLogoPath = '';
            
            // If logo file was uploaded
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->uploadPartnerLogo($_FILES['logo']);
                
                if (!$uploadResult['success']) {
                    throw new Exception($uploadResult['message']);
                }
                
                $finalLogoPath = $uploadResult['file_name'];
            }
        
            
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $date = date('Y-m-d H:i:s');
            
            // Insert into database
            $insertQuery = "INSERT INTO users (
                first_name, 
                last_name, 
                email, 
                phone,
                password_hash,
                status,
                acct_type,
                location,
                logo,
                created_at
            ) VALUES (?, ?, ?, ?, ?, ?, 'partner', ?, ?, ?)";
            
            $stmt = $this->db->prepare($insertQuery);
            $stmt->bind_param(
                'sssssssss',
                $firstName,
                $lastName,
                $email,
                $phone,
                $hashedPassword,
                $status,
                $location,
                $finalLogoPath,                
                $date
            );
            
            if ($stmt->execute()) {

                $partnerId = $stmt->insert_id;
                
                // Log the action
                $logQuery = "INSERT INTO admin_logs (admin_id, action, details, created_at) VALUES (?, 'create_partner', ?, ?)";
                $logStmt = $this->db->prepare($logQuery);
                $logDetails = "Created partner ID: $partnerId, Email: $email";
                $logStmt->bind_param('iss', $adminInfo['id'], $logDetails, $date);
                $logStmt->execute();
                $logStmt->close();
                
                $response['status'] = true;
                $response['message'] = 'Partner created successfully';
                $response['partner_id'] = $partnerId;
    
                    // Replace placeholders
                    $htmlBody = str_replace(
                        ['[Partner Name]', '[Partner Email]', '[Generated Password]'],
                        [htmlspecialchars($firstName . ' ' . $lastName), htmlspecialchars($email), htmlspecialchars($password)],
                        file_get_contents('partner_email_template.php')
                    );

                    // Send welcome email to partner
                    $email_response = $this->sendmail($email, $firstName . ' ' . $lastName,  $htmlBody, 'Welcome to Our Partner Program');
                    //error_log("Partner registration email response: " . json_encode($email_response));

                    return $response;

            } else {
                throw new Exception('Failed to create partner: ' . $stmt->error);
            }
            
            $stmt->close();
            
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            return $response;
        }
    }

    
    public function processPartnerUpdate($partnerId, $firstName, $lastName, $email, $phone, $location) {
        $response = ['status' => false, 'message' => ''];
        session_start();
        $adminInfo = $this->fetchUserData($_SESSION['orchid_session']);
        try{
              // Handle logo upload
            $finalLogoPath = '';
            
            // If logo file was uploaded
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->uploadPartnerLogo($_FILES['logo']);
                
                if (!$uploadResult['status']) {
                    throw new Exception($uploadResult['message']);
                }
                
                $finalLogoPath = $uploadResult['file_name'];
            }
            
            if(!empty($finalLogoPath)){

                $stmt = $this->db->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, logo = ? WHERE id = ?");
                $stmt->bind_param("sssssi", $firstName, $lastName, $email, $phone, $finalLogoPath, $partnerId);
                $result = $stmt->execute();

            }else{

                $stmt = $this->db->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?");
                $stmt->bind_param("ssssi", $firstName, $lastName, $email, $phone, $partnerId);
                $result = $stmt->execute();
            }

            if ($result) {

                $date = date('Y-m-d H:i:s');
                $logQuery = "INSERT INTO admin_logs (admin_id, action, details, created_at) VALUES (?, 'update_partner', ?, ?)";
                $logStmt = $this->db->prepare($logQuery);
                $logDetails = "Updated partner ID: $partnerId, Email: $email";
                $logStmt->bind_param('iss', $adminInfo['id'], $logDetails, $date);
                $logStmt->execute();
                $logStmt->close();
                $response['status'] = true;
                $response['message'] = 'Partner information updated successfully';

                return $response;

            } else {
                throw new Exception('Failed to update partner information: ' . $stmt->error);
            }

        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            return $response;
        }
        
    }

    public function processAccountStatusUpdate($partnerId, $status) {
        $response = ['status' => false, 'message' => ''];
      
        $adminInfo = $this->fetchUserData($_SESSION['orchid_session']);
        $acctInfo = $this->fetchUser($partnerId);
        try{
            $stmt = $this->db->prepare("UPDATE users SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $partnerId);
            $result = $stmt->execute();

            if ($result) {

                $date = date('Y-m-d H:i:s');
                $logQuery = "INSERT INTO admin_logs (admin_id, action, details, created_at) VALUES (?, 'update_account_status', ?, ?)";
                $logStmt = $this->db->prepare($logQuery);
                $logDetails = "Updated account status for partner ID: $partnerId, Email: " . $acctInfo['email'] . " to status: $status";
                $logStmt->bind_param('iss', $adminInfo['id'], $logDetails, $date);
                $logStmt->execute();
                $logStmt->close();
                $response['status'] = true;
                $response['message'] = 'Account status updated successfully';

                return $response;

            } else {
                throw new Exception('Failed to update account status: ' . $stmt->error);
            }

        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            return $response;
        }
    }

    public function processBalanceAdjustment($partnerId, $amount, $type, $reason) {
        $response = ['status' => false, 'message' => ''];
        $adminInfo = $this->fetchUserData($_SESSION['orchid_session']);
        $acctInfo = $this->fetchUser($partnerId);
        try{

            if ($type === 'deduct') {
                $stmt = $this->db->prepare("UPDATE users SET wallet_balance = wallet_balance - ? WHERE id = ?");
            } else if ($type === 'add') {
                $stmt = $this->db->prepare("UPDATE users SET wallet_balance = wallet_balance + ? WHERE id = ?");
            } else if($type === 'set') {
                $stmt = $this->db->prepare("UPDATE users SET wallet_balance = ? WHERE id = ?");
            }
            
            $stmt->bind_param("di", $amount, $partnerId);
            $result = $stmt->execute();

            if ($result) {

                $date = date('Y-m-d H:i:s');
                $logQuery = "INSERT INTO admin_logs (admin_id, action, details, created_at) VALUES (?, 'balance_adjustment', ?, ?)";
                $logStmt = $this->db->prepare($logQuery);
                $logDetails = "Adjusted balance for partner ID: $partnerId, Email: " . $acctInfo['email'] . " by $amount, Reason : $reason";
                $logStmt->bind_param('iss', $adminInfo['id'], $logDetails, $date);
                $logStmt->execute();
                $logStmt->close();
                $response['status'] = true;
                $response['message'] = 'Balance adjusted successfully';
                return $response;

            } else {
                throw new Exception('Failed to adjust balance: ' . $stmt->error);
            }
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            return $response;
        }
    }

    public function processUserUpdate($userId, $firstName, $lastName, $email, $phone) {

        $response = ['status' => false, 'message' => ''];
        session_start();
        $adminInfo = $this->fetchUserData($_SESSION['orchid_session']);
        try{

            $stmt = $this->db->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $firstName, $lastName, $email, $phone, $userId);
            $result = $stmt->execute();
            if ($result) {

                $date = date('Y-m-d H:i:s');
                $logQuery = "INSERT INTO admin_logs (admin_id, action, details, created_at) VALUES
                (?, 'update_user', ?, ?)";
                $logStmt = $this->db->prepare($logQuery);
                $logDetails = "Updated user ID: $userId, Email: $email";
                $logStmt->bind_param('iss', $adminInfo['id'], $logDetails, $date);
                $logStmt->execute();
                $logStmt->close();
                $response['status'] = true;
                $response['message'] = 'User information updated successfully';
                return $response;
            } else {
                throw new Exception('Failed to update user information: ' . $stmt->error);
            }
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            return $response;
        }
    }

    public function processPointConfigurationUpdate($amount, $points, $key) {

        $response = ['status' => false, 'message' => ''];
        session_start();
        $adminInfo = $this->fetchUserData($_SESSION['orchid_session']);
        try{

            $stmt = $this->db->prepare("UPDATE system_settings SET setting_point = ?, setting_amount = ? WHERE setting_key = ?");
            $stmt->bind_param("iis", $points, $amount, $key);
            $result = $stmt->execute();
            if ($result) {

                $date = date('Y-m-d H:i:s');
                $logQuery = "INSERT INTO admin_logs (admin_id, action, details, created_at) VALUES
                (?, 'update_point_configuration', ?, ?)";
                $logStmt = $this->db->prepare($logQuery);
                $logDetails = "Updated point configuration for key: $key, Points: $points, Amount: $amount";
                $logStmt->bind_param('iss', $adminInfo['id'], $logDetails, $date);
                $logStmt->execute();
                $logStmt->close();
                $response['status'] = true;
                $response['message'] = 'Point configuration updated successfully';
                return $response;
            } else {
                throw new Exception('Failed to update point configuration: ' . $stmt->error);
            }
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            return $response;
        }
    }

    public function uploadLogo($partner_id, $files) {
        // Handle file upload
        if (!isset($files['logo'])) {
            return ['status' => false, 'message' => 'No file uploaded'];
        }
        
        $file = $files['logo'];
        
        // Validate file
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($file['type'], $allowed_types)) {
            return ['status' => false, 'message' => 'Invalid file type'];
        }
        
        if ($file['size'] > $max_size) {
            return ['status' => false, 'message' => 'File too large'];
        }
        
        // Generate unique filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'partner_' . $partner_id . '_' . time() . '.' . $ext;
        $upload_dir =  __DIR__ . '/../../public/images/';
        $destination = $upload_dir . $filename;
        
        // Create directory if needed
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $destination)) {
          
            $stmt = $this->db->prepare("UPDATE users SET logo = ? WHERE id = ?");
            $stmt->bind_param('si', $filename, $partner_id);
            
            if ($stmt->execute()) {
                return ['status' => true, 'message' => 'Logo uploaded', 'logo_url' => $destination];
            } else {
                // Delete file if database update fails
                unlink($destination);
                return ['status' => false, 'message' => 'Failed to update database'];
            }
        } else {
            return ['status' => false, 'message' => 'Failed to upload file'];
        }
    }

    public function processRedemptionCodeValidation($code) {
        
        if (empty($code)) {
            echo json_encode(['success' => false, 'message' => 'Redemption code is required']);
            return;
        }
        
        // Query to check code
        $sql = "SELECT 
                    rc.id,
                    rc.code,
                    rc.amount,
                    rc.points,
                    rc.status,
                    u.email as customer_email,
                    rc.amount,
                    CONCAT(u.first_name, ' ', u.last_name) as customer_name
                FROM transaction_history rc
                JOIN users u ON rc.user_id = u.id
                WHERE rc.code = ? 
                AND rc.status = 'pending'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $code);
        $stmt->execute();
        $result = $stmt->get_result();
        $codeData = $result->fetch_assoc();
        
        if ($codeData) {

            return [
                'success' => true,
                'message' => 'Code is valid',
                'code' => $codeData
            ];
            
        } else {
            // Check why code is invalid
            $sql = "SELECT status FROM transaction_history WHERE code = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('s', $code);
            $stmt->execute();
            $result = $stmt->get_result();
            $invalidCode = $result->fetch_assoc();
            
            if ($invalidCode) {
                if ($invalidCode['status'] == 'completed') {
                    $message = 'This code has already been used';
                } else {
                    $message = 'Code is not valid for redemption';
                }
            } else {
                $message = 'Invalid redemption code';
            }
            
            return ['success' => false, 'message' => $message];
        }
    }

    public function fetchActivitylogs($page, $limit, $search, $actions, $admins, $dateFrom, $dateTo) {
        try {
            // Validate limit
            $allowedLimits = [10, 25, 50, 100];
            if (!in_array($limit, $allowedLimits)) {
                $limit = 25;
            }

            // Calculate offset
            $offset = ($page - 1) * $limit;

            // Build WHERE conditions
            $whereConditions = [];
            $queryParams = []; // Fixed: Changed from $params to $queryParams
            $paramTypes = '';

            // Search condition
            if (!empty($search)) {
                $whereConditions[] = "(al.details LIKE CONCAT('%', ?, '%') OR 
                                    CONCAT(a.first_name, ' ', a.last_name) LIKE CONCAT('%', ?, '%') OR 
                                    al.action LIKE CONCAT('%', ?, '%'))";
                $queryParams[] = $search;
                $queryParams[] = $search;
                $queryParams[] = $search;
                $paramTypes .= 'sss';
            }

            // Action filter
            if (!empty($actions) && !in_array('all', $actions)) {
                $actionPlaceholders = implode(',', array_fill(0, count($actions), '?'));
                $whereConditions[] = "al.action IN ($actionPlaceholders)";
                $queryParams = array_merge($queryParams, $actions);
                $paramTypes .= str_repeat('s', count($actions));
            }
            
            // Admin filter
            if (!empty($admins) && !in_array('all', $admins)) {
                $adminPlaceholders = implode(',', array_fill(0, count($admins), '?'));
                $whereConditions[] = "al.admin_id IN ($adminPlaceholders)";
                $queryParams = array_merge($queryParams, $admins);
                $paramTypes .= str_repeat('i', count($admins));
            }
            
            // Date range filter
            if (!empty($dateFrom)) {
                $whereConditions[] = "DATE(al.created_at) >= ?";
                $queryParams[] = $dateFrom;
                $paramTypes .= 's';
            }
            
            if (!empty($dateTo)) {
                $whereConditions[] = "DATE(al.created_at) <= ?";
                $queryParams[] = $dateTo;
                $paramTypes .= 's';
            }
            
            // Build WHERE clause - FIXED HERE
            $whereClause = '';
            if (!empty($whereConditions)) {
                $whereClause = 'WHERE ' . implode(' AND ', $whereConditions);
            }

            //error_log("WHERE Clause: " . $whereClause);
            //error_log("Query Params: " . print_r($queryParams, true));

            // Get total count - FIXED HERE
            $countSql = "SELECT COUNT(*) as total FROM admin_logs al 
                        LEFT JOIN users a ON al.admin_id = a.id ";
            $countSql .= $whereClause;
            
            //error_log("Count SQL: " . $countSql);
            
            $countStmt = $this->db->prepare($countSql);
            
            if (!empty($queryParams)) {
                // We need to bind parameters only if we have a WHERE clause
                $countStmt->bind_param($paramTypes, ...$queryParams);
            }
            
            $countStmt->execute();
            $countResult = $countStmt->get_result();
            $totalRow = $countResult->fetch_assoc();
            $totalActivities = $totalRow['total'];
            
            $countStmt->close();
            
            // Main query - FIXED HERE
            $sql = "SELECT al.id, al.admin_id, CONCAT(a.first_name, ' ', a.last_name) as admin_name, 
                        al.action, al.details, al.created_at 
                    FROM admin_logs al 
                    JOIN users a ON al.admin_id = a.id ";
            $sql .= $whereClause;
            $sql .= " ORDER BY al.created_at DESC 
                    LIMIT ? OFFSET ?";
            
            //error_log("Main SQL: " . $sql);
            
            // Create new arrays for the main query to avoid modifying original params
            $mainQueryParams = $queryParams;
            $mainParamTypes = $paramTypes;
            
            // Add limit and offset to query params
            $mainQueryParams[] = $limit;
            $mainQueryParams[] = $offset;
            $mainParamTypes .= 'ii';
            
            // error_log("Main Query Params: " . print_r($mainQueryParams, true));
            //error_log("Main Param Types: " . $mainParamTypes);
            
            $stmt = $this->db->prepare($sql);
            
            if (!empty($mainQueryParams)) {
                // Bind parameters if we have any (including limit/offset)
                $stmt->bind_param($mainParamTypes, ...$mainQueryParams);
            } else {
                // If no filters, we still need to bind limit and offset
                $stmt->bind_param('ii', $limit, $offset);
            }
            
            $stmt->execute();
            $result = $stmt->get_result();

            $activities = [];
            while ($row = $result->fetch_assoc()) {
                $activities[] = $row;
            }
            
            $stmt->close();

            // Get statistics
            $stats = $this->getStatistics($dateFrom, $dateTo);
            
            // Get filter options (admins list)
            $filters = $this->getFilterOptions();
            
            // Get insights
            $insights = $this->getInsights($dateFrom, $dateTo);

            return [
                'success' => true,
                'activities' => $activities,
                'total' => $totalActivities,
                'page' => $page,
                'limit' => $limit,
                'stats' => $stats,
                'filters' => $filters,
                'insights' => $insights
            ];

        } catch (Exception $e) {
            //error_log("Error in fetchActivitylogs: " . $e->getMessage());
            //error_log("Stack trace: " . $e->getTraceAsString());
            return [
                'success' => false,
                'error' => 'Failed to fetch activity logs: ' . $e->getMessage()
            ];
        }
    }

    public function getStatistics($dateFrom, $dateTo) {
        $stats = [];
        
        // Total activities
        $totalSql = "SELECT COUNT(*) as total FROM admin_logs";
        $totalResult = $this->db->query($totalSql);
        $totalRow = $totalResult->fetch_assoc();
        $stats['total'] = intval($totalRow['total']);
        
        // Today's activities
        $todaySql = "SELECT COUNT(*) as today FROM admin_logs WHERE DATE(created_at) = CURDATE()";
        $todayResult = $this->db->query($todaySql);
        $todayRow = $todayResult->fetch_assoc();
        $stats['today'] = intval($todayRow['today']);
        
        // Most active admin (last 7 days)
        $mostActiveSql = "SELECT 
                            a.id, 
                            CONCAT(a.first_name, ' ', a.last_name) as name,
                            COUNT(*) as activity_count
                        FROM admin_logs al 
                        LEFT JOIN users a ON al.admin_id = a.id 
                        WHERE al.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                        GROUP BY al.admin_id 
                        ORDER BY activity_count DESC 
                        LIMIT 1";
        
        $mostActiveResult = $this->db->query($mostActiveSql);
        if ($mostActiveResult && $mostActiveResult->num_rows > 0) {
            $mostActiveRow = $mostActiveResult->fetch_assoc();
            $stats['most_active_admin'] = [
                'id' => intval($mostActiveRow['id']),
                'name' => $mostActiveRow['name'],
                'count' => intval($mostActiveRow['activity_count'])
            ];
        } else {
            $stats['most_active_admin'] = null;
        }
        
        // Most common action
        $commonActionSql = "SELECT 
                            action, 
                            COUNT(*) as count,
                            ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM admin_logs), 1) as percentage
                            FROM admin_logs 
                            GROUP BY action 
                            ORDER BY count DESC 
                            LIMIT 1";
        
        $commonActionResult = $this->db->query($commonActionSql);
        if ($commonActionResult && $commonActionResult->num_rows > 0) {
            $commonActionRow = $commonActionResult->fetch_assoc();
            
            // Map action to display name
            $actionNames = [
                'create_partner' => 'Create Partner',
                'create_admin' => 'Create Admin',
                'balance_adjustment' => 'Balance Adjustment',
                'update_account_status' => 'Update Account Status',
                'update_user' => 'Update User',
                'update_point_configuration' => 'Update Point Configuration'
            ];
            
            $action = $commonActionRow['action'];
            $displayName = isset($actionNames[$action]) ? $actionNames[$action] : $action;
            
            $stats['most_common_action'] = [
                'name' => $displayName,
                'count' => intval($commonActionRow['count']),
                'percentage' => floatval($commonActionRow['percentage'])
            ];

        } else {
            $stats['most_common_action'] = null;
        }
        
        return $stats;
    }

    public function getFilterOptions() {
        $filters = [];
        
        // Get all admins for filter dropdown
        $adminsSql = "SELECT id, CONCAT(first_name, ' ', last_name) as name, email FROM users WHERE acct_type = 'admin'  ORDER BY name";
        $adminsResult = $this->db->query($adminsSql);
        
        $admins = [];
        while ($row = $adminsResult->fetch_assoc()) {
            $admins[] = [
                'id' => intval($row['id']),
                'name' => $row['name'],
                'email' => $row['email']
            ];
        }
        
        $filters['admins'] = $admins;
        
        return $filters;
    }

    function getInsights($dateFrom = '', $dateTo = '') {

        $insights = [];
        
        // Action distribution
        $distributionSql = "SELECT 
                            action, 
                            COUNT(*) as count,
                            ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM admin_logs), 1) as percentage
                            FROM admin_logs 
                            GROUP BY action 
                            ORDER BY count DESC";
        
        $distributionResult = $this->db->query($distributionSql);
        
        $actionDistribution = [];
        while ($row = $distributionResult->fetch_assoc()) {
            $actionDistribution[$row['action']] = floatval($row['percentage']);
        }
        
        $insights['action_distribution'] = $actionDistribution;
        
        // Recent admins activity (last 24 hours)
        $recentAdminsSql = "SELECT 
                            a.id,
                            CONCAT(a.first_name, ' ', a.last_name) as name,
                            COUNT(*) as activity_count,
                            MAX(al.created_at) as last_activity_time,
                            CASE 
                                WHEN MAX(al.created_at) >= DATE_SUB(NOW(), INTERVAL 15 MINUTE) THEN 'active'
                                ELSE 'inactive'
                            END as status
                            FROM admin_logs al 
                            LEFT JOIN users a ON al.admin_id = a.id 
                            WHERE al.created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
                            GROUP BY al.admin_id 
                            ORDER BY last_activity_time DESC 
                            LIMIT 5";
        
        $recentAdminsResult = $this->db->query($recentAdminsSql);
        
        $recentAdmins = [];
        while ($row = $recentAdminsResult->fetch_assoc()) {
            $lastActivity = new DateTime($row['last_activity_time']);
            $now = new DateTime();
            $interval = $lastActivity->diff($now);
            
            $lastActivityText = '';
            if ($interval->d > 0) {
                $lastActivityText = $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
            } elseif ($interval->h > 0) {
                $lastActivityText = $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
            } elseif ($interval->i > 0) {
                $lastActivityText = $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
            } else {
                $lastActivityText = 'Just now';
            }
            
            $recentAdmins[] = [
                'id' => intval($row['id']),
                'name' => $row['name'],
                'activity_count' => intval($row['activity_count']),
                'status' => $row['status'],
                'last_activity' => $lastActivityText
            ];
        }
        
        $insights['recent_admins'] = $recentAdmins;
        
        // Peak activity hours (last 7 days)
        $peakHoursSql = "SELECT 
                            HOUR(created_at) as hour,
                            COUNT(*) as activity_count
                        FROM admin_logs 
                        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                        GROUP BY HOUR(created_at)
                        ORDER BY activity_count DESC 
                        LIMIT 8";
        
        $peakHoursResult = $this->db->query($peakHoursSql);
        
        $peakHours = [];
        while ($row = $peakHoursResult->fetch_assoc()) {
            $hour = intval($row['hour']);
            $hour12 = date('g:00 A', strtotime($hour . ':00:00'));
            
            $peakHours[] = [
                'hour' => $hour12,
                'activity_count' => intval($row['activity_count'])
            ];
        }
        
        // Sort by hour
        usort($peakHours, function($a, $b) {
            return strtotime($a['hour']) - strtotime($b['hour']);
        });
        
        $insights['peak_hours'] = $peakHours;
        
        return $insights;
    }

    public function fetchWithdrawalRequests($page, $limit, $search, $status, $dateFilter) {
        try {
            // Validate limit
            $allowedLimits = [10, 25, 50];
            if (!in_array($limit, $allowedLimits)) {
                $limit = 10;
            }

            // Build WHERE conditions
            $whereConditions = [];
            $queryParams = [];
            $paramTypes = '';
            
            // Always filter by type = 'withdrawal'
            $whereConditions[] = "w.type = 'withdrawal'";
            
            // Search condition
            if (!empty($search)) {
                $whereConditions[] = "(w.reference LIKE CONCAT('%', ?, '%') OR 
                                    CONCAT(u.first_name, ' ', u.last_name) LIKE CONCAT('%', ?, '%') OR 
                                    u.email LIKE CONCAT('%', ?, '%') OR 
                                    w.description LIKE CONCAT('%', ?, '%'))";
                $queryParams[] = $search;
                $queryParams[] = $search;
                $queryParams[] = $search;
                $queryParams[] = $search;
                $paramTypes .= 'ssss';
            }
            
            // Status filter
            if (!empty($status)) {
                $whereConditions[] = "w.status = ?";
                $queryParams[] = $status;
                $paramTypes .= 's';
            }

            // Date filter
            if (!empty($dateFilter)) {
                $today = date('Y-m-d');
                switch ($dateFilter) {
                    case 'today':
                        $whereConditions[] = "DATE(w.created_at) = ?";
                        $queryParams[] = $today;
                        $paramTypes .= 's';
                        break;
                    case 'week':
                        $whereConditions[] = "w.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
                        break;
                    case 'month':
                        $whereConditions[] = "w.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
                        break;
                    case 'older':
                        $whereConditions[] = "w.created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)";
                        break;
                }
            }

            // Combine WHERE conditions
            $whereClause = '';
            if (!empty($whereConditions)) {
                $whereClause = 'WHERE ' . implode(' AND ', $whereConditions);
            }

            // Get total count
            $countSql = "SELECT COUNT(*) as total FROM transaction_history w 
                        LEFT JOIN users u ON w.user_id = u.id $whereClause";
            
            // Create a copy of query params for count query
            $countParams = $queryParams;
            $countParamTypes = $paramTypes;
            
            if (!empty($countParams)) {
                $countStmt = $this->db->prepare($countSql);
                $countStmt->bind_param($countParamTypes, ...$countParams);
                $countStmt->execute();
                $countResult = $countStmt->get_result();
            } else {
                $countResult = $this->db->query($countSql);
            }
            
            $totalRow = $countResult->fetch_assoc();
            $totalWithdrawals = $totalRow['total'];
            
            if (isset($countStmt)) {
                $countStmt->close();
            }
            
            // Main query for withdrawals
            $sql = "SELECT 
                        w.id,
                        w.user_id,
                        CONCAT(u.first_name, ' ', u.last_name) as user_name,
                        u.email as user_email,
                        w.amount,
                        w.status,
                        w.reference,
                        w.description,
                        w.created_at
                    FROM transaction_history w 
                    LEFT JOIN users u ON w.user_id = u.id 
                    $whereClause 
                    ORDER BY w.created_at DESC 
                    LIMIT ? OFFSET ?";
            
            // Add limit and offset to query params
            $offset = ($page - 1) * $limit;
            
            // We need to add limit/offset parameters to the existing parameters
            $mainQueryParams = $queryParams;  // Copy existing params
            $mainParamTypes = $paramTypes;    // Copy existing param types
            
            // Add limit and offset
            $mainQueryParams[] = $limit;
            $mainQueryParams[] = $offset;
            $mainParamTypes .= 'ii';
            
            $stmt = $this->db->prepare($sql);
            
            if (!empty($mainQueryParams)) {
                // Bind all parameters including limit/offset
                $stmt->bind_param($mainParamTypes, ...$mainQueryParams);
            }
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            $withdrawals = [];
            while ($row = $result->fetch_assoc()) {
                $withdrawals[] = $row;
            }
            
            $stmt->close();
            
            // Get statistics
            $stats = $this->getWithdrawalStatistics();
            
            // Get financial summary
            $financialSummary = $this->getFinancialSummary();
            
            // Get recent activity
            $recentActivity = $this->getWithdrawalRecentActivity();
            
            // Get progress
            $progress = $this->getWithdrawalProgress();
            
            // Prepare response
            $response = [
                'status' => true,
                'withdrawals' => $withdrawals,
                'total' => $totalWithdrawals,
                'page' => $page,
                'limit' => $limit,
                'stats' => $stats,
                'financial_summary' => $financialSummary,
                'recent_activity' => $recentActivity,
                'progress' => $progress
            ];
            
            return $response;
            
        } catch (Exception $e) {
            error_log("Error in fetchWithdrawalRequests: " . $e->getMessage());
            return [
                'status' => false,
                'error' => 'Server error: ' . $e->getMessage()
            ];
        }
    }

    public function getWithdrawalRecentActivity() {
        $activities = [];
        
        $sql = "SELECT 
                    w.id,
                    w.reference,
                    w.amount,
                    w.status,
                    w.created_at,
                    CONCAT(u.first_name, ' ', u.last_name) as user_name
                FROM transaction_history w 
                LEFT JOIN users u ON w.user_id = u.id WHERE w.type = 'withdrawal'
                ORDER BY w.created_at DESC 
                LIMIT 5";
        
        $result = $this->db->query($sql);
        
        while ($row = $result->fetch_assoc()) {
            $status = $row['status'];
            $title = '';
            $description = '';
            
            switch ($status) {
                case 'completed':
                    $title = 'Withdrawal Completed';
                    $description = "Request {$row['reference']} - $" . number_format($row['amount'], 2);
                    break;
                case 'pending':
                    $title = 'New Withdrawal Request';
                    $description = "Request {$row['reference']} - $" . number_format($row['amount'], 2);
                    break;
                case 'processing':
                    $title = 'Payment Processing';
                    $description = "Request {$row['reference']} - $" . number_format($row['amount'], 2);
                    break;
                case 'cancelled':
                    $title = 'Withdrawal Cancelled';
                    $description = "Request {$row['reference']} - $" . number_format($row['amount'], 2);
                    break;
            }
            
            // Calculate time ago
            $createdAt = new DateTime($row['created_at']);
            $now = new DateTime();
            $interval = $createdAt->diff($now);
            
            $timeAgo = '';
            if ($interval->d > 0) {
                $timeAgo = $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
            } elseif ($interval->h > 0) {
                $timeAgo = $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
            } elseif ($interval->i > 0) {
                $timeAgo = $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
            } else {
                $timeAgo = 'Just now';
            }
            
            $activities[] = [
                'title' => $title,
                'description' => $description,
                'status' => $status,
                'time_ago' => $timeAgo
            ];
        }
        
        return $activities;
    }

    function getFinancialSummary() {
        $summary = [];
        $today = date('Y-m-d');
        $firstDayOfMonth = date('Y-m-01');
        
        // Total processed this month
        $processedSql = "SELECT COALESCE(SUM(amount), 0) as total 
                        FROM transaction_history 
                        WHERE type = 'withdrawal' AND status = 'completed' 
                        AND created_at >= '$firstDayOfMonth'";
        $processedResult = $this->db->query($processedSql);
        $processedRow = $processedResult->fetch_assoc();
        $summary['total_processed'] = number_format(floatval($processedRow['total']), 2);
        
        // Pending amount
        $pendingSql = "SELECT COALESCE(SUM(amount), 0) as total 
                    FROM transaction_history  WHERE type = 'withdrawal' AND status = 'pending'";
        $pendingResult = $this->db->query($pendingSql);
        $pendingRow = $pendingResult->fetch_assoc();
        $summary['pending_amount'] = number_format(floatval($pendingRow['total']), 2);
        
        // Cancelled amount this month
        $cancelledSql = "SELECT COALESCE(SUM(amount), 0) as total 
                        FROM transaction_history 
                        WHERE type = 'withdrawal' AND status = 'cancelled' 
                        AND created_at >= '$firstDayOfMonth'";
        $cancelledResult = $this->db->query($cancelledSql);
        $cancelledRow = $cancelledResult->fetch_assoc();
        $summary['cancelled_amount'] = number_format(floatval($cancelledRow['total']), 2);
        
        // Net processed
        $summary['net_processed'] = number_format(floatval($processedRow['total']), 2);
        
        return $summary;
    }


    public function getWithdrawalStatistics() {
        $stats = [];
        
        // Pending count
        $pendingSql = "SELECT COUNT(*) as count, SUM(amount) as total_amount 
                    FROM transaction_history WHERE type = 'withdrawal' AND status = 'pending'";
        $pendingResult = $this->db->query($pendingSql);
        $pendingRow = $pendingResult->fetch_assoc();
        $stats['pending_count'] = intval($pendingRow['count']);
        $stats['total_pending_amount'] = floatval($pendingRow['total_amount'] ?? 0);
        
        // Completed this week
        $weekSql = "SELECT COUNT(*) as count FROM transaction_history 
                    WHERE type = 'withdrawal' AND status = 'completed' 
                    AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        $weekResult = $this->db->query($weekSql);
        $weekRow = $weekResult->fetch_assoc();
        $stats['completed_this_week'] = intval($weekRow['count']);
        
        // Average processing time
        $avgSql = "SELECT AVG(DATEDIFF(updated_at, created_at)) as avg_days 
                FROM transaction_history 
                WHERE type = 'withdrawal' AND status = 'completed'";
        $avgResult = $this->db->query($avgSql);
        $avgRow = $avgResult->fetch_assoc();
        $stats['avg_processing_time'] = round(floatval($avgRow['avg_days'] ?? 0), 1);
        
        return $stats;
    }
    public function getWithdrawalProgress() {
        $progress = [];
        
        // Get total requests this week
        $weekStart = date('Y-m-d', strtotime('last monday'));
        $weekEnd = date('Y-m-d', strtotime('next sunday'));
        
        $totalSql = "SELECT COUNT(*) as total FROM transaction_history 
                    WHERE type = 'withdrawal' AND created_at BETWEEN '$weekStart' AND '$weekEnd'";
        $totalResult = $this->db->query($totalSql);
        $totalRow = $totalResult->fetch_assoc();
        $total = intval($totalRow['total']);
        
        // Get processed requests this week
        $processedSql = "SELECT COUNT(*) as processed FROM transaction_history 
                        WHERE type = 'withdrawal' AND status = 'completed' 
                        AND created_at BETWEEN '$weekStart' AND '$weekEnd'";
        $processedResult = $this->db->query($processedSql);
        $processedRow = $processedResult->fetch_assoc();
        $processed = intval($processedRow['processed']);
        
        // Calculate percentage
        $percent = $total > 0 ? round(($processed / $total) * 100) : 0;
        
        $progress['total'] = $total;
        $progress['processed'] = $processed;
        $progress['percent'] = $percent;
        
        return $progress;
    }
    public function pointAwardsStats() {
        try {

            $today = date('Y-m-d');
            $firstDayOfMonth = date('Y-m-01');
            
            // Today's awards
            $todaySql = "SELECT COUNT(*) as awards, SUM(amount) as amount 
                        FROM transaction_history 
                        WHERE type = 'point_award' AND DATE(created_at) = '$today'";
            $todayResult = $this->db->query($todaySql);
            $todayRow = $todayResult->fetch_assoc();
            
            // Monthly points
            $monthlySql = "SELECT SUM(points) as points, COUNT(DISTINCT user_id) as customers 
                        FROM transaction_history 
                        WHERE type = 'point_award' AND created_at >= '$firstDayOfMonth'";
            $monthlyResult = $this->db->query($monthlySql);
            $monthlyRow = $monthlyResult->fetch_assoc();
            
            // Active customers
            $activeSql = "SELECT COUNT(DISTINCT user_id) as active 
                        FROM transaction_history 
                        WHERE type = 'point_award' AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
            $activeResult = $this->db->query($activeSql);
            $activeRow = $activeResult->fetch_assoc();
            
            // New customers this month
            $newSql = "SELECT COUNT(DISTINCT user_id) as new 
                    FROM transaction_history 
                    WHERE type = 'point_award' 
                    AND user_id NOT IN (
                        SELECT DISTINCT user_id FROM transaction_history 
                        WHERE type = 'point_award' AND created_at < '$firstDayOfMonth'
                    )
                    AND created_at >= '$firstDayOfMonth'";
            $newResult = $this->db->query($newSql);
            $newRow = $newResult->fetch_assoc();
            
            // Average purchase
            $avgSql = "SELECT AVG(amount) as avg_amount 
                    FROM transaction_history 
                    WHERE type = 'point_award' AND created_at >= '$firstDayOfMonth'";
            $avgResult = $this->db->query($avgSql);
            $avgRow = $avgResult->fetch_assoc();
            
            return [
                'today_awards' => intval($todayRow['awards'] ?? 0),
                'today_amount' => floatval($todayRow['amount'] ?? 0),
                'monthly_points' => intval($monthlyRow['points'] ?? 0),
                'monthly_customers' => intval($monthlyRow['customers'] ?? 0),
                'active_customers' => intval($activeRow['active'] ?? 0),
                'new_customers_month' => intval($newRow['new'] ?? 0),
                'avg_purchase' => floatval($avgRow['avg_amount'] ?? 0)
            ];
            
            
            
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => 'An error occurred: ' . $e->getMessage()];
        } 
    }

    public function processPointAwardRequest($admin_id, $points, $amount, $user_email) {
        try {

            $checkEmail = $this->fetchUserData($user_email);
            if (!$checkEmail) {
                throw new Exception("Email does not exist.");
            }

            $reference = 'PA-' . date('Ymd') . '-' . strtoupper(uniqid());
            $userdescription = "Point award for the purchase of $amount bread. Points: $points";
            $title = "Point award";

            $stmt = $this->db->prepare("INSERT INTO transaction_history (user_id, title, amount, points, type, reference, description) VALUES (?, ?, ?, ?, 'point_award', ?, ?)");
            $stmt->bind_param("isdiss", $checkEmail['id'], $title, $amount, $points, $reference, $userdescription);
            $result = $stmt->execute();

            //Insert into admin logs too
            $date = date('Y-m-d H:i:s');
            $logQuery = "INSERT INTO admin_logs (admin_id, action, details, created_at) VALUES
            (?, 'process_point_awards', ?, ?)";
            $logStmt = $this->db->prepare($logQuery);
            $logDetails = "Processed point awards for email: $user_email, Points: $points, Amount: $amount";
            $logStmt->bind_param('iss', $admin_id, $logDetails, $date);
            $logStmt->execute();
            $logStmt->close();

            $fetchUser = $this->fetchUserData($user_email);
            $new_balance = $fetchUser['points_balance'] + $points;
            $stmt = $this->db->prepare("UPDATE users SET points_balance = points_balance + ? WHERE email = ?");
            $stmt->bind_param("is", $points, $user_email);
            $result = $stmt->execute();

            $data = [
                "user_email" => $user_email,
                "points_awarded" => $points,
                "user_name" => $fetchUser['first_name']. ' ' . $fetchUser['last_name'],
                'new_balance' => $new_balance
            ];

            if ($result) {
                return ['status' => true, 'message' => 'Points awarded successfully.', 'data' => $data];
            } else {
                throw new Exception("Failed to award points. Please try again.");
            }

        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => 'An error occurred: ' . $e->getMessage()];
        }
    }

    function fetchAdminUsersWithPermissions(){
            $sql = "SELECT 
                    u.id,
                    CONCAT(u.first_name, ' ', u.last_name) as name,
                    u.email,
                    u.status,
                    u.isAdmin
                FROM users u
                WHERE u.acct_type = 'admin'
                ORDER BY u.first_name, u.last_name";
        
        $result = $this->db->query($sql);
        
        $admins = [];
        while ($row = $result->fetch_assoc()) {
            $admin = [
                'id' => intval($row['id']),
                'name' => $row['name'],
                'email' => $row['email'],
                'status' => $row['status'],
                'isAdmin' => boolval($row['isAdmin'])
            ];
            
            // Get permissions for this admin
            $permissionSql = "SELECT 
                                p.id,
                                p.name,
                                p.permission_key,
                                CASE WHEN rp.permission_id IS NOT NULL THEN 1 ELSE 0 END as active
                            FROM permissions p
                            LEFT JOIN role_permission rp ON p.id = rp.permission_id AND rp.user_id = ?
                            ORDER BY p.name";
            
            $permissionStmt = $this->db->prepare($permissionSql);
            $permissionStmt->bind_param('i', $row['id']);
            $permissionStmt->execute();
            $permissionResult = $permissionStmt->get_result();
            
            $permissions = [];
            while ($permRow = $permissionResult->fetch_assoc()) {
                $permissions[] = [
                    'id' => intval($permRow['id']),
                    'name' => $permRow['name'],
                    'permission_key' => $permRow['permission_key'],
                    'active' => boolval($permRow['active'])
                ];
            }
            
            $permissionStmt->close();
            $admin['permissions'] = $permissions;
            $admins[] = $admin;
        }

        return $admins;
    }

    public function processPermissionUpdate($admin_id, $user_id, $permission_id, $active) {
        try {
            $this->db->begin_transaction();
            
            if ($active) {
                // Grant permission
                $sql = "INSERT INTO role_permission (user_id, permission_id) 
                        VALUES (?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param('ii', $user_id, $permission_id);
            } else {
                // Revoke permission
                $sql = "DELETE FROM role_permission WHERE user_id = ? AND permission_id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param('ii', $user_id, $permission_id);
            }
            
            $stmt->execute();
            $stmt->close();
            
            // Log the action
            $action = $active ? 'grant' : 'revoke';
            $logSql = "INSERT INTO admin_logs (admin_id, action, details) 
                    VALUES (?, 'permission_$action', ?)";
            $logStmt = $this->db->prepare($logSql);

            $fetchadmin = $this->fetchUser(intval($admin_id));
            $fetch_user = $this->fetchUser(intval($user_id));
            $fetch_perm = $this->fetchpermissiondetails($permission_id);

            $admin_name = $fetchadmin['first_name'] . ' ' . $fetchadmin['last_name'];
            $user_name = $fetch_user['first_name'] . ' ' . $fetch_user['last_name'];
            $perm_name = $fetch_perm['name'];
            $logDetails = ucfirst($action) . "ed '$perm_name' permission for $user_name";

            $logStmt->bind_param('is', $admin_id, $logDetails);
            $logStmt->execute();
            $logStmt->close();
            
            $this->db->commit();

            return ['status' => true, 'message' => 'Permission updated successfully.'];
            
            return [
                'status' => true,
                'message' => 'Permission updated successfully'
            ];
            
        } catch (Exception $e) {
            $this->db->rollback();
            return [
                'status' => false,
                'error' => 'Server error: ' . $e->getMessage()
            ];
        } 
    }

    public function checkVerificationCode($email) {
        date_default_timezone_set('Africa/Lagos');
        $currentTime = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("SELECT * FROM forgot_codes WHERE email = ? AND expires_at > ?");
        $stmt->bind_param("ss", $email, $currentTime);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){

            return [
                'status' => true,
                'message' => 'You still have an active verification code',
                'countdown' => $remainingSeconds = strtotime($result->fetch_assoc()['expires_at']) - strtotime($currentTime)
            ];

        }

        return [
            'status' => false
        ];
    }

    public function processconfirmVerificationCode($email, $code) {
        date_default_timezone_set('Africa/Lagos');
        $currentTime = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("SELECT * FROM forgot_codes WHERE email = ? AND code = ? AND expires_at > ?");
        $stmt->bind_param("sss", $email, $code, $currentTime);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return [
                'status' => true,
                'message' => 'Email verified successfully!',
            ];
        }

        return [
            'status' => false,
            'message' => 'Invalid verification code'
        ];
    }

    public function processEmailVerificationRequest($email) {
        //set to africa
        date_default_timezone_set('Africa/Lagos');
        $expiresAt = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        $currentTime = date('Y-m-d H:i:s');
        $verificationCode = rand(100000, 999999);

        $checkEmail = $this->checkEmail($email);
        if (!$checkEmail) {
            return ['status' => false, 'message' => 'Email does not exist'];
        }

        $user = $this->fetchUser($email);
        $first_name = $user['first_name'];
        $last_name = $user['last_name'];

        //check if code exist
        $checkCode = $this->checkVerificationCode($email);
        if ($checkCode['status']) {
            return $checkCode;
        }
        // Split the code into individual digits
        $codeDigits = str_split((string)$verificationCode);
        
        $stmt = $this->db->prepare("INSERT INTO forgot_codes (email, code, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $verificationCode, $expiresAt);
        $stmt->execute();
        $stmt->close();
        
        $body = str_replace(['[Customer Name]', '[DIGIT_1]', '[DIGIT_2]', '[DIGIT_3]', '[DIGIT_4]', '[DIGIT_5]', '[DIGIT_6]'],[$first_name.' '.$last_name, $codeDigits[0], $codeDigits[1], $codeDigits[2], $codeDigits[3], $codeDigits[4], $codeDigits[5]], file_get_contents('forgotpassword_email_template.php'));
        $sendmail = $this->sendmail($email, $first_name.' '.$last_name, $body, 'Email Verification Code');
        error_log(json_encode($sendmail));
        $remainingSeconds = strtotime($expiresAt) - strtotime($currentTime);

        return [
            'status' => true,
            'message' => 'Verification code sent successfully',
            'countdown' => $remainingSeconds
        ];

    }

    public function processForgotPasswordResetRequest($email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);
        $stmt->execute();
        $stmt->close();
        return [
            'status' => true,
            'message' => 'Password reset successfully'
        ];
    }

    public function processCreateAdmin($first_name, $last_name, $email) {
        $stmt = $this->db->prepare("INSERT INTO users (first_name, last_name, email, acct_type, status) VALUES (?, ?, ?, 'admin', 'active')");
        $stmt->bind_param("sss", $first_name, $last_name, $email);
        $stmt->execute();
        $stmt->close();
        return [
            'status' => true,
            'message' => 'Admin created successfully'
        ];
    }

    public function checkPermissionRole(int $user_id, string $permission_key): bool
    {
        // 1. Get permission ID from permission_key
        $permSql = "SELECT id FROM permissions WHERE permission_key = ? LIMIT 1";
        $permStmt = $this->db->prepare($permSql);
        $permStmt->bind_param("s", $permission_key);
        $permStmt->execute();
        $permResult = $permStmt->get_result();

        if ($permResult->num_rows === 0) {
            // Permission does not exist
            $permStmt->close();
            return false;
        }

        $permission = $permResult->fetch_assoc();
        $permission_id = (int)$permission['id'];
        $permStmt->close();

        // 2. Check if user has this permission
        $checkSql = "
            SELECT 1
            FROM role_permission
            WHERE user_id = ?
            AND permission_id = ?
            LIMIT 1
        ";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->bind_param("ii", $user_id, $permission_id);
        $checkStmt->execute();
        $checkStmt->store_result();

        $hasPermission = $checkStmt->num_rows > 0;
        $checkStmt->close();

        return $hasPermission;
    }

    public function processPointRedeem($user_id, $points, $amount){
        
        $stmt = $this->db->prepare("UPDATE users SET points_balance = points_balance - ? WHERE id = ?");
        $stmt->bind_param("ss", $points, $user_id);
        $stmt->execute();
        $stmt->close();

        $reference = 'PR-' . date('Ymd') . '-' . strtoupper(uniqid());
        $redeemcode = 'OR-' . rand(100000, 999999);
        $description = "Points redeemed for ₦$amount. Points: $points, your redemption code is $redeemcode";
        //Help generate a redeem code, not too long
        
        $title = "Point Redeem";

        //Insert into history
        $stmt = $this->db->prepare("INSERT INTO transaction_history (user_id, title, points, amount, type, code, status, reference, description) VALUES (?, ?, ?, ?, 'point_redeem', ?, 'pending', ?, ?)");
        $stmt->bind_param("issssss", $user_id, $title, $points, $amount, $redeemcode, $reference, $description);
        $stmt->execute();
        $stmt->close();
        return [
            'status' => true,
            'message' => 'Points redeemed successfully',
            'code' => $redeemcode
        ];

    }

    public function processCodeRedemption($user_id, $amount, $points, $code_id, $code, $new_wallet_balance){

        //Check if the code exists
        $stmt = $this->db->prepare("SELECT * FROM transaction_history WHERE id = ? AND status = 'pending'");
        $stmt->bind_param("s", $code_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows === 0) {
            return [
                'status' => false,
                'message' => 'Code does not exist or has already been redeemed'
            ];
        }

        $stmt = $this->db->prepare("UPDATE users SET wallet_balance = wallet_balance + ? WHERE id = ?");
        $stmt->bind_param("ss", $amount, $user_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $this->db->prepare("UPDATE transaction_history SET status = 'completed' WHERE id = ?");
        $stmt->bind_param("s", $code_id);
        $stmt->execute();
        $stmt->close();

        //Insert transaction history
        $reference = 'CR-' . date('Ymd') . '-' . strtoupper(uniqid());
        $description = "Code redeemed for ₦$amount. Points: $points";
        //Help generate a redeem code, not too long
        $title = "Code Redemption";

        //Insert into history
        $stmt = $this->db->prepare("INSERT INTO transaction_history (user_id, title, amount, type, code, status, reference, description) VALUES (?, ?, ?, 'redemption', ?, 'completed', ?, ?)");
        $stmt->bind_param("isssss", $user_id, $title, $amount, $code, $reference, $description);
        $stmt->execute();
        $stmt->close();

        return [
            'status' => true,
            'message' => 'Code redeemed successfully',
            'new_balance' => $new_wallet_balance
        ];
    }

    public function fetchRecentRegistrations(){
        $stmt = $this->db->prepare("SELECT * FROM users ORDER BY created_at DESC LIMIT 5");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function fetchRecentActivity(){
        $stmt = $this->db->prepare("SELECT u.id, u.first_name, u.last_name, th.created_at, th.type, th.points, th.status FROM transaction_history th LEFT JOIN users u ON th.user_id = u.id ORDER BY th.created_at DESC LIMIT 5");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }



    
}
    
