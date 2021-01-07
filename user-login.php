<?php
// DB接続情報//作成したデータベース名を指定
$dbn = 'mysql:dbname=gsacf_d07_18;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

$username = $_POST['username'];
$password = $_POST['password'];
var_dump($_POST);

// if (isset($_POST['login'])) {
//   // $stmt->bindValue(':username', $username, PDO::PARAM_STR);
//   // $stmt->bindValue(':password', $password, PDO::PARAM_STR);


//   $sql = "SELECT * FROM users_table WHERE username = :username";
//   $stmt = $dbh->prepare($sql);
//   $stmt->bindValue(':username', $username);
//   $stmt->execute();
//   $member = $stmt->fetch();
//   if (password_verify($_POST['password'], $member['passworda'])) {
//     header('Location:input.php');
//   } else {
//     exit('sqlError:' . $error[2]);
//   }

// }else {
  //フォームに入力されたmailがすでに登録されていないかチェック
  $sql = "SELECT * FROM users_table WHERE username = :username";
  $stmt = $dbh->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
  $stmt->execute();
  $member = $stmt->fetch();

  if ($member['username'] === $username) {
    $msg = '同じusernameが存在します。';
    $link = '<a href="index.php">戻る</a>';
  } else {
    //登録されていなければinsert 
    
    if (
      //isset($var) varが存在してull以外の値をとればtrue,そうでなければfalse
      //ここでは!なので値がセットされていない場合となる
      !isset($_POST['username']) ||
      $_POST['username'] == '' ||
      !isset($_POST['password']) ||
      $_POST['password'] == ''
    ) {
      exit('ParamError');
    }

    $sql = 'INSERT INTO users_table(username,password)  VALUES (:username,:password)';
    
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    // }
    unset($pdo);
    header('Location:input.php');
    exit();
    
    // 失敗時にエラーを出力し，成功時は登録画面に戻る
    if ($status == false) {
      $error = $stmt->errorInfo();
      // データ登録失敗次にエラーを表示
      exit('sqlError:' . $error[2]);
    } else {
      // 登録ページへ移動
      header('Location:input.php');
    }
      }





//指定したハッシュがパスワードにマッチしているかチェック

// if (password_verify($_POST['password'], $member['passworda']) {
//     //DBのユーザー情報をセッションに保存
//     // $_SESSION['id'] = $member['id'];
//     // $_SESSION['name'] = $member['name'];
//     $msg = 'ログインしました。';
//     $link = '<a href="index.php">ホーム</a>';
// } else {
//     $msg = 'メールアドレスもしくはパスワードが間違っています。';
//     $link = '<a href="index.php">戻る</a>';
// }
// }