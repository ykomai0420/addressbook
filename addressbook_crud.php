<?php
require_once 'addressbook.php';

$err = new errors();
$cls = new addressbook();
if (empty($err->errorCheck3())) {
  $cls->updateDb();
}
if (!empty($_POST['new_submit'])) {
  print '更新しました。';
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
    .errors {
      color :#ff0000;
    }
    </style>
  </head>
  <body>
    <h1>addressbook</h1>
    <h2>更新フォーム</h2>
    <p>更新したい情報を入力してください。</p>
    <ul>
    <?php if (isset($_POST['new_submit'])) { ?>
      <?php foreach ((array)$err->errorCheck3() as $val) { ?>
      <li class="errors">
        <?php print $val ?>
      </li>
      <?php } ?>
    <?php } ?>
    </ul>
    <?php $val = $cls->viewDb(); ?>
    <form method="POST" action="addressbook_crud.php">
      <ul>
          <li>
            <label>指定ID:<input type="text" name="new_id" value="<?php print $val['id']; ?> " readonly></label>
          </li>
          <li>
            <label>名前:<input type="text" name="new_name" value="<?php print $val['name']; ?>"></label>
          </li>
          <li>
            <label>ふりがな:<input type="text" name="new_furigana" value="<?php print $val['furigana']; ?>"></label>
          </li>
          <li>
            <label>メールアドレス:<input type="text" name="new_mail_address" value="<?php print $val['mail_address']; ?>"></label>
          </li>
          <li>
            <label>性別:<input type="radio" name="new_sex" value="男"
            <?php if ($val['sex'] === "男") { ?> checked <?php } ?>>男</label>
            <label><input type="radio" name="new_sex" value="女"
            <?php if ($val['sex'] === "女") { ?> checked <?php } ?>>女</label>
          </li>
          <li>
            <label>年齢:<input type="text" name="new_age" value="<?php print $val['age']; ?>"></label>
          </li>
          <li>
            <label>都道府県:<select name="new_prefectures">
            <option value=<?php print $val['prefectures']; ?>><?php print $val['prefectures']; ?></option>
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
          <label>電話番号:<input type="tel" name="new_phone_number" value="<?php print $val['phone_number']; ?>"></label>
        </li>
        <li>
          <input type="submit" name="new_submit" value="更新">
        </li>
        <li>
          <input type="reset" name="new_reset" value="リセット">
        </li>
      </ul>
    </form>
    <a href="http://localhost/selfphp/addressbook/addressbook_view.php">情報一覧へ</a>
  </body>
</html>