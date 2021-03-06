<?php

error_reporting('E_ERROR');

// CONTACTUS.COM API V1.9
// www.contactus.com
// 2013 copyright

/*
  Description: The Donation Form Plugin by ContactUs.com.
  Author: ContactUs.Com
  Version: 1.1.3
  Author URI: http://www.contactus.com/
  License: GPLv2 or later
 */

class cUsComAPI_DF {

    var $v = '1.1.3';
    var $enviroment = 'http://api.contactus.com/api2.php';
    private $CU_categories = array(
        'Agents' => array('Insurance Agent', 'Mortgage Broker', 'Real Estate Agent', 'Travel Agent', 'Other Agent'),
        'Business Services' => array('Advertising / Marketing / PR', 'Art / Media / Design', 'Customer Service', 'Finance', 'Food / Beverage / Hospitality', 'Human Resources', 'IT', 'Legal', 'Logistics / Moving', 'Manufacturing', 'Medical / Health', 'Sales', 'Telecom', 'Utilities', 'Web Design / Development', 'Other Business Services'),
        'Content' => array('Blog', 'Entertainment', 'Finance', 'Jobs', 'News', 'Politics', 'Sports', 'Other'),
        'Education' => array('Career Training', 'For-Profit School', 'Language Learning', 'Non-Profit School', 'Recreational Learning', 'Tutoring / Lessons'),
        'Freelancers' => array('Actor / Model', 'Band / Musician', 'Business Consultant', 'Graphic Designer', 'Marketing Consultant', 'Software Engineer', 'Web Designer / Developer', 'Writer', 'Video Production', 'Other Independent Consultant'),
        'Home Services' => array('Audio / Video', 'Carpet Cleaning', 'Catering', 'Contractor', 'Dog Walking / Pet Sitting', 'Electrical', 'Furniture Repair', 'Gutter Cleaning', 'Handy Man/Repair', 'Home Security', 'House Cleaning', 'HVAC Services', 'Interior Design', 'Landscaping / Lawncare', 'Locksmith', 'Moving', 'Painting', 'Pest Control', 'Plumbing', 'Window Washing', 'Window Repair', 'Other Home Service'),
        'Non-Profit or Community Group' => array('Charity', 'Community Organization', 'Educational Organization', 'Government Organization', 'Health Organization', 'Political Organization', 'Religious Organization', 'Other Non-Profit'),
        'Offline Retail' => array('Apparel', 'Auto Sales', 'Auto Services', 'Electronics', 'Flowers and Gifts', 'Food and Beverage', 'Furniture', 'Jewelry', 'Music', 'Pets', 'Restaurants', 'Salons / Barbers', 'Spa', 'Specialty Items', 'Toys / Games', 'Other Local'),
        'Online Retail' => array('Apparel', 'Electronics', 'Flowers and Gifts', 'Food and Beverage', 'Invitations', 'Gifts', 'Pets', 'Specialty Items', 'Toys / Games', 'Other Online'),
        'Other Service Industry' => array('Events', 'Recreation', 'Other'),
        'Personal Services' => array('Beauty (hair, nails, etc.)', 'Child Care', 'Day Care', 'Massage Therapist', 'Personal Trainer', 'Photographers', 'Tutoring / Lessons', 'Other Personal Service'),
        'Professional Services' => array('Accountant', 'Architect / Engineering', 'Admin / Office', 'Computer Repair / IT Help', 'Dentist', 'Doctor', 'Education', 'Financial Planning', 'Lawyer', 'Life Coach', 'Logistics / Moving', 'Medical / Health', 'Optometrist / Optician', 'Security', 'Skilled Trade', 'Software', 'Therapist', 'Transportation', 'Veterinarian', 'Wedding / Special Events', 'Other Professional Service'),
        'Travel and Hospitality' => array('Car Rental', 'Excursion', 'Hotel / Motel', 'Tours', 'Transportation', 'Vacation Homes', 'Vacation Packages'),
        'Web Service' => array('Consumer Web Service', 'Small Business Web Service', 'Enterprise Web Service')
    );
    private $CU_goals = array(
        'Generating online sales',
        'Generating offline sales',
        'Generating sales leads',
        'Generating phone calls',
        'Growing your email marketing list',
        'Providing customer service',
        'None, I just want a contact form on my site that sends to my email',
        'Other'
    );

    public function cUsComAPI_DF() {
        $cUs_email = '';
        $cUs_formkey = '';

        return TRUE;
    }

    public function getAPICredentials($cUs_email, $cUs_pass) {

        $ch = curl_init();

        $strCURLOPT = $this->enviroment;
        $strCURLOPT .= '?API_Account=AC132f1ca7ff5040732b787564996a02b46cc4b58d';
        $strCURLOPT .= '&API_Key=cd690cf4f450950e857b417710b656923cf4b579';
        $strCURLOPT .= '&API_Action=getAPICredentials';
        $strCURLOPT .= '&Email=' . trim($cUs_email);
        $strCURLOPT .= '&Password=' . trim(urlencode($cUs_pass));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-ContactUs-Request-URL: ' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            'X-ContactUs-Signature: DFWP|1.1.3|' . $_SERVER['REMOTE_ADDR'],
        ));

        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        curl_setopt($ch, CURLOPT_URL, $strCURLOPT);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

    public function createCustomer($postData, $credential) {

        if (!strlen($postData['fname'])): echo ' "Missing First Name, is required field!" ';
        elseif (!strlen($postData['lname'])): echo ' "Missing Last Name, is required field!" ';
        elseif (!strlen($postData['email'])): echo ' "Missing Email, is required field!" ';
        elseif (!strlen($postData['website'])): echo ' "Missing Website, is required field!" ';
        else:

            $ch = curl_init();

            $strCURLOPT = $this->enviroment;

            $strCURLOPT .= '?API_Account=AC132f1ca7ff5040732b787564996a02b46cc4b58d';
            $strCURLOPT .= '&API_Key=cd690cf4f450950e857b417710b656923cf4b579';
            $strCURLOPT .= '&API_Action=createSignupCustomer';
            $strCURLOPT .= '&First_Name=' . trim(urlencode($postData['fname']));
            $strCURLOPT .= '&Last_Name=' . trim(urlencode($postData['lname']));
            $strCURLOPT .= '&Email=' . trim($postData['email']);
            $strCURLOPT .= '&Phone=' . urlencode(trim($postData['phone']));
            $strCURLOPT .= '&Password=' . trim(urlencode($credential));
            $strCURLOPT .= '&Website=' . esc_url(trim($postData['website']));
            $strCURLOPT .= '&IP_Address=' . $this->getIP();

            //check each one if exist to avoid error
            if (strlen(trim($postData['Main_Category'])) > 2) {
                //$cat = htmlentities($postData['Main_Category']);	
                $strCURLOPT .= '&Main_Category=' . trim(urlencode($postData['Main_Category']));
            }

            if (strlen(trim($postData['Sub_Category'])) > 2) {
                // $subcat = htmlentities($postData['Sub_Category']);
                $strCURLOPT .= '&Sub_Category=' . trim(urlencode($postData['Sub_Category']));
            }

            if (strlen($postData['Goals']) > 2) {
                $g = explode(',', $postData['Goals']);

                // delete last empty element of array 
                array_pop($g);

                if (is_array($g)) {
                    foreach ($g as $goal) {
                        $strCURLOPT .= '&Goals[]=' . trim(urlencode($goal));
                    }
                }
            }

            $strCURLOPT .= '&Template_Desktop_Form=' . urlencode($postData['Template_Desktop_Form']);
            $strCURLOPT .= '&Template_Desktop_Tab=' . urlencode($postData['Template_Desktop_Tab']);
            $strCURLOPT .= '&Form_Type=donation';
            $strCURLOPT .= '&Auto_Activate=1';
            $strCURLOPT .= '&API_Credentials=1';
            $strCURLOPT .= '&Promotion_Code=DFWP';
            $strCURLOPT .= '&Version=DFWP|1.1.3';

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-ContactUs-Request-URL: ' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                'X-ContactUs-Signature: DFWP|1.1.3|' . $_SERVER['REMOTE_ADDR'],
            ));

            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

            curl_setopt($ch, CURLOPT_URL, $strCURLOPT);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $content = curl_exec($ch);
            curl_close($ch);

            return $content;

        endif;
    }

    public function verifyCustomerEmail($cUs_email) {

        $ch = curl_init();

        $strCURLOPT = $this->enviroment;

        $strCURLOPT .= '?API_Account=AC132f1ca7ff5040732b787564996a02b46cc4b58d';
        $strCURLOPT .= '&API_Key=cd690cf4f450950e857b417710b656923cf4b579';
        $strCURLOPT .= '&API_Action=verifyCustomerEmail';
        $strCURLOPT .= '&Email=' . trim($cUs_email);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-ContactUs-Request-URL: ' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            'X-ContactUs-Signature: DFWP|1.1.3|' . $_SERVER['REMOTE_ADDR'],
        ));

        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        curl_setopt($ch, CURLOPT_URL, $strCURLOPT);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

    public function getTemplatesAndTabsAll($formType, $selType) {

        if (!strlen($formType) || !strlen($selType))
            return false;

        $ch = curl_init();

        $strCURLOPT = $this->enviroment;

        $strCURLOPT .= '?API_Account=AC132f1ca7ff5040732b787564996a02b46cc4b58d';
        $strCURLOPT .= '&API_Key=cd690cf4f450950e857b417710b656923cf4b579';

        $strCURLOPT .= '&API_Action=getTemplatesDataAll';
        $strCURLOPT .= '&Form_Type=' . trim($formType);
        $strCURLOPT .= '&Selection_Type=' . trim($selType);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-ContactUs-Request-URL: ' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            'X-ContactUs-Signature: DFWP|1.1.3|' . $_SERVER['REMOTE_ADDR'],
        ));

        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        curl_setopt($ch, CURLOPT_URL, $strCURLOPT);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

    public function getTemplatesAndTabsFree() {

        $contacFormTemplates = $cUsDF_api->getTemplatesAndTabsAll('3', 'Template_Desktop_Form');
        $contacFormTemplates = json_decode($contacFormTemplates);
        $contacFormTemplates = $contacFormTemplates->data;

        return $contacFormTemplates;
    }

    public function getTemplatesAndTabsAllowed($formType, $selType, $cUs_API_Account, $cUs_API_Key) {

        if (!strlen($formType) || !strlen($selType) || !strlen($cUs_API_Account) || !strlen($cUs_API_Key))
            return false;

        $ch = curl_init();

        $strCURLOPT = $this->enviroment;

        $strCURLOPT .= '?API_Account=' . trim($cUs_API_Account);
        $strCURLOPT .= '&API_Key=' . trim($cUs_API_Key);
        $strCURLOPT .= '&API_Action=getTemplatesDataAllowed';
        $strCURLOPT .= '&Form_Type=' . trim($formType);
        $strCURLOPT .= '&Selection_Type=' . trim($selType);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-ContactUs-Request-URL: ' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            'X-ContactUs-Signature: DFWP|1.1.3|' . $_SERVER['REMOTE_ADDR'],
        ));

        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        curl_setopt($ch, CURLOPT_URL, $strCURLOPT);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

    public function getFormKeysAPI($cUs_API_Account, $cUs_API_Key, $form_type = '') {

        $ch = curl_init();

        $strCURLOPT = $this->enviroment;

        $strCURLOPT .= '?API_Account=' . trim($cUs_API_Account);
        $strCURLOPT .= '&API_Key=' . trim($cUs_API_Key);

        // check if any specific form required or all
        if ($form_type != 0)
            $strCURLOPT .= '&Form_Type=' . trim($form_type);


        $strCURLOPT .= '&API_Action=getFormKeysData';

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-ContactUs-Request-URL: ' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            'X-ContactUs-Signature: DFWP|1.1.3|' . $_SERVER['REMOTE_ADDR'],
        ));

        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        curl_setopt($ch, CURLOPT_URL, $strCURLOPT);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

    public function getFormKeyAPI($cUs_email, $cUs_pass) {

        $ch = curl_init();

        $strCURLOPT = $this->enviroment;

        $strCURLOPT .= '?API_Account=AC132f1ca7ff5040732b787564996a02b46cc4b58d';
        $strCURLOPT .= '&API_Key=cd690cf4f450950e857b417710b656923cf4b579';

        $strCURLOPT .= '&API_Action=getFormKey';
        $strCURLOPT .= '&Email=' . trim($cUs_email);
        $strCURLOPT .= '&Password=' . trim(urlencode($cUs_pass));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-ContactUs-Request-URL: ' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            'X-ContactUs-Signature: DFWP|1.1.3|' . $_SERVER['REMOTE_ADDR'],
        ));

        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        curl_setopt($ch, CURLOPT_URL, $strCURLOPT);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

    public function updateFormSettings($postData, $formkey) {

        $ch = curl_init();

        $strCURLOPT = $this->enviroment;

        $strCURLOPT .= '?API_Account=' . trim($postData['API_Account']);
        $strCURLOPT .= '&API_Key=' . trim($postData['API_Key']);
        $strCURLOPT .= '&API_Action=updateFormSettings';
        $strCURLOPT .= '&Form_Key=' . trim($formkey);

        if (strlen($postData['Template_Desktop_Form']))
            $strCURLOPT .= '&Template_Desktop_Form=' . trim(urlencode($postData['Template_Desktop_Form']));

        if (strlen($postData['Template_Desktop_Tab']))
            $strCURLOPT .= '&Template_Desktop_Tab=' . trim(urlencode($postData['Template_Desktop_Tab']));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-ContactUs-Request-URL: ' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            'X-ContactUs-Signature: DFWP|1.1.3|' . $_SERVER['REMOTE_ADDR'],
        ));

        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        curl_setopt($ch, CURLOPT_URL, $strCURLOPT);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

    public function updateDeliveryOptions($postData, $formkey) {

        $ch = curl_init();

        $strCURLOPT = $this->enviroment;

        $strCURLOPT .= '?API_Account=' . trim($postData['API_Account']);
        $strCURLOPT .= '&API_Key=' . trim($postData['API_Key']);
        $strCURLOPT .= '&API_Action=updateDeliveryOptions';
        $strCURLOPT .= '&Form_Key=' . trim($postData['Form_Key']);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-ContactUs-Request-URL: ' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            'X-ContactUs-Signature: DFWP|1.1.3|' . $_SERVER['REMOTE_ADDR'],
        ));

        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        curl_setopt($ch, CURLOPT_URL, $strCURLOPT);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

    public function str_clean($str) {
        $str = str_replace("'", '', $str);
        $str = str_replace('\'', '', $str);

        return $str;
    }

    public function getIP() {

        // Get some headers that may contain the IP address
        $SimpleIP = (isset($REMOTE_ADDR) ? $REMOTE_ADDR : getenv("REMOTE_ADDR"));

        $TrueIP = (isset($HTTP_CUSTOM_FORWARDED_FOR) ? $HTTP_CUSTOM_FORWARDED_FOR : getenv("HTTP_CUSTOM_FORWARDED_FOR"));
        if ($TrueIP == "")
            $TrueIP = (isset($HTTP_X_FORWARDED_FOR) ? $HTTP_X_FORWARDED_FOR : getenv("HTTP_X_FORWARDED_FOR"));
        if ($TrueIP == "")
            $TrueIP = (isset($HTTP_X_FORWARDED) ? $HTTP_X_FORWARDED : getenv("HTTP_X_FORWARDED"));
        if ($TrueIP == "")
            $TrueIP = (isset($HTTP_FORWARDED_FOR) ? $HTTP_FORWARDED_FOR : getenv("HTTP_FORWARDED_FOR"));
        if ($TrueIP == "")
            $TrueIP = (isset($HTTP_FORWARDED) ? $HTTP_FORWARDED : getenv("HTTP_FORWARDED"));

        $GetProxy = ($TrueIP == "" ? "0" : "1");

        if ($GetProxy == "0") {
            $TrueIP = (isset($HTTP_VIA) ? $HTTP_VIA : getenv("HTTP_VIA"));
            if ($TrueIP == "")
                $TrueIP = (isset($HTTP_X_COMING_FROM) ? $HTTP_X_COMING_FROM : getenv("HTTP_X_COMING_FROM"));
            if ($TrueIP == "")
                $TrueIP = (isset($HTTP_COMING_FROM) ? $HTTP_COMING_FROM : getenv("HTTP_COMING_FROM"));
            if ($TrueIP != "")
                $GetProxy = "2";
        };

        if ($TrueIP == $SimpleIP)
            $GetProxy = "0";

        // Return the true IP if found, else the proxy IP with a 'p' at the begining
        switch ($GetProxy) {
            case '0':
                // True IP without proxy
                $IP = $SimpleIP;
                break;
            case '1':
                $b = preg_match("%^([0-9]{1,3}\.){3,3}[0-9]{1,3}%", $TrueIP, $IP_array);
                if ($b && (count($IP_array) > 0)) {
                    // True IP behind a proxy
                    $IP = $IP_array[0];
                } else {
                    // Proxy IP
                    $IP = $SimpleIP;
                };
                break;
            case '2':
                // Proxy IP
                $IP = $SimpleIP;
        };

        $IP = trim($IP);
        if (filter_var($IP, FILTER_VALIDATE_IP) && $IP != '127.0.0.1' && $IP != '::1') {
            $vIP = $IP;
        } else {
            $externalContent = file_get_contents('http://checkip.dyndns.com/');
            preg_match('/Current IP Address: ([\[\]:.[0-9a-fA-F]+)</', $externalContent, $m);
            $vIP = $m[1];
        }

        return $vIP;
    }

    public function DF_resetData() {
        delete_option('cUsDF_settings');
        delete_option('contactus_settings');
        delete_option('cUsDF_settings_userData');
        delete_option('cUsDF_FORM_settings');
        delete_option('cUsDF_settings_step1');
        delete_option('cUsDF_settings_form_key');
        delete_option('contactus_settings_inlinepages');
        delete_option('cUsDF_settings_inlinepages');
        delete_option('contactus_settings_tabpages');
        delete_option('cUsDF_settings_tabpages');
        delete_option('cUsDF_settings_userCredentials');
        delete_option('cUsDF_default_deep_link_view');
        delete_option('cUsDF_settings_form_id'); // DEFAULT FORM KEYS

        cUsDF_page_settings_cleaner();
        cUsDF_inline_shortcode_cleaner();

        //echo 'deleted data. . .';

        return true;
    }

    /*
     * Method that returns the first part of the deeplink, until brpage.php
     * String form already created in user account
     * @return string with the deeplink base
     * @since 1.9
     */

    public function get_deeplink($forms) {

        // first check if is array of forms we are passing
        if (is_array($forms)) {

            foreach ($forms as $key => $value) {
                if (strlen($value->deep_link_view)) {
                    $deeplink = $value->deep_link_view;
                    break;
                }
            }
        } else {
            $deeplink = $forms; // this is just a string
        }

        $abtest = parse_url($deeplink);
        $link = $abtest['scheme'] . '://' . $abtest['host'] . $abtest['path'];
        return $link;
    }

    /*
     * getter method that returns categories()
     * @since 1.3
     * @return Array categories
     * */

    public function get_categories() {
        return $this->CU_categories;
    }

    /*
     * getter method that returns goals()
     * @since 1.3
     * @return Array goals
     * */

    public function get_goals() {
        return $this->CU_goals;
    }

}

?>