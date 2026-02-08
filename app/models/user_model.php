<?php

class UserModel {
    private $db, $coreModel;

    public function __construct($db) {
        $this->db = $db;
        $this->coreModel = new CoreModel($db);
    }

    public function processRegistration($first_name, $last_name, $email, $password, $phone){
        try{
            //Check if email exist
            if($this->coreModel->checkEmail($email)){
                throw new Exception("Email already exists. Please use a different email.");
            }

            if($this->coreModel->checkPhone($phone)){
                throw new Exception("Phone number already exists. Please use a different phone number.");
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                throw new Exception("Invalid email format.");
            }

            if(!preg_match("/^[a-zA-Z'-]+$/", $first_name)){
                throw new Exception("First name can only contain letters, apostrophes, and hyphens.");
            }

            if(!preg_match("/^[a-zA-Z'-]+$/", $last_name)){
                throw new Exception("Last name can only contain letters, apostrophes, and hyphens.");
            }

            if(!preg_match("/^[0-9]{11}$/", $phone)){
                throw new Exception("Phone number must be 11 digits.");
            }

            //Sanitize input
            $first_name = $this->coreModel->sanitizeInput($first_name);
            $last_name = $this->coreModel->sanitizeInput($last_name);
            $email = $this->coreModel->sanitizeInput($email);
            $phone = $this->coreModel->sanitizeInput($phone);
            $password = $this->coreModel->sanitizeInput($password);

            //Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            //Insert user into database
            $stmt = $this->db->prepare("INSERT INTO users (first_name, last_name, email, phone, password_hash) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $hashedPassword);
            if($stmt->execute()){

                $activation_link = $this->coreModel->getCurrentUrl() . "/activate_account?userid=" . urlencode($email);
                $body = str_replace(['[Customer Name]', '[ACTIVATION_LINK]'],[$first_name.' '.$last_name, $activation_link], file_get_contents('account_activation_template.php'));
                $subject = 'Welcome to Orchid Bakery - Verify Your Email Address';
            
                $this->coreModel->sendmail($email, $first_name.' '.$last_name, $body, $subject);

                return['status' => true, 'message' => 'Registration successful. Please check your email to verify your account.'];

            } else {
                throw new Exception("Registration failed. Please try again.");
            }
            
        } catch (Exception $e){
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function processLogin($email, $password){
        try{
            //Check if email exist
            if(!$this->coreModel->checkEmail($email)){
                throw new Exception("Email does not exist.");
            }

            //Sanitize input
            $email = $this->coreModel->sanitizeInput($email);
            $password = $this->coreModel->sanitizeInput($password);
            $fetchuserdetails = $this->coreModel->fetchUserData($email);
            $hashedPassword = $fetchuserdetails['password_hash'];

            if(!$fetchuserdetails){
                throw new Exception("User details could not be fetched.");
            }

            if($fetchuserdetails['status'] !== 'active'){
                throw new Exception("Account is not active. Please activate your account.");
            }

            //Verify password
            if(password_verify($password, $hashedPassword)){
                return ['status' => true, 'message' => 'Login successful.', 'user' => $fetchuserdetails, 'user_type' => $fetchuserdetails['acct_type']];
            } else {
                throw new Exception("Incorrect password.");
            }

        } catch (Exception $e){
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function processProfileUpdate($email, $first_name, $last_name, $phone, $location){
        try{
            //Sanitize input
            $email = $this->coreModel->sanitizeInput($email);
            $first_name = $this->coreModel->sanitizeInput($first_name);
            $last_name = $this->coreModel->sanitizeInput($last_name);
            $phone = $this->coreModel->sanitizeInput($phone);
            $location = $this->coreModel->sanitizeInput($location);

            if(!preg_match("/^[a-zA-Z'-]+$/", $first_name)){
                throw new Exception("First name can only contain letters, apostrophes, and hyphens.");
            }

            if(!preg_match("/^[a-zA-Z'-]+$/", $last_name)){
                throw new Exception("Last name can only contain letters, apostrophes, and hyphens.");
            }

            if(isset($location) && !empty($location)){
                $stmt = $this->db->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ?, location = ? WHERE email = ?");
                $stmt->bind_param("sssss", $first_name, $last_name, $phone, $location, $email);
            } else {
                $stmt = $this->db->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ? WHERE email = ?");
                $stmt->bind_param("ssss", $first_name, $last_name, $phone, $email);
            }

            if($stmt->execute()){
                return ['status' => true, 'message' => 'Profile updated successfully.'];
            } else {
                throw new Exception("Profile update failed. Please try again.");
            }

        } catch (Exception $e){
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function processPasswordChange($email, $current_password, $new_password){
        try{
            //Sanitize input
            $email = $this->coreModel->sanitizeInput($email);
            $current_password = $this->coreModel->sanitizeInput($current_password);
            $new_password = $this->coreModel->sanitizeInput($new_password);

            $fetchuserdetails = $this->coreModel->fetchUserData($email);
            $hashedPassword = $fetchuserdetails['password_hash'];

            if(!$fetchuserdetails){
                throw new Exception("User details could not be fetched.");
            }

            //Verify current password
            if(!password_verify($current_password, $hashedPassword)){
                throw new Exception("Current password is incorrect.");
            }

            //Hash the new password
            $new_hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);

            //Update password in database
            $stmt = $this->db->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
            $stmt->bind_param("ss", $new_hashedPassword, $email);
            if($stmt->execute()){
                return ['status' => true, 'message' => 'Password changed successfully.'];
            } else {
                throw new Exception("Password change failed. Please try again.");
            }

        } catch (Exception $e){
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
       
}
