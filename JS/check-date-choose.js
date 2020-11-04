function checkDateChoose() {
    var dateChoose = document.forms['dateChooseInput']['dateChoose'].value;

    if (dateChoose == "") {
        alert("Bạn chưa chọn ngày!");
        return false;
    }
}