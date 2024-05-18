var current = 0;

function _i(id){
    return document.getElementById(id);
}

function _t(tg){
    return document.getElementsByTagName(tg);
}

function hideMsg(){
    window.setTimeout(function(){
        _i("msg").style.display = "none";
    }, 3000);
}

function showTab(n){
    var tab = _i("container").getElementsByTagName("div");
    tab[n].style.display = "block";
    if(n == 0){
        _i("prev").style.display = "none";
    }
    else{
        _i("prev").style.display = "inline";
    }
    if(n == 2){
        _i("next").innerHTML = "Submit";
    }
    else{
        _i("next").innerHTML = "Next";
    }
    changeProgress(current);
}

function nextPrev(n){
    var tab = _i("container").getElementsByTagName("div");
    if(n == 1 && !validateForm()){
        return false;
    }
    tab[current].style.display = "none";
    current = current + n;
    if(current == 3){
        _i("regForm").submit();
    }
    var pro = _t("li");
    for(var i = 0; i < 3; i++){
        pro[i].style.fontWeight = "100";
    }
    pro[current].style.fontWeight = "900";
    showTab(current);
}

function validateForm(){
    var tab, inp, i, valid = true;
    // tab = _i("container").getElementsByTagName("div");
    // inp = tab[current].getElementsByTagName("input");
    // if(current == 0){
    //     if(inp[1].value != inp[2].value){
    //         inp[1].className += " invalid";
    //         inp[2].className += " invalid";
    //         valid = false;
    //     }
    // }
    // for(i = 0; i < 3; i++){
    //     if(inp[i].value == ""){
    //         inp[i].className += " invalid";
    //         valid = false;
    //     }
    // }
    return valid;
}

function changeProgress(n){
    var pro = _t("li");
    pro[n].className += " active";
}
