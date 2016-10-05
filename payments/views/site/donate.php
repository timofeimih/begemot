<?php $this->pageTitle = 'Сделать пожертвование'; ?>
<div class="pay_type content">
	<h2 class="big_title">Сделать пожертвование</h2>
	<p>Выберите удобный вам способ для пожертвований:</p>

	<ul>
		<li href="#yandex_visa_form" rel="yandex-money" class="popup-btn">
			<a href=""  title="">
				<img src="/images/visa-rub.png" alt="">
			</a>
		</li>

		<li>
			<a href="#webmoney_form" rel="webmoney" title="" class="popup-btn">
				<img src="/images/webmoney.png" alt="">
			</a>
		</li>

		<li>
			<a href="#yandex_money_form" rel="yandex-money" class="popup-btn">
				<img src="/images/yandex.png" alt="">
			</a>
		</li>

		<li>
			<a href="#paypal_form" rel="paypal" title="" class="popup-btn">
				<img src="/images/paypal.png" alt="">
			</a>
		</li>

		<!--<li>
			<a href=""  title="">
				<img src="/images/qiwi.png" alt="">
			</a>
		</li>

		<li>
			<a href=""  title="">
				<img src="/images/visa-dollar.png" alt="">
			</a>
		</li>

		<li>
			<a href=""  title="">
				<img src="/images/alfa.png" alt="">
			</a>
		</li>

		<li>
			<a href=""  title="">
				<img src="/images/robokassa.png" alt="">
			</a>
		</li>

		

		<li>
			<a href=""  title="">
				<img src="/images/mob.png" alt="">
			</a>
		</li>

		<li>
			<a href=""  title="">
				<img src="/images/promocod.png" alt="">
			</a>
		</li>

		<li>
			<a href="https://secure.onpay.ru/pay/heartfund_org?pay_mode=free&price=3000&convert=no&user_email=timofeimih@gmail.com&url_success=http%3A//heart-fund.org/success&url_fail=http%3A//heart-fund.org/fail" rel="onpay" title="">
				<img src="/images/onpay.png" alt="">
			</a>
		</li> -->
	</ul>

	<div style="margin: 0 0 0 19px;">
		<h4>Реквизиты для перечисления пожертвований в любой валюте (RUB, EUR, USD и т.д.):</h4>
		<p>Банк Swedbank, a/a 221060827138, Heart Fund </p>
		<p>SWIFT/BIC: HABAEE2X </p>
		<p>IBAN: EE952200221060827138</p>
	</div>

</div>




<div style='display: none;'>
	<div id="paypal_form" class="popup-payment" style='width: 700px'>
		<div class="content">
			<header class="header-popup">		
				<div class="back_block">
			        <a href="#" class='close_modal'>К другим способам пожертвования</a>
			    </div>

			    <img class="logo-popup" src="/images/paypal.png" alt="">
			</header>

		    <div class="popup-content">


	            <form   action="https://www.paypal.com/cgi-bin/webscr" method="post" id='paypal_form'  name='pay' class="form_cont">
	                <!-- <p class="star">Поля с <span>*</span> обязательны для заполнения</p> -->

	                <div class="row">
	                    <input type="text" name='name' placeholder='Благотворитель (Ваше ФИО)'>
	                    <!-- <span class="dot green"></span> -->
	                </div>

	                <div class="row">
	                    <input type="text" name='email' placeholder='Ваш Е-mail'>
	                </div>
	                <br/>
					Пожертвование для: 
	                <div class="row select">

                        <select name='custom'>
                            <?php foreach ($cards as $card): ?>
                            <?php $selected = ($selectedId == $card->item->id) ? "selected" : "";?>
                            	<option <?php echo $selected?> value="<?php echo $card->item->id?>"><?php echo $card->item->name?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

	                <div class="amiliar">
	                	<input class="amiliarCheckbox" type="checkbox" required/>
	                	<label for="amiliar">Я ознакомлен c <a href="/files/dogovo_oferty.docx">договором-офертой</a> и согласен с ней</label>
	                </div>

	                <div class="btn_block">
	                    <input type="submit" value="Пожертвовать">
	                </div>
					

					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="9MCCAJW5SB5WA">

	                <div class="anonym">
	                	<input type="checkbox" class='anonymButton'/>
	                	<label for="anonym">
	                		Сделать пожертование анонимным
	                	</label>
	                </div>
	            </form>
	        </div><!--END .registration-->
		</div>

	</div>

	<div id="webmoney_form" class='popup-payment' style='width: 700px' >
		<div class="content">
			<header class="header-popup">		
				<div class="back_block">
			        <a href="#" class='close_modal'>К другим способам пожертвования</a>
			    </div>

			    <img class="logo-popup" src="/images/webmoney.png" alt="">
			</header>

		    <div class="popup-content">


	            <form  action="https://merchant.webmoney.ru/lmi/payment.asp" name='pay' method="POST"  class="form_cont webmoney_form">
	                <!-- <p class="star">Поля с <span>*</span> обязательны для заполнения</p> -->

	                <div class="row">
	                    <input type="text" name='name' placeholder='Благотворитель (Ваше ФИО)'>
	                    <!-- <span class="dot green"></span> -->
	                </div>


	                <div class="row">
	                    <input type='text' name='LMI_PAYMENT_AMOUNT' placeholder='Сумма*' required>
	                    <!-- <span class="dot red"></span>
	                    <i class="hint_text red">некорректно заполнено поле!</i> -->
	                </div>

	                <div class="row">
	                    <input type="text" name='email' placeholder='Ваш Е-mail'>
	                </div>
					<br/>
	                Пожертвование для: 
	                <div class="row select">

                        <select name='to'>
                            <?php foreach ($cards as $card): ?>
                            <?php $selected = ($selectedId == $card->item->id) ? "selected" : "";?>
                            	<option <?php echo $selected?> value="<?php echo $card->item->id?>"><?php echo $card->item->name?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

	                <div class="amiliar">
	                	<input class="amiliarCheckbox" type="checkbox" required />
	                	<label for="amiliar">Я ознакомлен c <a href="/files/dogovo_oferty.docx">договором-офертой</a> и согласен с ней</label>
	                </div>

	                <div class="btn_block">
	                    <input type="submit" value="Пожертвовать">
	                </div>

	                <input name="LMI_PAYMENT_DESC_BASE64" type="hidden" value=" <?php echo base64_encode('Пожертвование для ' . $child->name) ?>" /> 
					<input name="description" type="hidden" value="<?php echo 'Пожертвование для ' . $child->name; ?>" />
					<input name="LMI_PAYEE_PURSE" type="hidden" value="R402837066249" /></p>

	                <div class="anonym">
	                	<input type="checkbox" class='anonymButton'/>
	                	<label for="anonym">
	                		Сделать пожертование анонимным
	                	</label>
	                </div>
	            </form>
	        </div><!--END .registration-->
		</div>
	</div>

	<div id="yandex_visa_form" class='popup-payment' style='width: 700px' >
		<div class="content">
			<header class="header-popup">		
				<div class="back_block">
			        <a href="#" class='close_modal'>К другим способам пожертвования</a>
			    </div>

			    <img class="logo-popup" src="/images/visa-rub.png" alt="">
			</header>

		    <div class="popup-content">

	            <form  action="https://money.yandex.ru/quickpay/confirm.xml" name='pay' class="form_cont yandex_form">
	                <!-- <p class="star">Поля с <span>*</span> обязательны для заполнения</p> -->

	                <div class="row">
	                    <input type='text' name='sum' placeholder='Сумма*' required>
	                    <!-- <span class="dot red"></span>
	                    <i class="hint_text red">некорректно заполнено поле!</i> -->
	                </div>

	                <br/>
	                Пожертвование для: 
	                <div class="row select">

                        <select name='label'>
                            <?php foreach ($cards as $card): ?>
                            <?php $selected = ($selectedId == $card->item->id) ? "selected" : "";?>
                            	<option <?php echo $selected?> value="<?php echo $card->item->id?>"><?php echo $card->item->name?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

	                <div class="amiliar">
	                	<input class="amiliarCheckbox" type="checkbox" required/>
	                	<label for="amiliar">Я ознакомлен c <a href="/files/dogovo_oferty.docx">договором-офертой</a> и согласен с ней</label>
	                </div>

	                <div class="btn_block">
	                    <input type="submit" value="Пожертвовать">
	                </div>

	                 <input type="hidden" name="receiver" value="410012685013334">
					 <input type="hidden" name="short-dest" value=" <?php echo 'Пожертвование для ' . $child->name; ?>">
					 <input type="hidden" name="quickpay-form" value="donate">
					 <input type="hidden" name="targets" value="<?php echo 'Пожертвование для ' . $child->name; ?>">
					 <input type="hidden" name="sum"  data-type="number" >
					 <input type="hidden" name="need-fio" value="false"> 
					 <input type="hidden" name="need-email" value="false" >
					 <input type="hidden" name="need-phone" value="false">
					 <input type="hidden" name="need-address" value="false">
					 <input type="hidden" name="paymentType" value="AC">


	                <div class="anonym">
	                	<input type="checkbox" class='anonymButton' checked disabled/>
	                	<label for="anonym">
	                		Сделать пожертование анонимным
	                	</label>
	                </div>
	            </form>
	        </div><!--END .registration-->
		</div>
	</div>

	<div id="yandex_money_form" class='popup-payment' style='width: 700px' >
		<div class="content">
			<header class="header-popup">		
				<div class="back_block">
			        <a href="#" class='close_modal'>К другим способам пожертвования</a>
			    </div>

			    <img class="logo-popup" src="/images/yandex.png" alt="">
			</header>

		    <div class="popup-content">

	            <form  action="https://money.yandex.ru/quickpay/confirm.xml" name='pay' class="form_cont yandex_form">
	                <!-- <p class="star">Поля с <span>*</span> обязательны для заполнения</p> -->

	                <div class="row">
	                    <input type='text' name='sum' placeholder='Сумма*'>
	                    <!-- <span class="dot red"></span>
	                    <i class="hint_text red">некорректно заполнено поле!</i> -->
	                </div>

	                <br/>
	                Пожертвование для: 
	                <div class="row select">

                        <select name='label'>
                            <?php foreach ($cards as $card): ?>
                            <?php $selected = ($selectedId == $card->item->id) ? "selected" : "";?>
                            	<option <?php echo $selected?> value="<?php echo $card->item->id?>"><?php echo $card->item->name?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

	                <div class="amiliar">
	                	<input class="amiliarCheckbox" type="checkbox" required/>
	                	<label for="amiliar">Я ознакомлен c <a href="/files/dogovo_oferty.docx">договором-офертой</a> и согласен с ней</label>
	                </div>

	                <div class="btn_block">
	                    <input type="submit" value="Пожертвовать">
	                </div>

	                 <input type="hidden" name="receiver" value="410012685013334">
					 <input type="hidden" name="short-dest" value=" <?php echo 'Пожертвование для ' . $child->name; ?>">
					 <input type="hidden" name="quickpay-form" value="donate">
					 <input type="hidden" name="targets" value="<?php echo 'Пожертвование для ' . $child->name; ?>">
					 <input type="hidden" name="sum"  data-type="number" >
					 <input type="hidden" name="need-fio" value="false"> 
					 <input type="hidden" name="need-email" value="false" >
					 <input type="hidden" name="need-phone" value="false">
					 <input type="hidden" name="need-address" value="false">
					 <input type="hidden" name="paymentType" value="PC">


	                <div class="anonym">
	                	<input type="checkbox"   class='anonymButton' checked disabled/>
	                	<label for="anonym">
	                		Сделать пожертование анонимным
	                	</label>
	                </div>
	            </form>
	        </div><!--END .registration-->
		</div>
	</div>
</div>


<script>
	$(function(){
		$(".anonymButton").change(function(){
			if($(this).is(":checked")){
				$(this).parents("FORM").find("INPUT[name='name'], INPUT[name='email']").val("Аноним").hide();
			} else{
				$(this).parents("FORM").find("INPUT[name='name'], INPUT[name='email']").val("").show();
			}
		})

		$("FORM").submit(function(e){
			e.preventDefault();

			if($(this).attr("id") == "paypal_form"){

				var form = $(this);

				var arr = {'name': form.find("INPUT[name='name']").val(), 'email': form.find("INPUT[name='email']").val() ,  'description': 'Пожертвование для <?php echo $child->name?>', 'to': '<?php echo $child->id?>'};

				form.find("INPUT[name='custom']").val(JSON.stringify(arr));
				
			}

			if($(this).hasClass("yandex_form")){

				var form = $(this);

				var name = form.find("SELECT[name='label'] OPTION:selected").text();
				form.find("INPUT[name='short-dest'],INPUT[name='targets']").val("Пожертвование для " + name);

				if(form.find("INPUT[name='sum']").val() == ""){
					alert("Заполните поле сумма");
					return false;
				}

				//alert(form.find("INPUT[name='custom']").val());
			} else if($(this).hasClass("webmoney_form")){
				var form = $(this);
				var name = form.find("SELECT[name='to'] OPTION:selected").text();
				if(form.find("INPUT[name='LMI_PAYMENT_AMOUNT']").val() == ""){
					alert("Заполните поле сумма");
					return false;
				}
				form.find("INPUT[name='LMI_PAYMENT_DESC_BASE64'], INPUT[name='description']").val(Base64.encode("Пожертвование для " + name));
			}



			if($(this).find(".amiliarCheckbox").is(":checked")){
				$(this).unbind('submit').submit();
			} else{
				alert("Вы не согласились с договором-офертой");
			}
		})
	})

// Create Base64 Object
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

</script>