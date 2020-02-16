<?php
class addressbook {
  public function getDb() {
    $dsn = '';
    $usr = '';
    $passwd = '';
    $db = new PDO($dsn, $usr, $passwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }

  function e(string $str, string $charset = 'UTF-8'): string {
    return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, $charset);
  }

  public function inputDb() {
    try {
      $db = $this->getDb();
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // トランザクション開始
      $db->beginTransaction();
      $stt = $db->prepare('INSERT INTO addressbook(name, furigana, mail_address, sex, age, prefectures, phone_number)
      VALUES (:name, :furigana, :mail_address, :sex, :age, :prefectures, :phone_number)');
      // INSERT命令にPOSTデータの内容をセットしている
      $stt->bindValue(':name', $_POST['name']);
      $stt->bindValue(':furigana', $_POST['furigana']);
      $stt->bindValue(':mail_address', $_POST['mail_address']);
      $stt->bindValue(':sex', $_POST['sex']);
      $stt->bindValue(':age', $_POST['age']);
      $stt->bindValue(':prefectures', $_POST['prefectures']);
      $stt->bindValue(':phone_number', $_POST['phone_number']);
      // INSERT命令を実行
      $stt->execute();
      return $db->commit();
    } catch(PDOException $e) {
      $db->rollback();
      return print "エラーメッセージ：{$e->getMessage()}";
    } finally {
      $db = null;
    }
  }

  public function outputDb() {
    // レコードを入れる用の配列を作成
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    } else {
      $page = 1;
    }
    $addresses = array();
    try {
      $db = $this->getDb();
      $stt = $db->prepare("SELECT * FROM addressbook ORDER BY id LIMIT 10 OFFSET ".($page - 1) * 10);
      $stt->execute();
      while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
        // 配列内にループで1つずつ内容追加する
        array_push($addresses, $row);
      }
      return $addresses;
    } catch(PDOException $e) {
      return print "エラーメッセージ：{$e->getMessage()}";
    } finally {
      $db = null;
    }
  }

  public function pageCount() {
    try {
      $db = $this->getDb();
      $stt = $db->prepare('SELECT COUNT(*) AS count FROM addressbook');
      $stt->execute();
      return $stt->fetch(PDO::FETCH_ASSOC)['count'];
    } catch(PDOException $e) {
      return print "エラーメッセージ：{$e->getMessage()}";
    } finally {
      $db = null;
    }
  }

  public function pageDb() {
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    } else {
      $page = 1;
    }
    $pages = ceil($this->pageCount() / 10);
    return $pages;
  }

  public function deleteDb() {
    try {
      $db = $this->getDb();
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // トランザクション開始
      $db->beginTransaction();
      $stt = $db->prepare('DELETE FROM addressbook WHERE id = :del_id');
      // DELETE命令にPOSTデータの内容をセットしている
      $stt->bindValue(':del_id', $_POST['del_id']);
      // DELETE命令を実行
      $stt->execute();
      return $db->commit();
    } catch(PDOException $e) {
      $db->rollback();
      return print "エラーメッセージ：{$e->getMessage()}";
    } finally {
      $db = null;
    }
  }

  public function updateDb() {
    try {
      $db = $this->getDb();
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // トランザクション開始
      $db->beginTransaction();
      $stt = $db->prepare('UPDATE addressbook SET name = :new_name, furigana = :new_furigana, mail_address = :new_mail_address,
      sex = :new_sex, age = :new_age, prefectures = :new_prefectures, phone_number = :new_phone_number WHERE id = :new_id');
      $stt->bindValue(':new_id', $_POST['new_id']);
      $stt->bindValue(':new_name', $_POST['new_name']);
      $stt->bindValue(':new_furigana', $_POST['new_furigana']);
      $stt->bindValue(':new_mail_address', $_POST['new_mail_address']);
      $stt->bindValue(':new_sex', $_POST['new_sex']);
      $stt->bindValue(':new_age', $_POST['new_age']);
      $stt->bindValue(':new_prefectures', $_POST['new_prefectures']);
      $stt->bindValue(':new_phone_number', $_POST['new_phone_number']);
      $stt->execute();
      return $db->commit();
    } catch(PDOException $e) {
      $db->rollback();
      return print "エラーメッセージ：{$e->getMessage()}";
    } finally {
      $db = null;
    }
  }

  public function viewDb() {
    try {
      $db = $this->getDb();
      $stt = $db->prepare('SELECT * FROM addressbook WHERE id = :up_id');
      $stt->bindValue(':up_id', $_POST['up_id']);
      $stt->execute();
      $row = $stt->fetch(PDO::FETCH_ASSOC);
      return $row;
    } catch(PDOException $e) {
      return print "エラーメッセージ：{$e->getMessage()}";
    } finally {
      $db = null;
    }
  }

  public function selectDb() {
    $addresses = array();
    try {
      $db = $this->getDb();
      if (!empty($_POST['sel_name'])) {
        $stt = $db->prepare("SELECT id, name, furigana, mail_address, sex, age, prefectures, phone_number
        FROM addressbook WHERE name LIKE :sel_name ORDER BY id");
        $stt->bindValue(':sel_name', '%'.$_POST['sel_name'].'%');
        $stt->execute();
      }
      if (!empty($_POST['sel_mail_address'])) {
        $stt = $db->prepare('SELECT id, name, furigana, mail_address, sex, age, prefectures, phone_number
        FROM addressbook WHERE mail_address = :sel_mail_address ORDER BY id');
        $stt->bindValue(':sel_mail_address', $_POST['sel_mail_address']);
        $stt->execute();
      }
      if (!empty($_POST['sel_sex'])) {
        $stt = $db->prepare('SELECT id, name, furigana, mail_address, sex, age, prefectures, phone_number
        FROM addressbook WHERE sex = :sel_sex ORDER BY id');
        $stt->bindValue(':sel_sex', $_POST['sel_sex']);
        $stt->execute();
      }
      if (!empty($_POST['sel_age'])) {
        $stt = $db->prepare('SELECT id, name, furigana, mail_address, sex, age, prefectures, phone_number
        FROM addressbook WHERE age = :sel_age ORDER BY id');
        $stt->bindValue(':sel_age', $_POST['sel_age']);
        $stt->execute();
      }
      if (!empty($_POST['sel_prefectures'])) {
        $stt = $db->prepare('SELECT id, name, furigana, mail_address, sex, age, prefectures, phone_number
        FROM addressbook WHERE prefectures = :sel_prefectures ORDER BY id');
        $stt->bindValue(':sel_prefectures', $_POST['sel_prefectures']);
        $stt->execute();
      }
      if (!empty($_POST['sel_phone_number'])) {
        $stt = $db->prepare('SELECT id, name, furigana, mail_address, sex, age, prefectures, phone_number
        FROM addressbook WHERE phone_number = :sel_phone_number ORDER BY id');
        $stt->bindValue(':sel_phone_number', $_POST['sel_phone_number']);
        $stt->execute();
      }
      while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
        array_push($addresses, $row);
      }
      return $addresses;
    } catch(PDOException $e) {
      return print "エラーメッセージ：{$e->getMessage()}";
    } finally {
      $db = null;
    }
  }
}

class errors{
  public function errorCheck() {
    $error = array();
    if (empty($_POST['name'])) {
      $error[] = '名前を入力してください。';
    }
    if (empty($_POST['furigana'])) {
      $error[] = 'ふりがなを入力してください。';
    }
    if (!preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $_POST['mail_address'])) {
      $error[] = 'メールアドレスは正しく入力してください。';
    }
    if (empty($_POST['sex'])) {
      $error[] = '性別を選択してください。';
    }
    if (empty($_POST['age'])) {
      $error[] = '年齢を入力してください。';
    }
    if (mb_strlen($_POST['prefectures']) === 0) {
      $error[] = '都道府県を選択してください。';
    }
    if (!preg_match('/([0-9]{2,4})-([0-9]{2,4})-([0-9]{4})/', $_POST['phone_number'])) {
      $error[] = '電話番号は正しく入力してください。';
    }
    return $error;
  }

  public function errorCheck2() {
    $error = array();
    if (empty($_POST['del_id'])) {
      $error[] = 'IDを指定してください。';
    }
    return $error;
  }
  public function errorCheck3() {
    $error = array();
    if (!empty($_POST['new_mail_address'])) {
      if (!preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $_POST['new_mail_address'])) {
        $error[] = 'メールアドレスは正しく入力してください。';
      }
    }
    if (!empty($_POST['new_phone_number'])) {
      if (!preg_match('/([0-9]{2,4})-([0-9]{2,4})-([0-9]{4})/', $_POST['new_phone_number'])) {
        $error[] = '電話番号は正しく入力してください。';
      }
    }
    return $error;
  }
}