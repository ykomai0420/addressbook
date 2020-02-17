<?php
require_once 'addressbook.php';

$err = new errors();
$cls = new addressbook();
if (empty($err->errorCheck2())) {
  $cls->deleteDb();
  print '削除しました。';
}
if (!empty($_POST['sel_reset'])) {
  $cls->outputDb();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>addressbook</title>
    <style>
    h1 {
      background-color :#000080;
      color :#ffffff;
      width :820px;
    }
    ul {
      list-style :none;
    }
    th {
      background-color :#000080;
      color :#ffffff;
    }
    </style>
  </head>
  <body>
  <h1>addressbook</h1>
  <a href="http://yuya1225.xsrv.jp/learning/addressbook/addressbook_input.php">入力フォームへ</a>
  <h2>情報一覧</h2>
  <form method="POST" action="addressbook_view.php">
    <ul>
      <li>
        <label>名前:<input type="text" name="sel_name"></label>
      </li>
      <li>
        <label>メールアドレス:<input type="text" name="sel_mail_address"></label>
      </li>
      <li>
        <label>性別:<input type="radio" name="sel_sex" value="男">男</label>
        <label><input type="radio" name="sel_sex" value="女">女</label>
      </li>
      <li>
        <label>年齢:<input type="text" name="sel_age"></label>
      </li>
      <li>
      <label>都道府県:<select name="sel_prefectures">
            <option value="">選択してください</option>
            <option value="東京都">東京都</option>
            <option value="北海道">北海道</option>
            <option value="青森県">青森県</option>
            <option value="岩手県">岩手県</option>
            <option value="宮城県">宮城県</option>
            <option value="秋田県">秋田県</option>
            <option value="山形県">山形県</option>
            <option value="福島県">福島県</option>
            <option value="茨城県">茨城県</option>
            <option value="栃木県">栃木県</option>
            <option value="群馬県">群馬県</option>
            <option value="埼玉県">埼玉県</option>
            <option value="千葉県">千葉県</option>
            <option value="神奈川県">神奈川県</option>
            <option value="新潟県">新潟県</option>
            <option value="富山県">富山県</option>
            <option value="石川県">石川県</option>
            <option value="福井県">福井県</option>
            <option value="山梨県">山梨県</option>
            <option value="長野県">長野県</option>
            <option value="岐阜県">岐阜県</option>
            <option value="静岡県">静岡県</option>
            <option value="愛知県">愛知県</option>
            <option value="三重県">三重県</option>
            <option value="滋賀県">滋賀県</option>
            <option value="京都府">京都府</option>
            <option value="大阪府">大阪府</option>
            <option value="兵庫県">兵庫県</option>
            <option value="奈良県">奈良県</option>
            <option value="和歌山県">和歌山県</option>
            <option value="鳥取県">鳥取県</option>
            <option value="島根県">島根県</option>
            <option value="岡山県">岡山県</option>
            <option value="広島県">広島県</option>
            <option value="山口県">山口県</option>
            <option value="徳島県">徳島県</option>
            <option value="香川県">香川県</option>
            <option value="愛媛県">愛媛県</option>
            <option value="高知県">高知県</option>
            <option value="福岡県">福岡県</option>
            <option value="佐賀県">佐賀県</option>
            <option value="長崎県">長崎県</option>
            <option value="熊本県">熊本県</option>
            <option value="大分県">大分県</option>
            <option value="宮崎県">宮崎県</option>
            <option value="鹿児島県">鹿児島県</option>
            <option value="沖縄県">沖縄県</option>
          </select></label>
      </li>
      <li>
        <label>電話番号:<input type="tel" name="sel_phone_number"></label>
      </li>
      <li>
        <input type="submit" name="sel_submit" value="検索">
      </li>
      <li>
        <input type="submit" name="sel_reset" value="リセット">
      </li>
    </ul>
  </form>
    <table border="1">
    <?php
      if (empty($err->errorCheck)) {
        $val = $cls->outputDb();
      }
      if (!empty($_POST['sel_submit'])) {
        $val = $cls->selectDb();
      }
      ?>
      <tr>
        <th>ID</th>
        <th>名前</th>
        <th>ふりがな</th>
        <th>メールアドレス</th>
        <th>性別</th>
        <th>年齢</th>
        <th>都道府県</th>
        <th>電話番号</th>
        <th>削除</th>
        <th>変更</th>
      </tr>
      <?php
      foreach ((array)$val as $output) { ?>
      <tr>
        <td><?php print $cls->e($output['id']); ?></td>
        <td><?php print $cls->e($output['name']); ?></td>
        <td><?php print $cls->e($output['furigana']); ?></td>
        <td><?php print $cls->e($output['mail_address']); ?></td>
        <td><?php print $cls->e($output['sex']); ?></td>
        <td><?php print $cls->e($output['age']); ?></td>
        <td><?php print $cls->e($output['prefectures']); ?></td>
        <td><?php print $cls->e($output['phone_number']); ?></td>
        <form method="POST" action="addressbook_view.php">
          <input type="hidden" name="del_id" value="<?php print $output['id']; ?>">
          <td><input type="submit" name="delete" value="削除"></td>
        </form>
        <form method="POST" action="addressbook_view.php">
          <input type="hidden" name="up_id" value="<?php print $output['id']; ?>">
          <td><input type="submit" name="update" value="変更"
          formaction="http://yuya1225.xsrv.jp/learning/addressbook/addressbook_crud.php"></td>
        </form>
      </tr>
      <?php } ?>
    </table>
    <?php 
    for ($i = 1; $i <= $cls->pageDb(); $i++) {
      print '<a href="http://yuya1225.xsrv.jp/learning/addressbook/addressbook_view.php?page='. $i. '">'. "\t". $i. "\t". '</a>';
    } ?>
  </body>
</html>