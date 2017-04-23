/**
 * Получение данных с формы
 */
function getData(obj_form) {
    var hData = {};
    $('input, textarea, select', obj_form).each(function(){
       if(this.name && this.name !== '') {
           hData[this.name] = this.value;
           console.log('hData[' + this.name + '] = ' + hData[this.name]);
       }
    });
    return hData;
}

/**
 * показывать/прятать данные о заказе
 */
function showProducts(id) {
    var objName = '#purchasesForOrderId_' + id;
    if ($(objName).css('display') != 'table-row') {
        $(objName).show();
    } else {
        $(objName).hide();
    }
}

/**
 * Добавление новой категории
 */
function newCategory() {
    var postData = getData('#blockNewCategory');
    
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/admin/addnewcat/',
        data: postData,
        success: function(data) {
            if (data['success']) {
                alert(data['message']);
                $('#newCategoryName').val('');
            } else {
                alert(data['message']);
            }
        }
    });
}

/**
 * Обновление данных категории
 */
function updateCat(itemId) {
    var parentId = $('#parentId_' + itemId).val();
    var newName = $('#itemName_' + itemId).val();
    var postData = {itemId: itemId, parentId: parentId, newName: newName};
    
    $.ajax({
        type:'POST',
        url: '/admin/updatecategory/',
        data: postData,
        dataType: 'json',
        success: function(data) {
            alert(data['message']);
        }
    });
}

/**
 * добавление нового продукта
 */
function addProduct() {
    var itemName = $('#newItemName').val();
    var itemPrice = $('#newItemPrice').val();
    var itemDescr = $('#newItemDescr').val();
    var itemCatId = $('#newItemCatId').val();
    
    var postData = {itemName: itemName, itemPrice: itemPrice, itemDescr: itemDescr, itemCatId: itemCatId};
    
    $.ajax({
        type: 'POST',
        data: postData,
        dataType: 'json',
        url: '/admin/addproduct/',
        success: function(data) {
            alert(data['message']);
            if (data['success']) {
                $('#newItemName').val('');
                $('#newItemPrice').val('');
                $('#newItemDescr').val('');
                $('#newItemCatId').val('');
            }
        }
    });
}

function updateProduct(itemId) {
    var itemName = $('#itemName_' + itemId).val();
    var itemPrice = $('#itemPrice_' + itemId).val();
    var itemCatId = $('#itemCatId_' + itemId).val();
    var itemDescr = $('#itemDescr_' + itemId).val();
    var itemStatus = $('#itemStatus_' + itemId).prop('checked');
    
    if (! itemStatus) {
        itemStatus = 1;
    } else {
        itemStatus = 0;
    }
    
    var postData = {itemId: itemId, itemName: itemName, itemPrice: itemPrice, 
                    itemCatId: itemCatId, itemDescr: itemDescr, itemStatus: itemStatus};
    
    $.ajax({
        type: 'POST',
        data: postData,
        dataType: 'json',
        url: '/admin/updateproduct/',
        success: function(data) {
            alert(data['message']);
        }
    });
}
/**
 * изменение статуса заказа
 */
function updateOrderStatus(itemId) {
    var status = $('#itemStatus_' + itemId).prop('checked');
    if (!status) {
        status = 0;
    } else {
        status = 1;
    }
    var postData = {itemId: itemId, status: status};
    
    $.ajax({
        type: 'POST',
        url: '/admin/setorderstatus/',
        data: postData,
        dataType: 'json',
        success: function(data) {
            if (!data['success']) alert(data['message']);
            }
    });
}

/**
 * изменение даты оплаты
 */
function updateDatePayment(itemId) {
    var datePayment = $('#datePayment_' + itemId).val();
    var postData = {itemId: itemId, datePayment: datePayment};
    
    $.ajax({
        type: 'POST',
        url: '/admin/setorderdatepayment/',
        data: postData,
        dataType: 'json',
        success: function(data) {
            if (!data['success']) alert(data['message']);
        }
    });
}