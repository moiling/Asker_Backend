# API

### 1. 注册

URL:  http://api.moinut.com/asker/register.php

PARAMS:

> **accountId** - String - 长度 < 20
>
> **password**  - String - 长度 < 20
>
> **type**            - String - 'student' or 'teacher' 缺省 => 'student'

RETURN:

```json
{
  "state": 200,
  "info": "success",
  "data": "注册成功"
}
```

### 2. 登录

URL: http://api.moinut.com/asker/login.php

PARAMS:

> **accountId** - String - 长度 < 20
>
> **password**  - String - 长度 < 20

RETURN:

```json
{
  "state": 200,
  "info": "success",
  "data": {
    "id": 5,
    "type": "student",
    "nickName": "MOILING",
    "date": "2016-06-01 17:47:21",
    "sex": "male",
    "tel": "110",
    "email": "super8moi@gmail.com",
    "token": "ca06eeddb640d398059eb9d827d11ca5fdcabe54"
  }
}
```

### 3. 提问

URL: http://api.moinut.com/asker/askQuestion.php

PARAMS:

> **token**      -String
>
> **title**         -String
>
> **content**  -String
>
> **type**        -String

RETURN:

```json
{
  "state": 200,
  "info": "success",
  "data": "提问成功"
}
```

### 4. 查看问题

URL: http://api.moinut.com/asker/getAllQuestions.php

PARAMS:

> **page**   - int
>
> **count** - int

RETURN:

```json
{
  "state": 200,
  "info": "success",
  "totalCount": 2,
  "totalPage": 1,
  "currentPage": "0",
  "data": [
    {
      "id": "46",
      "contentId": "57",
      "title": "这里是标题",
      "date": "2016-06-01 23:13:21",
      "recent": "2016-06-01 23:13:21",
      "type": "测试",
      "answerCount": "0",
      "bestAnswerId": null,
      "starCount": "0",
      "authorName": "MOILING",
      "content": "这里是详细内容之类巴拉巴拉的"
    },
    {
      "id": "45",
      "contentId": "56",
      "title": "最近好烦啊！怎么办？",
      "date": "2016-06-01 23:12:40",
      "recent": "2016-06-01 23:12:40",
      "type": "生活",
      "answerCount": "0",
      "bestAnswerId": null,
      "starCount": "0",
      "authorName": "MOILING",
      "content": "反正就是好烦，怎么办呢！没法做事了呀！！！！好烦好烦好烦！"
    }
  ]
}
```

### 5. 修改用户信息

URL: http://api.moinut.com/asker/updateUserInfo.php

PARAMS:

> 必填：
>
> **type**     - String -  'student' or 'teacher'  
>
> **token**  - String
>
> 选填:
>
> **nickName**  - String
>
> **sex**               - String - 'male' or 'female'
>
> **tel**                - String
>
> **email**           - String
>
> **college**        - String
>
> **academy**    - String
>
> **year**             - int       - Student Only
>
> **major**          - String - Student Only
>
> **realName**   - String - Teacher Only

RETURN:

```json
{
  "state": 200,
  "info": "Success",
  "data": "资料更新成功"
}
```

### 6. 获得用户信息

URL: http://api.moinut.com/asker/getUserInfo.php

PARAMS:

> **type**     - String -  'student' or 'teacher'  
>
> **token**  - String

RETURN:

1、Student类型

```JSON
{
  "state": 200,
  "info": "Success",
  "data": {
    "id": 1,
    "college": "CQUPT",
    "academy": "Software",
    "year": 2014,
    "major": "Software",
    "user": {
      "id": 5,
      "type": "student",
      "nickName": "MOILING",
      "date": "2016-06-01 17:47:21",
      "sex": "male",
      "tel": "110",
      "email": "super8moi@gmail.com",
      "token": "77712a2b924e85ba20162ca9abdeb415a73f9d86"
    }
  }
}
```

2、Teacher类型

```json
{
  "state": 200,
  "info": "Success",
  "data": {
    "id": 1,
    "college": "CQUPT",
    "academy": "Software",
    "realName": "张三",
    "authentication": "0", // 0->未认证  1->已认证
    "user": {
      "id": 7,
      "type": "teacher",
      "nickName": "Teacher",
      "date": "2016-06-01 17:53:30",
      "sex": "male",
      "tel": "1234567890",
      "email": "a@b.c",
      "token": "f42b08eaf8fa88296af5900c0b06d6c35b575aa6"
    }
  }
}
```

### 7. 回答

URL: http://api.moinut.com/asker/answer.php

PARAMS:

> **token**            - String
>
> **questionId**  - int
>
> **content**        - String

RETURN:

```json
{
  "state": 200,
  "info": "success",
  "data": "回答成功"
}
```

### 8. 查看回答列表

URL: http://api.moinut.com/asker/getAnswers.php

PARAMS:

> **questionId** - int
>
> **page**            - int
>
> **count**          - int

RETURN:

```json
{
  "state": 200,
  "info": "success",
  "totalCount": 2,
  "totalPage": 1,
  "currentPage": 0,
  "data": [
    {
      "id": 2,
      "contentId": 2,
      "date": "2016-06-13 16:40:46",
      "questionId": 83,
      "likeNumber": 0,
      "dislikeNumber": 0,
      "authorName": "Teacher",
      "content": "我虽然没讲，但我默认你都会了"
    },
    {
      "id": 3,
      "contentId": 3,
      "date": "2016-06-13 17:01:55",
      "questionId": 83,
      "likeNumber": 0,
      "dislikeNumber": 0,
      "authorName": "Teacher",
      "content": "记得下周交作业！"
    }
  ]
}
```



