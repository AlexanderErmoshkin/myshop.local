
function addToCart(itemId) {
    console.log("js - addToCArt()");
    $.ajax({
       type: 'POST',
       url: "/cart/addtocart/" + itemId + "/",
       dataType: 'json',
       success: function(data){
           if(data['success']){
               $('#cartCntItems').html(data['cartCntItems']);
               $('#addCart_' + itemId).hide();
               $('#removeCart_' + itemId).show();
           }
       }
   });
}

function removeFromCart(itemId) {
    console.log("js - removeFromCart(" + itemId + ")");
    $.ajax({
       type: 'POST',
       url: "/cart/removefromcart/" + itemId + "/",
       dataType: 'json',
       success: function(data) {
           if (data['success']) {
               $('#cartCntItems').html(data['cartCntItems']);
               $('#addCart_' + itemId).show();
               $('#removeCart_' + itemId).hide();
           }
       }
    });
}

/**
 * Подсчет стоимости товара
 * @param integer itemId идентификатор товара
 */
function conversionPrice(itemId) {
    var newCnt = $('#itemCnt_' + itemId).val();
    var itemPrice = $('#itemPrice_' + itemId).attr('value');
    var itemRealPrice = newCnt * itemPrice;
    
    $('#itemRealPrice_' + itemId).html(itemRealPrice);
    
    totalPrice();
}

/**
 * Регистрация нового пользователя
 */
function registerNewUser(){
    var postData = getData('#registerBox');
    
    $.ajax({
       type: 'POST',
       url: "/user/register/",
       data: postData,
       dataType: 'json',
       success: function(data) {
           if (data['success']){
               alert(data['message']);
               
               //>блок в левом столбце
               $('#registerBox').hide();
               
               $('#userLink').attr('href', '/user/');
               $('#userLink').html(data['userName']);
               $('#userBox').show();
               //<
               
               //>страница заказа
               $('#loginBox').hide();
               $('#btnSaveOrder').show();
               //<           
           } else {
               alert(data['message']);
           }
       }
    });
}

/**
 * Получение данных с формы
 */
function getData(obj_form) {
    var hData = {};
    $('input, textarea, select', obj_form).each(function(){
       if(this.name && this.name != '') {
           hData[this.name] = this.value;
           console.log('hData[' + this.name + '] = ' + hData[this.name]);
       } 
    });
    return hData;
}

/**
 * авторизация пользователя
 */
function login(){
    var email = $('#loginEmail').val();
    var pwd = $('#loginPwd').val();
    var postData = 'email=' + email + '&pwd=' + pwd;
    $.ajax({
        type: 'POST',
        url: "/user/login/",
        data: postData,
        dataType: 'json',
        success: function(data) {
            if(data['success']) {
                $('#registerBox').hide();
                $('#loginBox').hide();
                
                $('#userLink').attr('href', '/user/');
                $('#userLink').html(data['displayName']);
                $('#userBox').show();
                
                //заполнение полей на стрранице заказа
                $('#name').val(data['name']);
                $('#phone').val(data['phone']);
                $('#adress').val(data['adress']);
                
                $('#btnSaveOrder').show();
            } else {
                alert(data['message']);
            }
        }
    });
}

function totalPrice() {
    var total = null;
    $('.count').each(function(){
	total += Number($(this).text());
    });
    $("#totalPrice").html("Общая стоимость: " + total + " руб.");
}

/**
*показывает/скрывает блок регистрации
*/
function showRegisterBox() {
    if ( $("#registerBoxHidden").hasClass("hideme")) {
	$("#registerBoxHidden").removeClass("hideme");
    } else {
	$("#registerBoxHidden").addClass("hideme");
    }
}

/**
 * Обновление данных пользователя
 */
function updateUserData() {
    console.log('js - updateUserData()');
    var phone = $('#newPhone').val();
    var adress = $('#newAdress').val();
    var name = $('#newName').val();
    var pwd1 = $('#newPwd1').val();
    var pwd2 = $('#newPwd2').val();
    var curPwd = $('#curPwd').val();
    
    var postData = {phone: phone,
                    adress: adress,
                    name: name,
                    pwd1: pwd1,
                    pwd2: pwd2,
                    curPwd: curPwd};
    $.ajax({
        type: 'POST',
        url: '/user/update/',
        data: postData,
        dataType: 'json',
        success: function(data) {
            if(data['success']) {
                $('#userLink').html(data['userName']);
                alert(data['message']);
            } else {
                alert(data['message']);
            }
        }
    });
}

/**
 * Сохранение заказа
 */
function saveOrder() {
    var postData = getData('form');
    $.ajax({
        type: 'POST',
        data: postData,
        dataType: 'json',
        url: '/cart/saveorder/',
        success: function(data){
            if (data['success']) {
                alert(data['message']);
                document.location = '/';
            } else {
                alert(data['message']);
            }
        }
    });
}