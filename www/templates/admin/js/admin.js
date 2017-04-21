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
