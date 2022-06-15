export {get_data,set_user,get_user,login_sent_message,confirmation,readCookie,B24};

function get_data(url){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, false);
    xhr.send();
    var data;
    if (xhr.status != 200) {
        data = ( xhr.status + ': ' + xhr.statusText );
    } else {
        data = JSON.parse( xhr.responseText );
    }
    return data;
};

function get_user(phone,hash){
    var param = new FormData();
    param.append("phone", phone);
    param.append("hash", hash);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "http://localhost/SimpleKithen/back/connectors/get_user_data.php", false);
    xhr.send(param);
    var data;
    if (xhr.status != 200) {
        data = ( xhr.status + ': ' + xhr.statusText );
    } else {
        data = JSON.parse( xhr.responseText );
    }
    return data;
};

function B24(func,params=[]){
    var param = new FormData();
    param.append("func", func);
    param.append("params",JSON.stringify(params));
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "http://localhost/SimpleKithen/back/connectors/order.php", false);
    xhr.send(param);
    var data;
    if (xhr.status != 200) {
        data = ( xhr.status + ': ' + xhr.statusText );
    } else {
        data = JSON.parse( xhr.responseText );
    }
    return data;
};


function readCookie(name) {
    var name_cook = name+"=";
    var spl = document.cookie.split(";");
    for(var i=0; i<spl.length; i++) {
        var c = spl[i];
        while(c.charAt(0) == " ") {
            c = c.substring(1, c.length);
        }
        if(c.indexOf(name_cook) == 0) {
            return c.substring(name_cook.length, c.length);
        }
    }
    return null;
}

function set_user(first_name,second_name,last_name,phone,addresses = Array()){
    var param = new FormData();
    param.append("first_name", first_name);
    param.append("second_name", second_name);
    param.append("last_name", last_name);
    param.append("phone", phone);
    var arr=[];
    for (var i=0; i<addresses.length; i++){
        arr.push(addresses[i]);
    }
    param.append("addresses", JSON.stringify(arr));
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "http://localhost/SimpleKithen/back/connectors/set_user_data.php", false);
    xhr.send(param);
};

function login_sent_message(phone){
    var param = new FormData();
    param.append("phone", phone);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "http://localhost/SimpleKithen/back/connectors/message.php", false);
    xhr.send(param);
};

function confirmation(phone,code){
    var param = new FormData();
    param.append("phone", phone);
    param.append("code", code);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "http://localhost/SimpleKithen/back/connectors/sent_message.php", false);
    xhr.send(param);
    var data;
    if (xhr.status != 200) {
        data = ( xhr.status + ': ' + xhr.statusText );
    } else {
        data = JSON.parse( xhr.responseText );
    }
    return data;
};
