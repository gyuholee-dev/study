console.log('SCRIPT STARTED');

// Promise XMLHttpRequest
async function requestData(pathname, param = null) {  
  let request = '';
  if (param !== null) {
    for (let key in param) {
      if (key === Object.keys(param)[0]) {
        request += key+'='+param[key];
      } else {
        request += '&'+key+'='+param[key];
      }
    }
  }
  // console.log('XHR:', request);
  try {
    const xhr = new XMLHttpRequest();
    // post 전송
    // http://daplus.net/javascript-xmlhttprequest%EB%A5%BC-%EC%82%AC%EC%9A%A9%ED%95%98%EC%97%AC-post-%EB%8D%B0%EC%9D%B4%ED%84%B0-%EB%B3%B4%EB%82%B4%EA%B8%B0/
    xhr.open('POST', pathname, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(request);

    const result = await new Promise((resolve, reject) => {
      xhr.onload = function () {
        if (xhr.status == 200) {
          resolve(xhr.response);
        } else {
          reject(Error(xhr.statusText));
        }
      };
    });
    return result;
  } catch (error) {
    throw Error(error);
  }
}
// XHR Request
async function xhr(func, param = null) {
  const pathname = window.location.pathname;
  if (param === null) {
    param = {};
  }
  if (param['call'] === undefined) {
    param['call'] = func;
  }
  let result = await requestData(pathname, param);
  if (result) {
    return JSON.parse(result);
  }
}

// ------------------------------------------------------------

const DOMLoaded = async()=>{

  const testData = await xhr('test', {name: 'john', age: '30'});
  console.log('TEST DATA:', testData);

}
document.addEventListener("DOMContentLoaded", DOMLoaded);
