# Asker Backend
[Asker](https://github.com/moiling/Asker)的后端代码

# API

### 1. 注册

URL:  http://api.moinut.com/asker/register.php

PARAMS:

> **accountId** - String - 长度 < 20 - 账号
>
> **password**  - String - 长度 < 20 - 密码
>
> **type**            - String - 'student' or 'teacher' 缺省 => 'student' - 类型

RETURN:

```javascript
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

```javascript
{
  "state": 200,
  "info": "success",
  "data": {
    "id": 5, // 唯一id，虽然没啥用，但还是返回了
    "type": "student", // 账户类型(student & teacher)
    "nickName": "MOILING", // 昵称 
    "date": "2016-06-01 17:47:21", // 注册时间
    "sex": "male", // 性别(male & female)
    "tel": "110", // 电话
    "email": "super8moi@gmail.com", // 邮箱
    "token": "ca06eeddb640d398059eb9d827d11ca5fdcabe54" // token
  }
}
```

### 3. 提问

URL: http://api.moinut.com/asker/askQuestion.php

PARAMS:

> **token**      - String
>
> **title**         - String - 标题
>
> **content**  - String - 内容
>
> **type**        - String - 类型

RETURN:

```javascript
{
  "state": 200,
  "info": "success",
  "data": "提问成功"
}
```

### 4. 查看问题

URL: http://api.moinut.com/asker/getAllQuestions.php

PARAMS:

> 必填:
>
> **page**   - int - 第几页，程序员是从0开始的
>
> **count** - int - 一页返回多少条数据
>
> 选填:
>
> **token** - String - 只有上传这玩意才能知道是否点过赞了，否则stared永远是false

RETURN:

```javascript
{
  "state": 200,
  "info": "success",
  "totalCount": 2, // 一共有多少条信息
  "totalPage": 1, // 照你传的count来计算，一共有多少页
  "currentPage": 0, // 当前页
  "data": [
    {
      "id": "46", // 问题id，用于查看答案和回复时传的questionId
      "contentId": "57", // 这个对于客户端来说，完！全！没！用！
      "title": "这里是标题", // 问题标题
      "date": "2016-06-01 23:13:21", // 问题发布日期
      "recent": "2016-06-01 23:13:21", // 问题最后更新日期
      "type": "测试", // 问题类型
      "answerCount": "0", // 回答个数
      "bestAnswerId": null, // 最佳答案，记得判null，不好意思返回了null
      "starCount": "0", // 点赞数目
      "authorName": "MOILING", // 提问者名字
      "content": "这里是详细内容之类巴拉巴拉的", // 问题内容
      "stared": false // 是否已点赞，只有当传token的时候有效，否则都是false
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
      "content": "反正就是好烦，怎么办呢！没法做事了呀！！！！好烦好烦好烦！",
      "stared": false
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
> **year**             - int       - **Student Only**
>
> **major**          - String - **Student Only**
>
> **realName**   - String - **Teacher Only**

RETURN:

```javascript
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

```javascript
{
  "state": 200,
  "info": "Success",
  "data": {
    "id": 5, // 用户id
    "type": "student", // 用户类型(student & teacher)
    "nickName": "MOILING", // 昵称
    "date": "2016-06-01 17:47:21", // 注册时间
    "sex": "female", // 性别(male & female)
    "tel": "18883992395", // 电话
    "email": "super8moi@gmail.com", // 邮箱
    "token": "d64177833a3b7f90ab41fe1106d4eb900f730f65", // token，为什么要返回……
    "studentId": 1, // 学生id
    "college": "重庆邮电大学", // 学校
    "academy": "软件工程", // 学院
    "year": 2014, // 入学年份
    "major": "软件工程" // 专业
  }
}
```

2、Teacher类型

```javascript
{
  "state": 200,
  "info": "Success",
  "data": {
    "id": 7,
    "type": "teacher",
    "nickName": "凌老师",
    "date": "2016-06-01 17:53:30",
    "sex": "male",
    "tel": "18883992395",
    "email": "super8moi@gmail.com",
    "token": "f2e7e23ae90a3473558ea0376024ed4e0d9d4523",
    "teacherId": 1, // 教师id
    "college": "重庆邮电大学", // 学校
    "academy": "软件工程", // 学院
    "realName": "莫伊", // 真实姓名
    "authentication": false // 是否认证
  }
}
```

### 7. 回答

URL: http://api.moinut.com/asker/answer.php

PARAMS:

> **token**            - String
>
> **questionId**  - int - 就是获取问题时得到的id
>
> **content**        - String - 回复内容

RETURN:

```javascript
{
  "state": 200,
  "info": "success",
  "data": "回答成功"
}
```

### 8. 查看回答列表

URL: http://api.moinut.com/asker/getAnswers.php

PARAMS:

> **questionId** - int - 就是获取问题时得到的id
>
> **page**            - int
>
> **count**          - int

RETURN:

```javascript
{
  "state": 200,
  "info": "success",
  "totalCount": 2,
  "totalPage": 1,
  "currentPage": 0,
  "data": [
    {
      "id": 2,
      "contentId": 2, // 完！全！没！用！
      "date": "2016-06-13 16:40:46", // 回复时间
      "questionId": 83,
      "likeNumber": 0, // 喜欢个数
      "dislikeNumber": 0, // 不喜欢个数
      "authorName": "Teacher", // 回答者名字
      "content": "我虽然没讲，但我默认你都会了" // 回复内容
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

### 9. 点赞 & 取消赞

URL: http://api.moinut.com/asker/starQuestion.php

PARAMS:

> **questionId** - int - 就是获取问题时得到的id
>
> **token**           - String

```javascript
{
  "state": 200,
  "info": "success",
  "data": {
    "type": "star", // 状态(star & unStar),目前操作后你时候赞了
    "count": 2 // 该问题目前点赞数
  }
}
```

### 10. 评价回复（顶 & 踩）

URL: http://api.moinut.com/asker/likeAnswer.php

PARAMS:

> **answerId** - int - 就是获取回答时得到的id
>
> **type**          - String - like & dislike - 顶还是踩
>
> **token**       - String

```javascript
{
  "state": 200,
  "info": "success",
  "data": 2 // 该操作后（顶数-踩数）
}
```

### 11. 查看我点赞的问题列表

URL: http://api.moinut.com/asker/getStarQuestions.php

其余和**查看问题列表**一样

### 12. 查看我发出的问题列表

URL: http://api.moinut.com/asker/getMyQuestions.php

其余和**查看问题列表**一样

