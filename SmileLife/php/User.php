<?php
require_once("DB.php");

class User extends DB {
//ログイン ＆　本人確認　OK
  public function login($arr) {
    $sql = 'SELECT * FROM users
    WHERE name = :name AND num = :num AND pass = :pass';
    $stmt = $this->connect->prepare($sql);
    $params = array(':name'=>$arr['name'],':num'=>$arr['num'],':pass'=>$arr['pass']);
    $stmt->execute($params);
    // $result = $stmt->rowCount();
    $result = $stmt->fetch();
    return $result;
  }
  //ユーザパスワード変更（個人用）
  public function passUpdate($arr) {
    $sql = "UPDATE users SET pass = :pass ,updated_at = :updated_at WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id'=>$arr['id'],
      ':pass'=>password_hash($arr['pass'],PASSWORD_DEFAULT),
      ':updated_at'=>date('Y-m-d')
    );
    $stmt->execute($params);
  }
  //クラス参照 OK
  public function findClass() {
    $sql = 'SELECT * FROM class';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }
  //特定クラス参照 OK
  public function findOneClass($id) {
    $sql = "SELECT * FROM class WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }
  //登録用！！特定クラス参照 OK
  public function insertClass($name) {
    $sql = "SELECT * FROM class WHERE name = :name";
    $stmt = $this->connect->prepare($sql);
    $params = array(':name'=>$name);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }
  //マイページ　ユーザ参照 OK
  public function findUser($id) {
    $sql = 'SELECT * FROM users WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }
  //日記参照 OK
  public function findDiary($id) {
    $sql = 'SELECT * FROM diary WHERE user_id = :user_id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':user_id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }
  //日記内容参照
  public function findBody($id) {
    $sql = 'SELECT * FROM diary WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }

  //特定のデータ取得 OK
  function getById($id){
    $sql = "SELECT * FROM users WHERE class_id = :class_id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':class_id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }
  //コメント参照
  public function findComment($id) {
    $sql = 'SELECT * FROM comment WHERE diary_id = :diary_id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':diary_id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }
  //閲覧済み確認
  public function checkCount($id) {
    $sql = 'SELECT COUNT(*) AS count FROM checked WHERE diary_id = :diary_id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':diary_id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }

  //編集
  public function findById($id) {
    $sql = 'SELECT * FROM users WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }
  //購入履歴
  public function findBuyhistory($id) {
    $sql = "SELECT users.id AS user_id, users.user_name, products.id AS product_id, products.name, users_products.num, users_products.created
    FROM users_products
    JOIN products ON products.id = users_products.product_id
    JOIN users ON users.id = users_products.user_id
    WHERE users.id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }
  //クラス登録 OK
  public function addClass($arr) {
    $sql = "INSERT INTO class(name,created_at) VALUES (:name, :created_at)";
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':name'=>$arr['class'],
      ':created_at'=>date('Y-m-d')
    );
    $stmt->execute($params);
  }
  //コメント 登録OK
  public function comment($arr) {
    $sql = "INSERT INTO comment(diary_id,body) VALUES (:diary_id, :body)";
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':diary_id'=>$arr['diary_id'],
      ':body'=>$arr['body'],
    );
    $stmt->execute($params);
  }
  //閲覧チェック OK
  public function checked($arr) {
    $sql = "INSERT INTO checked(user_id,diary_id,created_at) VALUES (:user_id, :diary_id, :created_at)";
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':user_id'=>$arr['user_id'],
      ':diary_id'=>$arr['diary_id'],
      ':created_at'=>date('Y-m-d')
    );
    $stmt->execute($params);
  }

  //日記登録
  public function addDiary($arr) {
    $sql = "INSERT INTO diary(user_id,title,body,created_at) VALUES (:user_id, :title, :body, :created_at)";
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':user_id'=>$arr['user_id'],
      ':title'=>$arr['title'],
      ':body'=>$arr['body'],
      ':created_at'=>date('Y-m-d')
    );
    $stmt->execute($params);
  }

  //クラスメンバー登録 OK
  public function addMem($arr) {
    $sql = "INSERT INTO users(class_id, name, num, pass, role, created_at) VALUES (:class_id, :name, :num, :pass, :role, :created_at)";
    $stmt = $this->connect->prepare($sql);
    $pass = $arr['pass'];
    $params = array(
      ':class_id'=>$arr['class_id'],
      ':name'=>$arr['name'],
      ':num'=>$arr['num'],
      ':pass'=>password_hash($pass,PASSWORD_DEFAULT),
      ':role'=>2,
      ':created_at'=>date('Y-m-d')
    );
    $stmt->execute($params);
  }
  //削除
  public function deleteClass($id = null) {
    if(isset($id)) {
      $sql = "DELETE FROM class WHERE id = :id";
      $stmt = $this->connect->prepare($sql);
      $params = array(':id'=>$id);
      $stmt->execute($params);
    }
  }
  //個人削除 OK
  public function deleteMem($id = null) {
    if(isset($id)) {
      $sql = "DELETE FROM users WHERE id = :id";
      $stmt = $this->connect->prepare($sql);
      $params = array(':id'=>$id);
      $stmt->execute($params);
    }
  }

  //クラス更新（先生用） OK
  public function classUpdate($arr) {
    $sql = "UPDATE users SET num = :num, name = :name, pass = :pass, updated_at = :updated_at WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    $pass = $arr['pass'];
    $params = array(
      ':id'=>$arr['id'],
      ':num'=>$arr['num'],
      ':name'=>$arr['name'],
      ':pass'=>password_hash($pass,PASSWORD_DEFAULT),
      ':updated_at'=>date('Y-m-d')
    );
    $stmt->execute($params);
  }

  //バリデーション ログイン画面
  public function validate($arr) {
    $message = array();
    //ユーザ名
    if(empty($arr['name'])) {
      $message['name'] = 'なまえを入力してね！';
    }
    //パスワード
    if(empty($arr['pass'])) {
      $message['pass'] = 'パスワードを入力してね！';
    }
    // else {
    //   if(!password_verify($arr['pass'], $user['pass']){
    //     $message['pass'] = 'パスワードがちがうよ！';
    //   }
    return $message;
    }
    //バリデーション　日記登録画面
    public function diaryValidate($arr) {
      $message = array();
      //ユーザ名
      if(empty($arr['title'])) {
        $message['title'] = 'タイトルを入力してね！';
      }
      //パスワード
      if(empty($arr['body'])) {
        $message['body'] = '本文を入力してね！';
      }
      return $message;
      }
      //バリデーション　クラス登録画面
      public function classValidate($arr) {
        $message = array();
        //ユーザ名
        if(empty($arr['class'])) {
          $message['class'] = 'クラスを入力してください。';
        }
        //パスワード
        // if(!empty($arr['num']) && !preg_match('/^[0-9]+$/', $arr['num'])) {
        //   $message['num'] = '半角数字のみ入力してください';
        // }
        return $message;
        }


  }

?>
