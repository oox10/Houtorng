<?php

  class Model_WebSite extends Model_Main{
    
	
	/***--  Function Set --***/
    
	
	/*[ Web Site Function Set ]*/ 
	
	//-- WebSite Page Initial 
	// [input] : NULL;
	public function WebSite_Get_Product_List($Lang='meta_cht',$TargetProduct=''){
	  
	  $product_search = strlen(trim($TargetProduct)) > 3 ? rawurldecode(trim($TargetProduct)) : false; 
	  
	  try{
	  
		// 查詢資料庫
		$DB_OBJ = $this->DBLink->prepare($this->DBSql->WEBSITE_INDEX_GET_PRODUCT_LISR($Lang));
		if(!$DB_OBJ->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}

		// 取得產品資料
		$product_list = array();
		$product_list = $DB_OBJ->fetchAll(PDO::FETCH_ASSOC);		
	    
		$product_show = array();
		
	    // 取得產品類別&資料
		$product_class = array(); 
		$product_target= ''; 
	    $product_result = array();
		foreach($product_list as &$product){
		  
		  // Get Product Images
		  $product['images'] = array();
		  $DB_OBJ = $this->DBLink->prepare($this->DBSql->WEBSITE_GET_PRODUCT_OBJECT());
		  if($DB_OBJ->execute(array('pid'=>$product['pid']))){
		    $product['images'] = $DB_OBJ->fetchAll(PDO::FETCH_ASSOC);
		  }
		  
		  // Built Product Type
		  $ptype = $product['title_type'] ? $product['title_type'] : $product['title_product'];
		  if(!isset($product_class[$ptype])){
			$product_class[$ptype] = array();  
		  }
		  $product_class[$ptype][] = $product['title_product'];
		  
		  // Get Product Search
		  if($product_search){
		    if(in_array($product_search,$product)){
			  $product_target = $product['title_product'];
			  $product_result = &$product;
		    }   
		  }
		  
		  $product_show[str_pad($product['view_order'],2,'0',STR_PAD_LEFT).str_pad($product['pid'],3,'0',STR_PAD_LEFT)] = $product;
		  
		}
		ksort($product_show);
		$this->ModelResult['action'] = true;		
		$this->ModelResult['data']['product']   = array_slice($product_show,0,10);	//用於建立首頁的產品卷軸	
	    $this->ModelResult['data']['classlv']   = $product_class;	//用於建立nav bar的列表
        $this->ModelResult['data']['target']    = $product_target;  //用於建立產品清單focus
		$this->ModelResult['data']['result']    = $product_result;	//用於顯示搜尋結果產品資料	
	  
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;
	  
	}
	
	
	//-- WebSite Page Initial 
	// [input] : NULL;
	public function WebSite_Get_Business_List(){
	  
	  try{
	  
		// 查詢資料庫
		$DB_OBJ = $this->DBLink->prepare($this->DBSql->WEBSITE_BUSINESS_GET_BUSINESS_LIST());
		if(!$DB_OBJ->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}

		// GET資料
		$business_list = array();
		
		while($tmp = $DB_OBJ->fetch(PDO::FETCH_ASSOC)){
		  if(!isset($business_list[$tmp['pdgroup']])){
		    $business_list[$tmp['pdgroup']] = array();
		  }
		  $business_list[$tmp['pdgroup']][] = $tmp; 
		}
	    
		$this->ModelResult['action'] = true;		
		$this->ModelResult['data']['business']   = $business_list;		
	  
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;
	  
	}
	
	
	
	//-- Website Contact Message Sent  // 
	// [input] : Captcha  :  server side chptcha code => from $_SESSION['turing_reset']
	// [input] : UserCap  :  client side chptcha keyin
	// [input] : MesgData :  user message data => array(.....)
	public function Contact_Message_Submit($Captcha=false,$UserCap='',$MesgData=array()){
	  
	  try{
		
		// check captcha
		if(!$Captcha || $Captcha != $UserCap){
		  $this->ModelResult['data']['captcha_input']=$Captcha;	
          throw new Exception('_REGISTER_ERROR_CAPTCHA_TEST_FAIL');
		}
		
		// check email
		if(!isset($MesgData['email']) || !filter_var($MesgData['email'], FILTER_VALIDATE_EMAIL)){ 
		  $this->ModelResult['data']['email']='';
		  throw new Exception('_REGISTER_ERROR_EMAIL_TEST_FAIL');
		}
		  
		/*== start insert message data ==*/
		
		// STEP.1: insert table:user 
		$DB_OBJ		= $this->DBLink->prepare($this->DBSql->WEBSITE_SAVE_CONTACT_MESSAGE());
		//:user_ip,:user_mail,:content
		
		$DB_OBJ->bindValue(':user_ip',System_Tool::get_client_ip(),PDO::PARAM_STR);
		$DB_OBJ->bindParam(':user_mail',$MesgData['email'],PDO::PARAM_STR);
		$DB_OBJ->bindValue(':content',json_encode($MesgData));
		
		if(!$DB_OBJ->execute()){
		  throw new Exception('_REGISTER_ERROR_SQL_FAIL_USER_INSERT');			  
		}
		$msg_no = $this->DBLink->lastInsertId('message');
		
		// 發送信
		self::Contact_Message_SentToAdmin($msg_no , $MesgData);
		
		
		$this->ModelResult['action'] = true;
		
	  }catch(Exception $e){
		$this->ModelResult['message'][] = $e->getMessage();    
	  }
	  
	  sleep(1);
	  return $this->ModelResult;
	  
	}
	
	
	//-- Client Message Mail Sent  // 使用者訊息發送到信箱
	// [input] : MesgNo   :  message db no => \d+
	// [input] : MesgData :  user message data => array(.....)
	public function Contact_Message_SentToAdmin($MesgNo,$MesgData=array()){
	  
	// 設定信件內容
	  require(_SYSTEM_ROOT_PATH.'mvc/lib/PHPMailer_5.2.4/class.phpmailer.php');
	  $system_message = array();
	  
	  $mail_content    = "<div style='margin-bottom:10px;'>有客戶[<span style='font-weight:bold;'>".$MesgData['company']."</span>]透過網站與我們聯繫</div>";
	  $mail_content   .= "<div style='margin-bottom:10px;'>請盡快確認與處理!</div>";
	  $mail_content   .= "<table border=1 style='min-width:500px;background-color:#c1e4e9;	border-collapse: collapse;'>";
	  $mail_content   .= "<tr ><th style='padding:5px;'>標題   :</th><td style='padding:5px;'>  ".$MesgData['subject']."</td></tr>";
	  $mail_content   .= "<tr ><th style='padding:5px;'>時間   :</th><td style='padding:5px;'>  ".date('Y-m-d H:i:s')."</td></tr>";
	  $mail_content   .= "<tr ><th style='padding:5px;'>公司   :</th><td style='padding:5px;'>  ".$MesgData['company']."</td></tr>";
	  $mail_content   .= "<tr ><th style='padding:5px;'>聯絡人 :</th><td style='padding:5px;'>".$MesgData['name']."</td></tr>";
	  $mail_content   .= "<tr ><th style='padding:5px;'>信箱   :</th><td style='padding:5px;'>  ".$MesgData['email']."</td></tr>";
	  $mail_content   .= "<tr ><th style='padding:5px;'>內容   :</th><td style='padding:5px;'>".nl2br(htmlspecialchars(strip_tags($MesgData['message'])))."</td></tr>";
	  $mail_content   .= "</table>";	    
	  $mail_content .= "<div style='margin:20px 0;'>本信由"._SYSTEM_HTML_TITLE."網站發出，請勿直接回覆</div>";
		  
	  $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
	  $mail->IsSMTP();             // telling the class to use SMT
	  $sent = 0;
      try{
	    if(_SYSTEM_MAIL_SSL_ACTIVE){
		  $mail->SMTPAuth   = true;                  // enable SMTP authentication
	      $mail->SMTPSecure = _SYSTEM_MAIL_SECURE;   // sets the prefix to the servier
	      $mail->Port       = _SYSTEM_MAIL_PORT;     // set the SMTP port for the GMAIL server
	    }
			
		$mail->Host       = _SYSTEM_MAIL_HOST; // SMTP server
		$mail->SMTPDebug  = false;                     // enables SMTP debug information (for testing)
	    $mail->CharSet 	= "utf-8";
	    $mail->Username   = _SYSTEM_MAIL_ACCOUNT_USER;  // MAIL username
	    $mail->Password   = _SYSTEM_MAIL_ACCOUNT_PASS;  // MAIL password
		
		//加入收件人
		$mail->AddAddress(_SYSTEM_MAIL_ACCOUNT_USER);
		//$mail->AddAddress(_SYSTEM_MAIL_CONTACT);
		
		//$mail->AddCC(); 
	    $mail->SetFrom(_SYSTEM_MAIL_ACCOUNT_USER);
	    $mail->AddReplyTo($MesgData['email']); // 回信位址    
	    $mail->Subject = date('Y-m-d').' - '._SYSTEM_HTML_TITLE."網站客戶聯繫通知";
	    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
	    $mail->MsgHTML($mail_content);
	    
		//$mail->AddAttachment('images/phpmailer.gif');      // attachment
	      
		if(!$mail->Send()) {
          $system_message[] = $mail->ErrorInfo;
        }else{
		  $sent = 1;
		}
	  } catch (phpmailerException $e) {
	    $system_message[] = $e->errorMessage();  //Pretty error messages from PHPMailer
	  } catch (Exception $e) {
		$system_message[] = $e->errorMessage();  //echo $e->getMessage(); //Boring error messages from anything else!
	  }
	  
	  // 紀錄資料
	  $db_log = $this->DBLink->prepare("UPDATE message SET temp=:result,_sent=1 WHERE mid=:mno;");
	  $db_log->bindValue(':result',join(';',$system_message));
	  $db_log->bindValue(':mno',$MesgNo);
	  $db_log->execute();
		
	}
	
	
  }
?>