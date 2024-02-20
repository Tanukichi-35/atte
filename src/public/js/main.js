window.onload = function () {

  // 打刻ページのボタンの有効/無効をステータスに応じて変更
  if (location.pathname == "/") {
    const button__workStart = document.getElementById('button__work-start');
    const button__workEnd = document.getElementById('button__work-end');
    const button__breakStart = document.getElementById('button__break-start');
    const button__breakEnd = document.getElementById('button__break-end');
    const input__status = document.getElementById('input__status');

    if (input__status.value == 0) {
      button__workStart.disabled = false;
      button__workEnd.disabled = true;
      button__breakStart.disabled = true;
      button__breakEnd.disabled = true;
    }
    if (input__status.value == 1) {
      button__workStart.disabled = true;
      button__workEnd.disabled = false;
      button__breakStart.disabled = false;
      button__breakEnd.disabled = true;
    }
    else if (input__status.value == 2) {
      button__workStart.disabled = true;
      button__workEnd.disabled = true;
      button__breakStart.disabled = true;
      button__breakEnd.disabled = true;
    }
    else if (input__status.value == 3) {
      button__workStart.disabled = true;
      button__workEnd.disabled = false;
      button__breakStart.disabled = true;
      button__breakEnd.disabled = false;
    }
  }
  else if (location.pathname == "/attendance"){

  }
  else if (location.pathname == "/login"){

  }
  else if (location.pathname == "/register") {
    
  }
}
