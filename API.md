# API

### 1. 注册

URL:  http://api.moinut.com/asker/register.php

PARAMS:

> **accountId** 长度 < 20
>
> **password**  长度 < 20
>
> **type**            'student' or 'teacher' 缺省 => 'student'

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

> **accountId** 长度 < 20
>
> **password**  长度 < 20

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

> **token**
>
> **title**
>
> **content**
>
> **type**

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

> **page**
>
> **count**

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

