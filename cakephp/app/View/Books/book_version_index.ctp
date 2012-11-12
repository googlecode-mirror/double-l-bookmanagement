<h1>書籍版本資料列表</h1>
<p><?php if ($basic_id != null) { echo $this->Html->link('新增書籍版本資料', array('action' => 'book_version_edit/'.$basic_id)); }?></p>
<table>
    <tr>
        <th>編號</th>
        <th>書籍名稱</th>
        <th>作者</th>
        <th>ISBN</th>
        <th>版本名稱</th>
        <th>索書號</th>
        <th>櫃別</th>
        <th>登記日期</th>
        <th></th>
    </tr>
    <?php foreach ($book_versions as $book_version): ?>
    <tr>
        <td><?php echo $book_version['Book_Version']['id']; ?></td>
        <td>
            <?php echo $book_version['Book_Basic']['book_name']; ?>
        </td>
        <td>
            <?php echo $book_version['Book_Basic']['book_author']; ?>
        </td>
        <td>
            <?php echo $book_version['Book_Version']['isbn']; ?>
        </td>
        <td>
            <?php echo $book_version['Book_Version']['book_version']; ?>
        </td>
        <td>
            <?php echo $book_version['Book_Version']['book_search_code']; ?>
        </td>
        <td>
            <?php echo $book_version['Book_Version']['book_location']; ?>
        </td>
        <td>
            <?php echo $book_version['Book_Version']['create_time']; ?>
        </td>
        <td>
            <?php 
				echo $this->Html->link('修改', array('action' => 'book_version_edit', $basic_id, $book_version['Book_Version']['id']));
				echo '&nbsp';
				echo $this->Html->link('書籍資訊', array('action' => 'book_index', $book_version['Book_Version']['id']));
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
