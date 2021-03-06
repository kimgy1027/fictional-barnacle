<?php 
    session_start();
    
    include './common_lib/common.php';
    
    $flag = "NO";
    $sql = "show tables from web_baedal_DB";
    $result = mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));
    while($row=mysqli_fetch_row($result)){
        if($row[0]==="membership"){
            $flag ="OK";
            break;
        }
    }
    
    if($flag!=="OK"){
        $sql= "create table membership (
                  user char(5) not null,
                  id char(12) not null primary key,
                  nick char(16) not null,
                  email char(30) not null,
                  pass char(20) not null
               )default charset=utf8;";
        if(mysqli_query($con,$sql)){
            echo "<script>alert('membership 테이블이 생성되었습니다.')</script>";
        }else{
            echo "실패원인2:".mysqli_query($con);
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>배달 홈페이지</title>
<link rel="stylesheet" href="./slide/css/slide.css?v=1"> 
<link rel="stylesheet" href="./common_css/index_style.css?v=22">

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>  
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="./slide/js/slide.js"></script>
<script>
	
	
	var login_view = "show";
	var wrapper_view = "show";
// 약관동의 ///////////////////////////////////////////////////////////////////////////	
	function show_wrapper_window(){
		
		if(wrapper_view == "show"){
			$("#wrapper").show();
			wrapper_view = "noshow";
		}else{
			$("#wrapper").hide();
			wrapper_view = "show";
		}
	}
	
	function hide_wrapper_view(){
		$("#wrapper").hide();
	}
	
	function hide_login_form(){
		$(".form").hide();
	}

	function everyCheck(){
		var chk = document.getElementsByName("check");	
		
		for(i=0; i < chk.length; i++) {
			chk[i].checked = true;
		}
	}
	
	function check(){
		var chk = document.getElementsByName("check");	//체크박스 이름을 가져옴
		var chk_length = chk.length;					
		var checked = 0;								//체크된 개수 파악을 위한 초기변수
		var i=0;
		
		for(i=0; i<chk_length; i++){			
			if(chk[i].checked==true){					//체크박스를 배열로 나열해 체크되면 ture 값
				checked += 1;		
			}
		}
		if(checked==4){								//필요한 체크박스 체크 완료 시 다음 페이지 이동
			$("#sign_up").show();
			$('#wrapper').hide();
		}else{
			alert("약관에 모두 동의해주세요");
		}
	}
	// 약관동의 ///////////////////////////////////////////////////////////////////////////		
	////////////////////////////////////////////////////////////////회원가입/////////////
	var conf="y";
		function check_exp(elem, exp, msg){
			if(!elem.value.match(exp)){
				alert(msg);
				return true;
			}
		}
	
	
	
    	function join_form_hide(){
    		$("#sign_up").hide();
        }
	
    	function check_id(){
    		var screenW=screen.availWidth; //스크린 가로사이즈
            var screenH=screen.availHeight; //스크린 세로사이즈
            var popW=500; //띄울 창의 가로사이즈
            var popH=340; //띄울 창의 세로사이즈
            var posL=(screenW-popW)/2;
            var posT=(screenH-popH)/2;
  
    			window.open("./membership/check_id.php?id="+document.join_form.id.value, "IDcheck", 'left='+posL+', top='+posT+', width='+popW+', height='+popH+', scrollbars=no, resizable=no');
    	        
    	}
    	
    	function check_nick(){
    		var screenW=screen.availWidth; //스크린 가로사이즈
            var screenH=screen.availHeight; //스크린 세로사이즈
            var popW=520; //띄울 창의 가로사이즈
            var popH=330; //띄울 창의 세로사이즈
            var posL=(screenW-popW)/2;
            var posT=(screenH-popH)/2;
            
    	     window.open("./membership/check_nick.php?nick=" + document.join_form.nick.value,
    	         "NICKcheck",
    	         'left='+posL+', top='+posT+', width='+popW+', height='+popH+', scrollbars=no, resizable=no');
    	}
	 
    	function check_email(){	//수정
    		var screenW=screen.availWidth; //스크린 가로사이즈
            var screenH=screen.availHeight; //스크린 세로사이즈
            var popW=500; //띄울 창의 가로사이즈
            var popH=300; //띄울 창의 세로사이즈
            var posL=(screenW-popW)/2;
            var posT=(screenH-popH)/2;
            
			window.open("./membership/check_email.php?email=" + document.join_form.email.value,
    			"IDEmail", 'left='+posL+', top='+posT+', width='+popW+', height='+popH+', scrollbars=no, resizable=no');
    	}
	 
	 
    	function check_input(){
    			if(!document.join_form.user.value){
    				alert("회원종류를 선택해주세요");
    				return;
    			}
    			
    			// 아이디 검사
    			var exp_id= /^[0-9a-zA-Z]{6,12}$/;
    			if(check_exp(document.join_form.id, exp_id, "ID는 6~12자리 영문 또는 숫자만 입력해주세요!")){
    				document.join_form.id.focus();
    				document.join_form.id.select();
    				return ;
    			}
    			
    			
    			var exp_nick= /^[0-9a-zA-Z가-하]{2,10}$/;
    			if(!document.join_form.nick.value){
    				alert("닉네임을 입력 해주세요");
    				document.join_form.nick.focus();
    				return ;
    			}			
    			if(check_exp(document.join_form.nick, exp_nick, "닉네임 올바르게 입력해주세요")){
    				document.join_form.nick.focus();
    				document.join_form.nick.select();
    				return ;
    			}	
    					
    		 	// 암호 검사
    			var exp_pass= /^[0-9a-zA-Z~!@#$%^&*()]{10,16}$/;
    			if(!document.join_form.pass.value){
    				alert("암호를 입력해주세요");
    				document.join_form.pass.focus();
    				return ;
    			}			
    			if(check_exp(document.join_form.pass, exp_pass, "암호는 6~12자리 영문 또는 숫자만 입력해주세요!")){
    				document.join_form.pass.focus();
    				document.join_form.pass.select();
    				return ;
    			}		
    			
    			// 암호 일치 확인
    			if(document.join_form.pass.value != document.join_form.passcheck.value){
    				alert("암호가 일치하지 않습니다. 다시 입력해주세요");
    				document.join_form.pass.focus();
    				document.join_form.pass.select();
    				return ;
    			}
    			
    			
    			
    			if(!document.join_form.email.value){
    				alert("e-mail 인증을 해주세요");
    				document.join_form.pass.focus();
    				document.join_form.pass.select();
    				return ;
    			}
    			
    			
    			document.join_form.submit();
    		}
	/////////////////////////////////////////////////////////////////////////회원가입//////////
	//////////////////////////////////////////로그인 창//////////////////////////////////////////////
    	
	
		function show_login_window(){
    	
    	
        	if(login_view == "show"){
        		$(".form").show();
        		login_view = "noShow";
        	}else{
        		$(".form").hide();
        		login_view = "show";
        	}
        	
        }
	
    	function input_check(){
    		
    		document.login_form.submit();
    	}
	
	//////////////////////////////////////////로그인 창//////////////////////////////////////////////
   
		function find_pw(){
			var screenW=screen.availWidth; //스크린 가로사이즈
            var screenH=screen.availHeight; //스크린 세로사이즈
            var popW=730; //띄울 창의 가로사이즈
            var popH=350; //띄울 창의 세로사이즈
            var posL=(screenW-popW)/2;
            var posT=(screenH-popH)/2;
            
    	     window.open("./login/pw_find.php",	         "findPW",
    	         'left='+posL+', top='+posT+', width='+popW+', height='+popH+', scrollbars=no, resizable=no');
		}
	
	/////////////////////////////////////////////////////검색기능///////////////////
    	function search_func(){
			var town = $("#asearch").val();
    		$.ajax({
				type : "post",
				url : "./search/search_result.php",
				data : "town="+town,
				success : function(data){
					$("#src_rst").show();
					$("#s_r_l").html(data);
				}
			});
		}
          

</script>

</head>
<body>
	<header>
		<?php include "./common_lib/top_login1.php"; ?>
	</header>
	<div class="logo">
		<a href="index.php"><img alt="logo" src="./common_img/logo.JPG"></a>
	</div>
	
	<nav>
		<?php include "./common_lib/menu1_1.php"; ?>
	</nav>
	
	
	
	
	
	
	<section>
		
		
		<div class="search" >
			<p id="p1" ><br><p id="p2" style="font-weight: normal;">우리동네를 입력해보세요!
           <form>
            <input id="asearch" type="text" placeholder="동 이름 검색" onkeyup="search_func()" autocomplete="off">
                <div id="src_rst" >
        			<div id="s_r_l" style = ></div>
        		</div>
            <button class='btn_submit' type="submit"><img src="./common_img/search.png"></button>
            </form>
         </div>
		
			

        	<div class="slide">
        		<button class="prev" type="button"> <img id="img1" src="./slide/images/btnL.png"> </button>
       				 <ul class="images">
        				  <li><img src="./slide/images/bg1.jpg"></li>
       					  <li><img src="./slide/images/bg2.jpg"></li>
      					  <li><img src="./slide/images/bg3.jpg"></li>
      					  <li><img src="./slide/images/bg4.jpg"></li>
      			     </ul>
      			<button class="next" type="button"> <img id="img2" src="./slide/images/btnR.png"> </button>
            </div>
               
        
	</section>
	
	<div class="form"> <!--  로그인창 div  -->
	    <form name="login_form" action="./login/login_db.php" method="post" class="login-form">
	    <div style="text-align: right;">
	    	<img id="x" src="./common_img/x.png" width="17px" onclick="hide_login_form()">
	    </div>
        <img src="./common_img/logo.JPG" width="150px">
        <br>
        <br>
     	  <input type="text" placeholder="아이디" name="id" autocomplete="off">
          <input type="password" name="pass" placeholder="패스워드" autocomplete="off">
          <div style="text-align: left">
            <div class="clearfix" style="display:inline-block;">
            </div>
          </div>  
          <!-- <small id="b"><input type="checkbox">로그인 상태 유지 </small> -->
          <input type="button" id="id" onclick="input_check()" value="login">
          <input type="button" id="id" onclick="find_pw()" value="비밀번호찾기">
          <input type="button" id="id" onclick="show_wrapper_window()" value="회원가입">
          <br>
          <p class="message">우리팀 화이팅<br><a href="#">(주)배달의신</a></p>
                  
        </form>
 	 </div><!-- END OF 로그인창 div   -->
 	 
 	 
 	 
<div id="wrapper">
<div style="text-align: right;">
	<img id="x" src="./common_img/x.png" width="17px" onclick="hide_wrapper_view()">
</div>
<img src="./common_img/logo.JPG" width="150px"><br>
<div class='all_check_div'>전체동의<input type="radio" name="agree" onclick="everyCheck()"></div>

					
				
				
<textarea rows="7" cols="120" readonly="readonly">
제 1 조 (목적)
이 약관은 주식회사 우아한형제들(이하 "회사”라 합니다)이 제공하는 배달의민족 서비스(이하 "서비스”라 합니다)와 관련하여, 회사와 이용 고객간에 서비스의 이용조건 및 절차, 회사와 회원간의 권리, 의무 및 기타 필요한 사항을 규정함을 목적으로 합니다. 본 약관은 PC통신, 스마트폰(안드로이드폰, 아이폰 등) 앱 등을 이용하는 전자상거래에 대해서도 그 성질에 반하지 않는 한 준용됩니다. 

제 2 조 (용어의 정의)
1. “사이트”란 “업주”가 재화 또는 서비스 상품(이하 “재화 등”이라 합니다)을 “이용자”에게 판매하기 위하여, “회사”가 컴퓨터 등 정보통신설비를 이용하여 재화 등을 거래할 수 있도록 설정하여 제공하는 가상의 영업장을 말합니다. 
2. “회원”이라 함은 “배달의민족”에 개인정보를 제공하여 회원등록을 한 자로서, “배달의민족”의 정보를 지속적으로 제공받으며, “배달의민족”이 제공하는 서비스를 계속적으로 이용할 수 있는 자를 의미하고, “배달의민족” 광고업소는 포함되지 않습니다. 
3. “비회원”이라 함은 “회원”으로 가입하지 않고 “회사”가 제공하는 서비스를 이용하는 자를 말합니다. 
4. “이용자”라 함은 배달의민족 서비스를 이용하는 자를 말하며, 회원과 비회원을 모두 포함합니다. 
5. “비밀번호(Password)”라 함은 회원의 동일성 확인과 회원의 권익 및 비밀보호를 위하여 회원 스스로가 설정하여 사이트에 등록한 영문과 숫자 등의 조합을 말합니다. 
6. “게시물”이라 함은 “회원”이 서비스를 이용함에 있어 서비스 상에 게시한 부호ㆍ문자ㆍ음성ㆍ음향ㆍ화상ㆍ동영상 등의 정보 형태의 글, 사진, 동영상 및 각종 파일과 링크 등을 의미합니다. 
7. “바로결제서비스”라 함은 “회원”이 “업주”의 “재화 등”을 주문, 결제할 수 있도록 “회사”가 제공하는 서비스를 말하며, 결제방식은 바로결제방식과 만나서결제방식으로 나누어집니다. 
8. “업주”란 “회사”가 제공하는 “서비스”를 이용해 “재화 등”에 관한 정보를 게재하고, 판매(조리 및 배달포함)하는 주체를 말합니다. 

제 3 조 (약관의 명시와 개정)
1. “회사”는 이 약관의 내용과 상호, 영업소 소재지 주소(소비자의 불만을 처리할 수 있는 곳의 주소를 포함), 대표자의 성명, 사업자등록번호, 통신판매업 신고번호, 연락처(전화, 전자우편 주소 등) 등을 “이용자”가 쉽게 알 수 있도록 “사이트”의 초기 서비스화면(전면)에 게시합니다. 다만, 약관의 내용은 “이용자”가 연결화면을 통하여 보도록 할 수 있습니다. 
2. “회사”는 『전자상거래 등에서의 소비자보호에 관한 법률』, 『약관의 규제등에 관한 법률』, 『전자문서 및 전자거래기본법』, 『전자서명법』, 『정보통신망 이용촉진 등에 관한 법률』, 『소비자기본법』 등 관련법령을 위배하지 않는 범위에서 이 약관을 개정할 수 있습니다. 
3. “회사”는 약관을 개정할 경우에는 적용일자 및 개정사유를 명시하여 현행약관과 함께 “사이트”의 초기화면에 그 적용일자 7일 이전부터 적용일자 전일까지 공지합니다. 다만, “이용자”에게 불리하게 약관내용을 변경하는 경우에는 최소한 30일 이상의 사전 유예기간을 두고 공지합니다. 이 경우 “회사”는 개정 전과 개정 후 내용을 “이용자”가 알기 쉽도록 표시합니다. 
4. “회원”은 변경된 약관에 동의하지 않을 권리가 있으며, 변경된 약관에 동의하지 않을 경우에는 서비스 이용을 중단하고 탈퇴를 요청할 수 있습니다. 다만, “이용자”가 제3항의 방법 등으로 “회사”가 별도 고지한 약관 개정 공지 기간 내에 “회사”에 개정 약관에 동의하지 않는다는 명시적인 의사표시를 하지 않는 경우 변경된 약관에 동의한 것으로 간주합니다. 
5. 이 약관에서 정하지 아니한 사항과 이 약관의 해석에 관하여는 『전자상거래 등에서의 소비자보호에 관한 법률』, 『약관의 규제 등에 관한 법률』, 공정거래위원회가 정하는 『전자상거래 등에서의 소비자보호지침』 및 관계 법령 또는 상관례에 따릅니다. 

제 4 조 (관련법령과의 관계)
이 약관 또는 개별약관에서 정하지 않은 사항은 전기통신사업법, 전자거래기본법, 정보통신망법, 전자상거래 등에서의 소비자보호에 관한 법률, 개인정보보호법 등 관련 법령의 규정과 일반적인 상관례에 의합니다. 

제 5 조 (서비스의 제공 및 변경)
1. “회사”는 다음과 같은 서비스를 제공합니다. 
1) “재화 등”에 대한 광고플랫폼 서비스 
2) “재화 등”에 대한 주문중계 등 통신판매중개서비스 
3) 배달대행 서비스 
4) 위치기반 서비스 
5) 기타 “회사”가 정하는 서비스 
2. “회사”는 서비스 제공과 관련한 회사 정책의 변경 등 기타 상당한 이유가 있는 경우 등 운영상, 기술상의 필요에 따라 제공하고 있는 “서비스”의 전부 또는 일부를 변경 또는 중단할 수 있습니다. 
3. “서비스”의 내용, 이용방법, 이용시간에 대하여 변경 또는 “서비스” 중단이 있는 경우에는 변경 또는 중단될 “서비스”의 내용 및 사유와 일자 등은 그 변경 또는 중단 전에 회사 "웹사이트" 또는 “서비스” 내 "공지사항" 화면 등 “회원”이 충분이 인지할 수 있는 방법으로 사전에 공지합니다. 

제 6 조 (서비스 이용시간 및 중단)
1. “서비스”의 이용은 “회사”의 업무상 또는 기술상 특별한 지장이 없는 한 연중무휴 1일 24시간을 원칙으로 합니다. 다만, 정기 점검 등의 필요로 “회사”가 정한 날이나 시간은 제외됩니다. 정기점검시간은 서비스제공화면에 공지한 바에 따릅니다. 
2. “회사”는 “서비스”의 원활한 수행을 위하여 필요한 기간을 정하여 사전에 공지하고 서비스를 중지할 수 있습니다. 단, 불가피하게 긴급한 조치를 필요로 하는 경우 사후에 통지할 수 있습니다. 
3. “회사”는 컴퓨터 등 정보통신설비의 보수점검•교체 및 고장, 통신의 두절 등의 사유가 발생한 경우에는 “서비스”의 제공을 일시적으로 중단할 수 있습니다. 

제 7 조 (이용계약의 성립)
1. 이용계약은 “회원”이 되고자 하는 자(이하 “가입신청자”)가 약관의 내용에 동의를 하고, “회사”가 정한 가입 양식에 따라 회원정보를 기입하여 회원가입신청을 하고 “회사”가 이러한 신청에 대하여 승인함으로써 체결됩니다. 
2. “회사”는 다음 각 호에 해당하는 신청에 대하여는 승인을 하지 않거나 사후에 이용계약을 해지할 수 있습니다. 
1) 가입신청자가 이 약관에 의하여 이전에 회원자격을 상실한 적이 있는 경우. 다만, 회원자격 상실 후 3년이 경과한 자로서 회사의 회원 재가입 승낙을 얻은 경우에는 예외로 함 
2) 실명이 아니거나 타인의 명의를 이용한 경우 
3) 회사가 실명확인절차를 실시할 경우에 이용자의 실명가입신청이 사실 아님이 확인된 경우 
4) 등록내용에 허위의 정보를 기재하거나, 기재누락, 오기가 있는 경우 
5) 이미 가입된 회원과 전화번호나 전자우편주소가 동일한 경우 
7) 부정한 용도 또는 영리를 추구할 목적으로 본 서비스를 이용하고자 하는 경우 
8) 기타 이 약관에 위배되거나 위법 또는 부당한 이용신청임이 확인된 경우 및 회사가 합리적인 판단에 의하여 필요하다고 인정하는 경우 
3. 제1항에 따른 신청에 있어 “회사”는 “회원”에게 전문기관을 통한 실명확인 및 본인인증을 요청할 수 있습니다. 
4. “회사”는 서비스관련설비의 여유가 없거나, 기술상 또는 업무상 문제가 있는 경우에는 승낙을 유보할 수 있습니다. 
5. “회원”은 회원가입 시 등록한 사항에 변경이 있는 경우, 상당한 기간 이내에 “회사”에 대하여 회원정보 수정 등의 방법으로 그 변경사항을 알려야 합니다. 

제 8 조 (이용계약의 종료)
1. “회원”의 해지 
1) “회원”은 언제든지 “회사”에게 해지의사를 통지함으로써 이용계약을 해지할 수 있습니다. 
2) “회사”는 전항에 따른 “회원”의 해지요청에 대해 특별한 사정이 없는 한 이를 즉시 처리합니다. 
3) “회원”이 계약을 해지하는 경우 “회원”이 작성한 게시물은 삭제되지 않습니다. 
2. “회사”의 해지 
1) “회사”는 다음과 같은 사유가 있는 경우, 이용계약을 해지할 수 있습니다. 이 경우 “회사”는 “회원”에게 전자우편, 전화, 팩스 기타의 방법을 통하여 해지사유를 밝혀 해지의사를 통지합니다. 다만, “회사”는 해당 “회원”에게 해지사유에 대한 의견진술의 기회를 부여 할 수 있습니다. 
가. 제7조 제2항에서 정하고 있는 이용계약의 승낙거부사유가 있음이 확인된 경우 
나. “회원”이 “회사”나 다른 회원 기타 타인의 권리나 명예, 신용 기타 정당한 이익을 침해하는 행위를 한 경우 
다. 기타 “회원”이 이 약관 및 “회사”의 정책에 위배되는 행위를 하거나 이 약관에서 정한 해지사유가 발생한 경우 
라. 1년 이상 서비스를 이용한 이력이 없는 경우 
2) 이용계약은 “회사”가 해지의사를 “회원”에게 통지함으로써 종료됩니다. 이 경우 “회사”가 해지의사를 “회원”이 등록한 전자우편주소로 발송하거나 “회사” 게시판에 게시함으로써 통지에 갈음합니다. 

제 9 조 (회원의 ID 및 비밀번호에 대한 의무)
1. ID와 비밀번호에 관한 관리책임은 “회원”에게 있습니다. 
2. “회원”은 자신의 ID 및 비밀번호를 제3자에게 이용하게 해서는 안됩니다. 
3. “회원”이 자신의 ID 및 비밀번호를 도난 당하거나 제3자가 사용하고 있음을 인지한 경우에는 즉시 “회사”에 통보하고 “회사”의 조치가 있는 경우에는 그에 따라야 합니다. 
4. “회원”이 제3항에 따른 통지를 하지 않거나 “회사”의 조치에 응하지 아니하여 발생하는 모든 불이익에 대한 책임은 “회원”에게 있습니다. 

제 10 조 (회원 및 이용자의 의무)
1. “이용자”는 관계법령 및 이 약관의 규정, “회사”의 정책, 이용안내 등 “회사”가 통지 또는 공지하는 사항을 준수하여야 하며, 기타 “회사” 업무에 방해되는 행위를 하여서는 안됩니다. 
2. “이용자”는 서비스 이용과 관련하여 다음 각 호의 행위를 하여서는 안됩니다. 
1) 서비스 신청 또는 변경 시 허위내용의 등록 
2) “회사”에 게시된 정보의 허가 받지 않은 변경 
3) “회사”가 정한 정보 이외의 정보(컴퓨터 프로그램 등)의 송신 또는 게시 
4) “회사” 또는 제3자의 저작권 등 지적 재산권에 대한 침해 
5) “회사 또는 제3자의 명예를 손상시키거나 업무를 방해하는 행위 
6) 외설 또는 폭력적인 메시지, 화상, 음성 기타 공공질서 미풍양속에 반하는 정보를 “서비스”에 공개 또는 게시하는 행위 
7) 고객센터 상담 내용이 욕설, 폭언, 성희롱 등에 해당하는 행위 
8) 포인트를 부정하게 적립하거나 사용하는 등의 행위 
9) 허위 주문, 허위 리뷰작성 등을 통해 서비스를 부정한 목적으로 이용하는 행위 
10) 자신의 ID, PW를 제3자에게 양도하거나 대여하는 등의 행위 
11) 정당한 사유 없이 당사의 영업을 방해하는 내용을 기재하는 행위 
12) 리버스엔지니어링, 디컴파일, 디스어셈블 및 기타 일체의 가공행위를 통하여 서비스를 복제, 분해 또 모방 기타 변형하는 행위 
13) 자동 접속 프로그램 등을 사용하는 등 정상적인 용법과 다른 방법으로 서비스를 이용하여 회사의 서버에 부하를 일으켜 회사의 정상적인 서비스를 방해하는 행위 
14) 기타 관계법령에 위반된다고 판단되는 행위 
3. “회사”는 이용자가 본 조 제2항의 금지행위를 한 경우 본 약관 제13조에 따라 서비스 이용 제한 조치를 취할 수 있습니다. 

제 11 조 (회원의 게시물)
“회원”이 작성한 게시물에 대한 저작권 및 모든 책임은 이를 게시한 “회원”에게 있습니다. 단, “회사”는 “회원”이 게시하거나 등록하는 게시물의 내용이 다음 각 호에 해당한다고 판단되는 경우 해당 게시물을 사전통지 없이 삭제 또는 임시조치(블라인드)할 수 있습니다. 
1) 다른 회원 또는 제3자를 비방하거나 명예를 손상시키는 내용인 경우 
2) 공공질서 및 미풍양속에 위반되는 내용일 경우 
3) 범죄적 행위에 결부된다고 인정되는 경우 
4) 회사의 저작권, 제3자의 저작권 등 기타 권리를 침해하는 내용인 경우 
5) 회원이 사이트와 게시판에 음란물을 게재하거나 음란사이트를 링크하는 경우 
6) 회사로부터 사전 승인 받지 아니한 상업광고, 판촉 내용을 게시하는 경우 
7) 해당 상품과 관련 없는 내용인 경우 
8) 정당한 사유 없이 “회사” 또는 “업주”의 영업을 방해하는 내용을 기재하는 경우 
9) 자신의 업소를 홍보할 목적으로 직접 또는 제3자(리뷰대행업체 등)을 통하여 위법 부당한 방법으로 허위 또는 과장된게시글을 게재하는 경우 
10) 허위주문 또는 주문취소 등 위법 부당한 방법으로 리뷰권한을 획득하여 “회원” 또는 제3자의 계정을 이용하여 게시글을 게시하는 경우 
11) 의미 없는 문자 및 부호에 해당하는 경우 
12) 제3자 등으로부터 권리침해신고가 접수된 경우 
13) 관계법령에 위반된다고 판단되는 경우 
14) 기타 회사의 서비스 약관, 운영정책 등 위반행위를 할 우려가 있거나 위반행위를 한 경우 

제 12 조 (회원게시물의 관리)
1. “회원”의 "게시물"이 정보통신망법 및 저작권법 등 관련법에 위반되는 내용을 포함하는 경우, 권리자는 관련법이 정한 절차에 따라 해당 "게시물"의 게시중단 및 삭제 등을 요청할 수 있으며, 회사는 관련법에 따라 조치를 취하여야 합니다. 

</textarea>
<div class="div_1"><u>배달의신 이용약관 동의</u><input type="checkbox" name="check" ></div>



<textarea rows="7" cols="120" readonly="readonly">
제 1 조 (목적)
이 약관은 주식회사 우아한형제들(이하 "회사”라 합니다)이 제공하는 배달의민족 서비스(이하 "서비스”라 합니다)와 관련하여, 회사와 이용 고객간에 서비스의 이용조건 및 절차, 회사와 회원간의 권리, 의무 및 기타 필요한 사항을 규정함을 목적으로 합니다. 본 약관은 PC통신, 스마트폰(안드로이드폰, 아이폰 등) 앱 등을 이용하는 전자상거래에 대해서도 그 성질에 반하지 않는 한 준용됩니다. 

제 2 조 (용어의 정의)
1. “사이트”란 “업주”가 재화 또는 서비스 상품(이하 “재화 등”이라 합니다)을 “이용자”에게 판매하기 위하여, “회사”가 컴퓨터 등 정보통신설비를 이용하여 재화 등을 거래할 수 있도록 설정하여 제공하는 가상의 영업장을 말합니다. 
2. “회원”이라 함은 “배달의민족”에 개인정보를 제공하여 회원등록을 한 자로서, “배달의민족”의 정보를 지속적으로 제공받으며, “배달의민족”이 제공하는 서비스를 계속적으로 이용할 수 있는 자를 의미하고, “배달의민족” 광고업소는 포함되지 않습니다. 
3. “비회원”이라 함은 “회원”으로 가입하지 않고 “회사”가 제공하는 서비스를 이용하는 자를 말합니다. 
4. “이용자”라 함은 배달의민족 서비스를 이용하는 자를 말하며, 회원과 비회원을 모두 포함합니다. 
5. “비밀번호(Password)”라 함은 회원의 동일성 확인과 회원의 권익 및 비밀보호를 위하여 회원 스스로가 설정하여 사이트에 등록한 영문과 숫자 등의 조합을 말합니다. 
6. “게시물”이라 함은 “회원”이 서비스를 이용함에 있어 서비스 상에 게시한 부호ㆍ문자ㆍ음성ㆍ음향ㆍ화상ㆍ동영상 등의 정보 형태의 글, 사진, 동영상 및 각종 파일과 링크 등을 의미합니다. 
7. “바로결제서비스”라 함은 “회원”이 “업주”의 “재화 등”을 주문, 결제할 수 있도록 “회사”가 제공하는 서비스를 말하며, 결제방식은 바로결제방식과 만나서결제방식으로 나누어집니다. 
8. “업주”란 “회사”가 제공하는 “서비스”를 이용해 “재화 등”에 관한 정보를 게재하고, 판매(조리 및 배달포함)하는 주체를 말합니다. 

제 3 조 (약관의 명시와 개정)
1. “회사”는 이 약관의 내용과 상호, 영업소 소재지 주소(소비자의 불만을 처리할 수 있는 곳의 주소를 포함), 대표자의 성명, 사업자등록번호, 통신판매업 신고번호, 연락처(전화, 전자우편 주소 등) 등을 “이용자”가 쉽게 알 수 있도록 “사이트”의 초기 서비스화면(전면)에 게시합니다. 다만, 약관의 내용은 “이용자”가 연결화면을 통하여 보도록 할 수 있습니다. 
2. “회사”는 『전자상거래 등에서의 소비자보호에 관한 법률』, 『약관의 규제등에 관한 법률』, 『전자문서 및 전자거래기본법』, 『전자서명법』, 『정보통신망 이용촉진 등에 관한 법률』, 『소비자기본법』 등 관련법령을 위배하지 않는 범위에서 이 약관을 개정할 수 있습니다. 
3. “회사”는 약관을 개정할 경우에는 적용일자 및 개정사유를 명시하여 현행약관과 함께 “사이트”의 초기화면에 그 적용일자 7일 이전부터 적용일자 전일까지 공지합니다. 다만, “이용자”에게 불리하게 약관내용을 변경하는 경우에는 최소한 30일 이상의 사전 유예기간을 두고 공지합니다. 이 경우 “회사”는 개정 전과 개정 후 내용을 “이용자”가 알기 쉽도록 표시합니다. 
4. “회원”은 변경된 약관에 동의하지 않을 권리가 있으며, 변경된 약관에 동의하지 않을 경우에는 서비스 이용을 중단하고 탈퇴를 요청할 수 있습니다. 다만, “이용자”가 제3항의 방법 등으로 “회사”가 별도 고지한 약관 개정 공지 기간 내에 “회사”에 개정 약관에 동의하지 않는다는 명시적인 의사표시를 하지 않는 경우 변경된 약관에 동의한 것으로 간주합니다. 
5. 이 약관에서 정하지 아니한 사항과 이 약관의 해석에 관하여는 『전자상거래 등에서의 소비자보호에 관한 법률』, 『약관의 규제 등에 관한 법률』, 공정거래위원회가 정하는 『전자상거래 등에서의 소비자보호지침』 및 관계 법령 또는 상관례에 따릅니다. 

제 4 조 (관련법령과의 관계)
이 약관 또는 개별약관에서 정하지 않은 사항은 전기통신사업법, 전자거래기본법, 정보통신망법, 전자상거래 등에서의 소비자보호에 관한 법률, 개인정보보호법 등 관련 법령의 규정과 일반적인 상관례에 의합니다. 

제 5 조 (서비스의 제공 및 변경)
1. “회사”는 다음과 같은 서비스를 제공합니다. 
1) “재화 등”에 대한 광고플랫폼 서비스 
2) “재화 등”에 대한 주문중계 등 통신판매중개서비스 
3) 배달대행 서비스 
4) 위치기반 서비스 
5) 기타 “회사”가 정하는 서비스 
2. “회사”는 서비스 제공과 관련한 회사 정책의 변경 등 기타 상당한 이유가 있는 경우 등 운영상, 기술상의 필요에 따라 제공하고 있는 “서비스”의 전부 또는 일부를 변경 또는 중단할 수 있습니다. 
3. “서비스”의 내용, 이용방법, 이용시간에 대하여 변경 또는 “서비스” 중단이 있는 경우에는 변경 또는 중단될 “서비스”의 내용 및 사유와 일자 등은 그 변경 또는 중단 전에 회사 "웹사이트" 또는 “서비스” 내 "공지사항" 화면 등 “회원”이 충분이 인지할 수 있는 방법으로 사전에 공지합니다. 

제 6 조 (서비스 이용시간 및 중단)
1. “서비스”의 이용은 “회사”의 업무상 또는 기술상 특별한 지장이 없는 한 연중무휴 1일 24시간을 원칙으로 합니다. 다만, 정기 점검 등의 필요로 “회사”가 정한 날이나 시간은 제외됩니다. 정기점검시간은 서비스제공화면에 공지한 바에 따릅니다. 
2. “회사”는 “서비스”의 원활한 수행을 위하여 필요한 기간을 정하여 사전에 공지하고 서비스를 중지할 수 있습니다. 단, 불가피하게 긴급한 조치를 필요로 하는 경우 사후에 통지할 수 있습니다. 
3. “회사”는 컴퓨터 등 정보통신설비의 보수점검•교체 및 고장, 통신의 두절 등의 사유가 발생한 경우에는 “서비스”의 제공을 일시적으로 중단할 수 있습니다. 

제 7 조 (이용계약의 성립)
1. 이용계약은 “회원”이 되고자 하는 자(이하 “가입신청자”)가 약관의 내용에 동의를 하고, “회사”가 정한 가입 양식에 따라 회원정보를 기입하여 회원가입신청을 하고 “회사”가 이러한 신청에 대하여 승인함으로써 체결됩니다. 
2. “회사”는 다음 각 호에 해당하는 신청에 대하여는 승인을 하지 않거나 사후에 이용계약을 해지할 수 있습니다. 
1) 가입신청자가 이 약관에 의하여 이전에 회원자격을 상실한 적이 있는 경우. 다만, 회원자격 상실 후 3년이 경과한 자로서 회사의 회원 재가입 승낙을 얻은 경우에는 예외로 함 
2) 실명이 아니거나 타인의 명의를 이용한 경우 
3) 회사가 실명확인절차를 실시할 경우에 이용자의 실명가입신청이 사실 아님이 확인된 경우 
4) 등록내용에 허위의 정보를 기재하거나, 기재누락, 오기가 있는 경우 
5) 이미 가입된 회원과 전화번호나 전자우편주소가 동일한 경우 
7) 부정한 용도 또는 영리를 추구할 목적으로 본 서비스를 이용하고자 하는 경우 
8) 기타 이 약관에 위배되거나 위법 또는 부당한 이용신청임이 확인된 경우 및 회사가 합리적인 판단에 의하여 필요하다고 인정하는 경우 
3. 제1항에 따른 신청에 있어 “회사”는 “회원”에게 전문기관을 통한 실명확인 및 본인인증을 요청할 수 있습니다. 
4. “회사”는 서비스관련설비의 여유가 없거나, 기술상 또는 업무상 문제가 있는 경우에는 승낙을 유보할 수 있습니다. 
5. “회원”은 회원가입 시 등록한 사항에 변경이 있는 경우, 상당한 기간 이내에 “회사”에 대하여 회원정보 수정 등의 방법으로 그 변경사항을 알려야 합니다. 

제 8 조 (이용계약의 종료)
1. “회원”의 해지 
1) “회원”은 언제든지 “회사”에게 해지의사를 통지함으로써 이용계약을 해지할 수 있습니다. 
2) “회사”는 전항에 따른 “회원”의 해지요청에 대해 특별한 사정이 없는 한 이를 즉시 처리합니다. 
3) “회원”이 계약을 해지하는 경우 “회원”이 작성한 게시물은 삭제되지 않습니다. 
2. “회사”의 해지 
1) “회사”는 다음과 같은 사유가 있는 경우, 이용계약을 해지할 수 있습니다. 이 경우 “회사”는 “회원”에게 전자우편, 전화, 팩스 기타의 방법을 통하여 해지사유를 밝혀 해지의사를 통지합니다. 다만, “회사”는 해당 “회원”에게 해지사유에 대한 의견진술의 기회를 부여 할 수 있습니다. 
가. 제7조 제2항에서 정하고 있는 이용계약의 승낙거부사유가 있음이 확인된 경우 
나. “회원”이 “회사”나 다른 회원 기타 타인의 권리나 명예, 신용 기타 정당한 이익을 침해하는 행위를 한 경우 
다. 기타 “회원”이 이 약관 및 “회사”의 정책에 위배되는 행위를 하거나 이 약관에서 정한 해지사유가 발생한 경우 
라. 1년 이상 서비스를 이용한 이력이 없는 경우 
2) 이용계약은 “회사”가 해지의사를 “회원”에게 통지함으로써 종료됩니다. 이 경우 “회사”가 해지의사를 “회원”이 등록한 전자우편주소로 발송하거나 “회사” 게시판에 게시함으로써 통지에 갈음합니다. 

제 9 조 (회원의 ID 및 비밀번호에 대한 의무)
1. ID와 비밀번호에 관한 관리책임은 “회원”에게 있습니다. 
2. “회원”은 자신의 ID 및 비밀번호를 제3자에게 이용하게 해서는 안됩니다. 
3. “회원”이 자신의 ID 및 비밀번호를 도난 당하거나 제3자가 사용하고 있음을 인지한 경우에는 즉시 “회사”에 통보하고 “회사”의 조치가 있는 경우에는 그에 따라야 합니다. 
4. “회원”이 제3항에 따른 통지를 하지 않거나 “회사”의 조치에 응하지 아니하여 발생하는 모든 불이익에 대한 책임은 “회원”에게 있습니다. 

제 10 조 (회원 및 이용자의 의무)
1. “이용자”는 관계법령 및 이 약관의 규정, “회사”의 정책, 이용안내 등 “회사”가 통지 또는 공지하는 사항을 준수하여야 하며, 기타 “회사” 업무에 방해되는 행위를 하여서는 안됩니다. 
2. “이용자”는 서비스 이용과 관련하여 다음 각 호의 행위를 하여서는 안됩니다. 
1) 서비스 신청 또는 변경 시 허위내용의 등록 
2) “회사”에 게시된 정보의 허가 받지 않은 변경 
3) “회사”가 정한 정보 이외의 정보(컴퓨터 프로그램 등)의 송신 또는 게시 
4) “회사” 또는 제3자의 저작권 등 지적 재산권에 대한 침해 
5) “회사 또는 제3자의 명예를 손상시키거나 업무를 방해하는 행위 
6) 외설 또는 폭력적인 메시지, 화상, 음성 기타 공공질서 미풍양속에 반하는 정보를 “서비스”에 공개 또는 게시하는 행위 
7) 고객센터 상담 내용이 욕설, 폭언, 성희롱 등에 해당하는 행위 
8) 포인트를 부정하게 적립하거나 사용하는 등의 행위 
9) 허위 주문, 허위 리뷰작성 등을 통해 서비스를 부정한 목적으로 이용하는 행위 
10) 자신의 ID, PW를 제3자에게 양도하거나 대여하는 등의 행위 
11) 정당한 사유 없이 당사의 영업을 방해하는 내용을 기재하는 행위 
12) 리버스엔지니어링, 디컴파일, 디스어셈블 및 기타 일체의 가공행위를 통하여 서비스를 복제, 분해 또 모방 기타 변형하는 행위 
13) 자동 접속 프로그램 등을 사용하는 등 정상적인 용법과 다른 방법으로 서비스를 이용하여 회사의 서버에 부하를 일으켜 회사의 정상적인 서비스를 방해하는 행위 
14) 기타 관계법령에 위반된다고 판단되는 행위 
3. “회사”는 이용자가 본 조 제2항의 금지행위를 한 경우 본 약관 제13조에 따라 서비스 이용 제한 조치를 취할 수 있습니다. 

제 11 조 (회원의 게시물)
“회원”이 작성한 게시물에 대한 저작권 및 모든 책임은 이를 게시한 “회원”에게 있습니다. 단, “회사”는 “회원”이 게시하거나 등록하는 게시물의 내용이 다음 각 호에 해당한다고 판단되는 경우 해당 게시물을 사전통지 없이 삭제 또는 임시조치(블라인드)할 수 있습니다. 
1) 다른 회원 또는 제3자를 비방하거나 명예를 손상시키는 내용인 경우 
2) 공공질서 및 미풍양속에 위반되는 내용일 경우 
3) 범죄적 행위에 결부된다고 인정되는 경우 
4) 회사의 저작권, 제3자의 저작권 등 기타 권리를 침해하는 내용인 경우 
5) 회원이 사이트와 게시판에 음란물을 게재하거나 음란사이트를 링크하는 경우 
6) 회사로부터 사전 승인 받지 아니한 상업광고, 판촉 내용을 게시하는 경우 
7) 해당 상품과 관련 없는 내용인 경우 
8) 정당한 사유 없이 “회사” 또는 “업주”의 영업을 방해하는 내용을 기재하는 경우 
9) 자신의 업소를 홍보할 목적으로 직접 또는 제3자(리뷰대행업체 등)을 통하여 위법 부당한 방법으로 허위 또는 과장된게시글을 게재하는 경우 
10) 허위주문 또는 주문취소 등 위법 부당한 방법으로 리뷰권한을 획득하여 “회원” 또는 제3자의 계정을 이용하여 게시글을 게시하는 경우 
11) 의미 없는 문자 및 부호에 해당하는 경우 
12) 제3자 등으로부터 권리침해신고가 접수된 경우 
13) 관계법령에 위반된다고 판단되는 경우 
14) 기타 회사의 서비스 약관, 운영정책 등 위반행위를 할 우려가 있거나 위반행위를 한 경우 

제 12 조 (회원게시물의 관리)
1. “회원”의 "게시물"이 정보통신망법 및 저작권법 등 관련법에 위반되는 내용을 포함하는 경우, 권리자는 관련법이 정한 절차에 따라 해당 "게시물"의 게시중단 및 삭제 등을 요청할 수 있으며, 회사는 관련법에 따라 조치를 취하여야 합니다. 

</textarea>
<div><u>전자금융거래 이용야관 동의</u><input type="checkbox"  name="check" ></div><br>

<textarea rows="7" cols="120" readonly="readonly">
제 1 조 (목적)
이 약관은 주식회사 우아한형제들(이하 "회사”라 합니다)이 제공하는 배달의민족 서비스(이하 "서비스”라 합니다)와 관련하여, 회사와 이용 고객간에 서비스의 이용조건 및 절차, 회사와 회원간의 권리, 의무 및 기타 필요한 사항을 규정함을 목적으로 합니다. 본 약관은 PC통신, 스마트폰(안드로이드폰, 아이폰 등) 앱 등을 이용하는 전자상거래에 대해서도 그 성질에 반하지 않는 한 준용됩니다. 

제 2 조 (용어의 정의)
1. “사이트”란 “업주”가 재화 또는 서비스 상품(이하 “재화 등”이라 합니다)을 “이용자”에게 판매하기 위하여, “회사”가 컴퓨터 등 정보통신설비를 이용하여 재화 등을 거래할 수 있도록 설정하여 제공하는 가상의 영업장을 말합니다. 
2. “회원”이라 함은 “배달의민족”에 개인정보를 제공하여 회원등록을 한 자로서, “배달의민족”의 정보를 지속적으로 제공받으며, “배달의민족”이 제공하는 서비스를 계속적으로 이용할 수 있는 자를 의미하고, “배달의민족” 광고업소는 포함되지 않습니다. 
3. “비회원”이라 함은 “회원”으로 가입하지 않고 “회사”가 제공하는 서비스를 이용하는 자를 말합니다. 
4. “이용자”라 함은 배달의민족 서비스를 이용하는 자를 말하며, 회원과 비회원을 모두 포함합니다. 
5. “비밀번호(Password)”라 함은 회원의 동일성 확인과 회원의 권익 및 비밀보호를 위하여 회원 스스로가 설정하여 사이트에 등록한 영문과 숫자 등의 조합을 말합니다. 
6. “게시물”이라 함은 “회원”이 서비스를 이용함에 있어 서비스 상에 게시한 부호ㆍ문자ㆍ음성ㆍ음향ㆍ화상ㆍ동영상 등의 정보 형태의 글, 사진, 동영상 및 각종 파일과 링크 등을 의미합니다. 
7. “바로결제서비스”라 함은 “회원”이 “업주”의 “재화 등”을 주문, 결제할 수 있도록 “회사”가 제공하는 서비스를 말하며, 결제방식은 바로결제방식과 만나서결제방식으로 나누어집니다. 
8. “업주”란 “회사”가 제공하는 “서비스”를 이용해 “재화 등”에 관한 정보를 게재하고, 판매(조리 및 배달포함)하는 주체를 말합니다. 

제 3 조 (약관의 명시와 개정)
1. “회사”는 이 약관의 내용과 상호, 영업소 소재지 주소(소비자의 불만을 처리할 수 있는 곳의 주소를 포함), 대표자의 성명, 사업자등록번호, 통신판매업 신고번호, 연락처(전화, 전자우편 주소 등) 등을 “이용자”가 쉽게 알 수 있도록 “사이트”의 초기 서비스화면(전면)에 게시합니다. 다만, 약관의 내용은 “이용자”가 연결화면을 통하여 보도록 할 수 있습니다. 
2. “회사”는 『전자상거래 등에서의 소비자보호에 관한 법률』, 『약관의 규제등에 관한 법률』, 『전자문서 및 전자거래기본법』, 『전자서명법』, 『정보통신망 이용촉진 등에 관한 법률』, 『소비자기본법』 등 관련법령을 위배하지 않는 범위에서 이 약관을 개정할 수 있습니다. 
3. “회사”는 약관을 개정할 경우에는 적용일자 및 개정사유를 명시하여 현행약관과 함께 “사이트”의 초기화면에 그 적용일자 7일 이전부터 적용일자 전일까지 공지합니다. 다만, “이용자”에게 불리하게 약관내용을 변경하는 경우에는 최소한 30일 이상의 사전 유예기간을 두고 공지합니다. 이 경우 “회사”는 개정 전과 개정 후 내용을 “이용자”가 알기 쉽도록 표시합니다. 
4. “회원”은 변경된 약관에 동의하지 않을 권리가 있으며, 변경된 약관에 동의하지 않을 경우에는 서비스 이용을 중단하고 탈퇴를 요청할 수 있습니다. 다만, “이용자”가 제3항의 방법 등으로 “회사”가 별도 고지한 약관 개정 공지 기간 내에 “회사”에 개정 약관에 동의하지 않는다는 명시적인 의사표시를 하지 않는 경우 변경된 약관에 동의한 것으로 간주합니다. 
5. 이 약관에서 정하지 아니한 사항과 이 약관의 해석에 관하여는 『전자상거래 등에서의 소비자보호에 관한 법률』, 『약관의 규제 등에 관한 법률』, 공정거래위원회가 정하는 『전자상거래 등에서의 소비자보호지침』 및 관계 법령 또는 상관례에 따릅니다. 

제 4 조 (관련법령과의 관계)
이 약관 또는 개별약관에서 정하지 않은 사항은 전기통신사업법, 전자거래기본법, 정보통신망법, 전자상거래 등에서의 소비자보호에 관한 법률, 개인정보보호법 등 관련 법령의 규정과 일반적인 상관례에 의합니다. 

제 5 조 (서비스의 제공 및 변경)
1. “회사”는 다음과 같은 서비스를 제공합니다. 
1) “재화 등”에 대한 광고플랫폼 서비스 
2) “재화 등”에 대한 주문중계 등 통신판매중개서비스 
3) 배달대행 서비스 
4) 위치기반 서비스 
5) 기타 “회사”가 정하는 서비스 
2. “회사”는 서비스 제공과 관련한 회사 정책의 변경 등 기타 상당한 이유가 있는 경우 등 운영상, 기술상의 필요에 따라 제공하고 있는 “서비스”의 전부 또는 일부를 변경 또는 중단할 수 있습니다. 
3. “서비스”의 내용, 이용방법, 이용시간에 대하여 변경 또는 “서비스” 중단이 있는 경우에는 변경 또는 중단될 “서비스”의 내용 및 사유와 일자 등은 그 변경 또는 중단 전에 회사 "웹사이트" 또는 “서비스” 내 "공지사항" 화면 등 “회원”이 충분이 인지할 수 있는 방법으로 사전에 공지합니다. 

제 6 조 (서비스 이용시간 및 중단)
1. “서비스”의 이용은 “회사”의 업무상 또는 기술상 특별한 지장이 없는 한 연중무휴 1일 24시간을 원칙으로 합니다. 다만, 정기 점검 등의 필요로 “회사”가 정한 날이나 시간은 제외됩니다. 정기점검시간은 서비스제공화면에 공지한 바에 따릅니다. 
2. “회사”는 “서비스”의 원활한 수행을 위하여 필요한 기간을 정하여 사전에 공지하고 서비스를 중지할 수 있습니다. 단, 불가피하게 긴급한 조치를 필요로 하는 경우 사후에 통지할 수 있습니다. 
3. “회사”는 컴퓨터 등 정보통신설비의 보수점검•교체 및 고장, 통신의 두절 등의 사유가 발생한 경우에는 “서비스”의 제공을 일시적으로 중단할 수 있습니다. 

제 7 조 (이용계약의 성립)
1. 이용계약은 “회원”이 되고자 하는 자(이하 “가입신청자”)가 약관의 내용에 동의를 하고, “회사”가 정한 가입 양식에 따라 회원정보를 기입하여 회원가입신청을 하고 “회사”가 이러한 신청에 대하여 승인함으로써 체결됩니다. 
2. “회사”는 다음 각 호에 해당하는 신청에 대하여는 승인을 하지 않거나 사후에 이용계약을 해지할 수 있습니다. 
1) 가입신청자가 이 약관에 의하여 이전에 회원자격을 상실한 적이 있는 경우. 다만, 회원자격 상실 후 3년이 경과한 자로서 회사의 회원 재가입 승낙을 얻은 경우에는 예외로 함 
2) 실명이 아니거나 타인의 명의를 이용한 경우 
3) 회사가 실명확인절차를 실시할 경우에 이용자의 실명가입신청이 사실 아님이 확인된 경우 
4) 등록내용에 허위의 정보를 기재하거나, 기재누락, 오기가 있는 경우 
5) 이미 가입된 회원과 전화번호나 전자우편주소가 동일한 경우 
7) 부정한 용도 또는 영리를 추구할 목적으로 본 서비스를 이용하고자 하는 경우 
8) 기타 이 약관에 위배되거나 위법 또는 부당한 이용신청임이 확인된 경우 및 회사가 합리적인 판단에 의하여 필요하다고 인정하는 경우 
3. 제1항에 따른 신청에 있어 “회사”는 “회원”에게 전문기관을 통한 실명확인 및 본인인증을 요청할 수 있습니다. 
4. “회사”는 서비스관련설비의 여유가 없거나, 기술상 또는 업무상 문제가 있는 경우에는 승낙을 유보할 수 있습니다. 
5. “회원”은 회원가입 시 등록한 사항에 변경이 있는 경우, 상당한 기간 이내에 “회사”에 대하여 회원정보 수정 등의 방법으로 그 변경사항을 알려야 합니다. 

제 8 조 (이용계약의 종료)
1. “회원”의 해지 
1) “회원”은 언제든지 “회사”에게 해지의사를 통지함으로써 이용계약을 해지할 수 있습니다. 
2) “회사”는 전항에 따른 “회원”의 해지요청에 대해 특별한 사정이 없는 한 이를 즉시 처리합니다. 
3) “회원”이 계약을 해지하는 경우 “회원”이 작성한 게시물은 삭제되지 않습니다. 
2. “회사”의 해지 
1) “회사”는 다음과 같은 사유가 있는 경우, 이용계약을 해지할 수 있습니다. 이 경우 “회사”는 “회원”에게 전자우편, 전화, 팩스 기타의 방법을 통하여 해지사유를 밝혀 해지의사를 통지합니다. 다만, “회사”는 해당 “회원”에게 해지사유에 대한 의견진술의 기회를 부여 할 수 있습니다. 
가. 제7조 제2항에서 정하고 있는 이용계약의 승낙거부사유가 있음이 확인된 경우 
나. “회원”이 “회사”나 다른 회원 기타 타인의 권리나 명예, 신용 기타 정당한 이익을 침해하는 행위를 한 경우 
다. 기타 “회원”이 이 약관 및 “회사”의 정책에 위배되는 행위를 하거나 이 약관에서 정한 해지사유가 발생한 경우 
라. 1년 이상 서비스를 이용한 이력이 없는 경우 
2) 이용계약은 “회사”가 해지의사를 “회원”에게 통지함으로써 종료됩니다. 이 경우 “회사”가 해지의사를 “회원”이 등록한 전자우편주소로 발송하거나 “회사” 게시판에 게시함으로써 통지에 갈음합니다. 

제 9 조 (회원의 ID 및 비밀번호에 대한 의무)
1. ID와 비밀번호에 관한 관리책임은 “회원”에게 있습니다. 
2. “회원”은 자신의 ID 및 비밀번호를 제3자에게 이용하게 해서는 안됩니다. 
3. “회원”이 자신의 ID 및 비밀번호를 도난 당하거나 제3자가 사용하고 있음을 인지한 경우에는 즉시 “회사”에 통보하고 “회사”의 조치가 있는 경우에는 그에 따라야 합니다. 
4. “회원”이 제3항에 따른 통지를 하지 않거나 “회사”의 조치에 응하지 아니하여 발생하는 모든 불이익에 대한 책임은 “회원”에게 있습니다. 

제 10 조 (회원 및 이용자의 의무)
1. “이용자”는 관계법령 및 이 약관의 규정, “회사”의 정책, 이용안내 등 “회사”가 통지 또는 공지하는 사항을 준수하여야 하며, 기타 “회사” 업무에 방해되는 행위를 하여서는 안됩니다. 
2. “이용자”는 서비스 이용과 관련하여 다음 각 호의 행위를 하여서는 안됩니다. 
1) 서비스 신청 또는 변경 시 허위내용의 등록 
2) “회사”에 게시된 정보의 허가 받지 않은 변경 
3) “회사”가 정한 정보 이외의 정보(컴퓨터 프로그램 등)의 송신 또는 게시 
4) “회사” 또는 제3자의 저작권 등 지적 재산권에 대한 침해 
5) “회사 또는 제3자의 명예를 손상시키거나 업무를 방해하는 행위 
6) 외설 또는 폭력적인 메시지, 화상, 음성 기타 공공질서 미풍양속에 반하는 정보를 “서비스”에 공개 또는 게시하는 행위 
7) 고객센터 상담 내용이 욕설, 폭언, 성희롱 등에 해당하는 행위 
8) 포인트를 부정하게 적립하거나 사용하는 등의 행위 
9) 허위 주문, 허위 리뷰작성 등을 통해 서비스를 부정한 목적으로 이용하는 행위 
10) 자신의 ID, PW를 제3자에게 양도하거나 대여하는 등의 행위 
11) 정당한 사유 없이 당사의 영업을 방해하는 내용을 기재하는 행위 
12) 리버스엔지니어링, 디컴파일, 디스어셈블 및 기타 일체의 가공행위를 통하여 서비스를 복제, 분해 또 모방 기타 변형하는 행위 
13) 자동 접속 프로그램 등을 사용하는 등 정상적인 용법과 다른 방법으로 서비스를 이용하여 회사의 서버에 부하를 일으켜 회사의 정상적인 서비스를 방해하는 행위 
14) 기타 관계법령에 위반된다고 판단되는 행위 
3. “회사”는 이용자가 본 조 제2항의 금지행위를 한 경우 본 약관 제13조에 따라 서비스 이용 제한 조치를 취할 수 있습니다. 

제 11 조 (회원의 게시물)
“회원”이 작성한 게시물에 대한 저작권 및 모든 책임은 이를 게시한 “회원”에게 있습니다. 단, “회사”는 “회원”이 게시하거나 등록하는 게시물의 내용이 다음 각 호에 해당한다고 판단되는 경우 해당 게시물을 사전통지 없이 삭제 또는 임시조치(블라인드)할 수 있습니다. 
1) 다른 회원 또는 제3자를 비방하거나 명예를 손상시키는 내용인 경우 
2) 공공질서 및 미풍양속에 위반되는 내용일 경우 
3) 범죄적 행위에 결부된다고 인정되는 경우 
4) 회사의 저작권, 제3자의 저작권 등 기타 권리를 침해하는 내용인 경우 
5) 회원이 사이트와 게시판에 음란물을 게재하거나 음란사이트를 링크하는 경우 
6) 회사로부터 사전 승인 받지 아니한 상업광고, 판촉 내용을 게시하는 경우 
7) 해당 상품과 관련 없는 내용인 경우 
8) 정당한 사유 없이 “회사” 또는 “업주”의 영업을 방해하는 내용을 기재하는 경우 
9) 자신의 업소를 홍보할 목적으로 직접 또는 제3자(리뷰대행업체 등)을 통하여 위법 부당한 방법으로 허위 또는 과장된게시글을 게재하는 경우 
10) 허위주문 또는 주문취소 등 위법 부당한 방법으로 리뷰권한을 획득하여 “회원” 또는 제3자의 계정을 이용하여 게시글을 게시하는 경우 
11) 의미 없는 문자 및 부호에 해당하는 경우 
12) 제3자 등으로부터 권리침해신고가 접수된 경우 
13) 관계법령에 위반된다고 판단되는 경우 
14) 기타 회사의 서비스 약관, 운영정책 등 위반행위를 할 우려가 있거나 위반행위를 한 경우 

제 12 조 (회원게시물의 관리)
1. “회원”의 "게시물"이 정보통신망법 및 저작권법 등 관련법에 위반되는 내용을 포함하는 경우, 권리자는 관련법이 정한 절차에 따라 해당 "게시물"의 게시중단 및 삭제 등을 요청할 수 있으며, 회사는 관련법에 따라 조치를 취하여야 합니다. 

</textarea>
<div><u>개인정보 수집이용 동의</u><input type="checkbox" name="check" ></div><br>

<div>마케팅 정보 메일 SMS 수신동의(선택)<input type="checkbox" ></div><br>
<div>만 14세 이상 고객만 가입가능 합니다. <u>내용보기</u><input type="checkbox" name="check" ></div><br>
<div>배달의민족은 만 14세 미만 아동의 회원가입을 제한하고 있습니다.</div><br>
<div>
<button name="next" onclick="check()" name="next">다음으로</button>&nbsp;&nbsp;&nbsp;
<button name="next" onclick="hide_wrapper_view()" name="next">취소하기</button>


	</div>
</div>

<div id="sign_up">

<img src="./common_img/logo.JPG" width="150px">
<p id="main">회원가입</p>
<hr>
<div class="sign_up_div">
<form name="join_form" method="post" action="./membership/insert.php">
    <table >
    	<tr class="tr1">
    		<td class="td1"><font>* </font>회원종류</td>
    		<td><input type="radio" id="user" class="ok" name="user" value="user" checked="checked">이용자&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    		 <input type="radio" class="ok" name="user" id="owner" value="admin">점주</td>
    	 	<td>
    	</tr>
    	<tr class="tr2">
    		<td class="td1"><font>* </font>아이디</td>
    		<td><input type="text" name="id" placeholder="중복확인을 클릭해 주세요!" readonly="readonly"></td>
    		<td><input class="ok" type="button" onclick="check_id()" value="중복확인" id="btn1"></td>
    	</tr>
    	<tr class="tr3">
    		<td class="td1"><font>* </font>닉네임 </td>
    		<td><input type="text" name="nick" placeholder="중복확인을 클릭해 주세요!" readonly="readonly"></td>
    		<td><input class="ok" type="button" value="중복확인" onclick="check_nick()" id="btn1"></td>
    	</tr>
    	
    	<tr class="tr4">
    		<td class="td1"><font>* </font>이메일</td>
    		<td><input type="text" name="email" placeholder="인증하기를 클릭해 주세요!" id="confirm" readonly="readonly"></td>
    		<td><input class="ok" type="button" value="인증하기" onclick="check_email()" id="btn1"></td>
    	</tr>
    	
    	<tr class="tr5">
    		<td class="td1"><font>* </font>비밀번호 <!-- <input type="hidden" name="email_num2" > --></td>
    		<td> <input type="password" name="pass" placeholder="8~20자로 입력하세요."></td>
    	</tr>
    	<tr class="tr6">
    		<td class="td1"><font>* </font>비밀번호 확인 </td>
    		<td><input type="password" name="passcheck" placeholder="8~20자로 입력하세요." > </td>
    	</tr>
    </table>
    <div class="sign_up_btns">
        <button type='button' class="ok"  onclick="check_input()">가입하기 </button>&nbsp;&nbsp;&nbsp;
        <button type='button' class="ok"  onclick="join_form_hide()"> 취소하기</button>
    </div>
</form>
</div><!-- end of sign up div -->
</div>
	
	<footer>
		<?php include "./common_lib/footer1.php"; ?>
	</footer>

</body>

</html>