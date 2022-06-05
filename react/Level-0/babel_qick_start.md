# BABEL Qick Start
맥OS에서 BABEL 설치 및 사용하기
> NodeJs, npm 이 설치되어 있어야 합니다.

## BABEL 설치

### 1. 우선 npm 버전을 최신으로 업데이트 합니다.
```
$ npm install -g npm
```

### 2. babel 설치
```
$ npm install -g babel
```

### 3. 확인
```
$ babel version
```
아래와 같은 메세지가 출력되었습니다.
```
    npm uninstall -g babel
    npm install --save-dev babel-cli
```

### 4. babel-cli 설치
```
$ npm install --save-dev -g babel-cli
```

### 5. 확인
```
$ babel version
```
```
6.24.0 (babel-core 6.24.0)
```


## babel 사용

### 1. 디랙토리 만들기
```
$ mkdir babel_test
```
```
$ cd ./babel_test
```

### 2. npm init
```
$ npm init
```
```
name: babel_test
version: 1.0.0
description: ''
entry point: index.js
test command: test
git repositroy: ''
keywords: ''
author: FALSY
license: WTFPL
```
```
{
  "name": "babel_test",
  "version": "1.0.0",
  "description": "",
  "main": "index.js",
  "scripts": {
    "test": "test"
  },
  "author": "FALSY",
  "license": "WTFPL"
}

Is this ok? : yes
```

### 3. 프로젝트에 babel 설치
```
$ npm install --save-dev babel-core babel-cli babel-preset-es2015
```
```
//package.json
{
  "name": "babel_test",
  "version": "1.0.0",
  "description": "",
  "main": "index.js",
  "scripts": {
    "test": "test"
  },
  "author": "FALSY",
  "license": "WTFPL",
  "devDependencies": {
    "babel": "^6.23.0",
    "babel-cli": "^6.24.0",
    "babel-core": "^6.24.0",
    "babel-preset-es2015": "^6.24.0"
  }
}
```

### 4. 테스트 ori_js.js
```
$ vi ori_js.js
```
vi 에디터로 ori_js.js를 만들어 아래와 같이 수정
```
let test = 'ok';
alert(test);
```

### 5. npm command 설정
```
//package.json
"scripts": {
  "test": "test"
},
```
이부분을
```
//package.json
"scripts": {
  "build": "babel ori_js.js --out-file new_js.js --presets=es2015"
},
```
이렇게 수정

### 6. babel 사용
```
$ npm run build
```

### 7. 확인
```
$ cat ./new_js.js
```
```
'use strict';

var test = 'ok';
alert(test);
```

## 그밖의 자세한 정보는
[BABEL](https://babeljs.io/)에서 확인할 수 있습니다.