function showToastSuccess(msg){
    if ($("#toastSuccess").css('display') != 'none') return;
    $("#toastSuccess").fadeIn(100);
    $("#toastSuccess .weui-toast__content").html(msg)
    setTimeout(function () {
        $("#toastSuccess").fadeOut(100);
    }, 2000);
}
function showToastError(msg){
    if ($("#toastError").css('display') != 'none') return;
    $("#toastError").fadeIn(100);
    $("#toastError .weui-toast__content").html(msg)
    setTimeout(function () {
        $("#toastError").fadeOut(100);
    }, 2000);
}
function showToastLoading(msg){
    $("#toastLoading").fadeIn(100);
    $("#toastLoading .weui-toast__content").html(msg)
}
function hideToastLoading(){
    $("#toastLoading").fadeOut(100);
}

function isPhoneNo(phone) { 
    var pattern = /^1[34578]\d{9}$/; 
    return pattern.test(phone); 
}

function isCardNo(card) 
{ 
    var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/; 
    return reg.test(card);
}

