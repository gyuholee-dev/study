// 로그인

// 슬라이드 오픈
function openSlide(target, form) {
    target.classList.add('open');
    form.message.focus();
}

// 슬라이드 클로즈
function closeSlide(target, form) {
    target.classList.remove('open');
    setTimeout(function () {
        form.message.value = ''; // 메시지 리셋
    }, 500);
}

// 글 입력
function checkPost(form) {
    if (form.message.value == "") { 
        alert("내용을 입력해주세요.");
        form.message.focus();
        return false;
    }
    if (form.userfile.value == "") {
        alert("사진을 첨부해주세요.");
        return false;
    } else {
        let fileName = form.userfile.value;
        let fileExt = fileName.split('.').pop();
        if (fileExt != "jpg" && fileExt != "jpeg" && fileExt != "png" && fileExt != "gif") {
            alert("jpg, jpeg, png, gif 파일만 업로드 가능합니다.");
            form.userfile.value = "";
            return false;
        }
    }
    form.submit();
}

// 답글 입력
function checkReply(form) {
    if (form.message.value == "") {
        alert("내용을 입력해주세요.");
        form.message.focus();
        return false;
    }
    form.submit();
}