<?php
if (!defined('MAX_IMAGE_SIZE')) {
    define('MAX_IMAGE_SIZE', 5000000);
}
class Setting {
    private $istanetModel;
    private $settingModel;

    function __construct(){
        $this->settingModel = new SettingDB();
        $this->istanetModel = new IstanetDB();
    }

    /* Start Show Profile Infos */
    function profilePreview($userid){
        $query = $this->settingModel->getUserInfo($userid);
        $data['profileImage'] = "profile.png";
        $data['facebook'] = "";
        $data['whatsapp'] = "";
        $data['email'] = "";
        if ($query->rowCount() > 0) {
            $userProfile = $query->fetch(PDO::FETCH_ASSOC);
            $data['profileImage'] = $userProfile['image'];
            $data['facebook'] = $userProfile['facebook'];
            $data['whatsapp'] = $userProfile['whatsapp'];
            $data['email'] = $userProfile['email'];
        }
        $userInfos = $this->istanetModel->getIstanetUserInfo($userid);

        if ($userInfos['filliere'] == 'dev') {
            $filliere = 'Développement Digitale';
        }
        if ($userInfos['filliere'] == 'inf') {
            $filliere = 'Infrastructure Digitale';
        }

        $data['userName'] = $userInfos['name'];
        $data['filliere'] = $filliere;
        $data['groupe'] = $userInfos['groupe'];
        
        View::load('setting/Preview', $data);
    }
    /* Start Show Profile Infos */

    /* Start Change Profile Image */
    function changeProfileImage(){
        global $userid;
        $image = $_FILES['image'];
        $password = $_POST['password'];

        if ($this->istanetModel->checkPassword($userid, $password) > 0) {

            $imageUplName = $image['name'];
            $imageTmpName = $image['tmp_name'];
            $imageSize = $image['size'];
            $imageType = $image['type'];
    
            $imageAllowedTypes = ["image/jpg","image/jpeg","image/png"];
    
            if (in_array($imageType, $imageAllowedTypes) && $imageSize < MAX_IMAGE_SIZE) {
                $imageSplit = explode('.', $imageUplName);
                $imageExtension = end($imageSplit);
    
                $imageExists = true;
                while ($imageExists) {
                    $imageNewName = uniqid() . '.' . $imageExtension;
                    $imageDestination = '../storage/images/' . $imageNewName;
    
                    if (!file_exists($imageDestination)) {
                        $imageExists = false;
                    }
                }

                $userInfo = $this->settingModel->getUserInfo($userid);
                if ($userInfo->rowCount() > 0) {
                    if ($this->settingModel->updateUserImage($userid,$imageNewName)) {
                        move_uploaded_file($imageTmpName, $imageDestination);

                        $userimage = $userInfo->fetch(PDO::FETCH_ASSOC)['image'];

                        if (!empty($userimage) && $userimage != 'profile.png') {
                            unlink('../storage/images/' . $userimage);
                        }
                    }
                }
                else {
                    if ($this->settingModel->insertUserImage($userid,$imageNewName)) {
                        move_uploaded_file($imageTmpName, $imageDestination);
                    }
                }
            }
        }
        header('location: ../settings.php?stab=preview');
    }
    /* End Change Profile Image */

    /* Start Change Social Media */
    function changeSocialMedia(){
        global $userid;
        $email = $_POST['email'];
        $facebook = $_POST['facebook'];
        $whatsapp = $_POST['whatsapp'];
        $password = $_POST['password'];

        if ($this->istanetModel->checkPassword($userid, $password) > 0) {
            $userInfo = $this->settingModel->getUserInfo($userid);
            if ($userInfo->rowCount() > 0) {
                $this->settingModel->updateSocialMedia($userid,$email,$facebook,$whatsapp);
            }else {
                $this->settingModel->insertSocialMedia($userid,$email,$facebook,$whatsapp);
            }
        }

        header('location: ../settings.php?stab=preview');
    }
    /* End Change Social Media */

    /* Start Social Media Inputs */
    function socialMediaInputs(){
        global $userid;
        $userInfo = $this->settingModel->getUserInfo($userid);
        if ($userInfo->rowCount() > 0) {
            $row = $userInfo->fetch(PDO::FETCH_ASSOC);
            $data['email'] = $row['email'];
            $data['facebook'] = $row['facebook'];
            $data['whatsapp'] = $row['whatsapp'];

            View::load('setting/smediaSettingView', $data);
        }
    }
    /* End Social Media Inputs */

    /* Start Change Password */
    function changePassword(){
        global $userid;
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        if ($this->istanetModel->checkPassword($userid, $oldPassword) > 0) {
            $this->istanetModel->updatePassword($userid, $newPassword);
        }
        header('location: ../settings.php?stab=preview');
    }
    /* End Change Password */
}