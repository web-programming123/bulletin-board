function checkDuplicate() {
    const userid = document.getElementById("userid").value;
    if (!userid) {
        alert("아이디를 입력하세요.");
        return;
    }

    fetch("check_userid.php?userid=" + encodeURIComponent(userid))
        .then(res => res.text())
        .then(data => {
            alert(data.trim());
        })
        .catch(() => {
            alert("중복 확인 중 오류가 발생했습니다.");
        });
}
