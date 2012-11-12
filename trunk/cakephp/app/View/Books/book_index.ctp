<h1>書籍資料列表</h1>
<p><?php if ($version_id != null) { echo $this->Html->link('新增書籍資料', array('action' => 'book_edit/'.$version_id)); }?></p>
<table>
    <tr>
        <th>編號</th>
        <th>書籍名稱</th>
        <th>作者</th>
        <th>ISBN</th>
        <th>版本名稱</th>
        <th>索書號</th>
        <th>櫃別</th>
        <th>購買金額</th>
		<th>狀態</th>
		<th>借閱等級</th>
		<th>購入日期</th>
        <th></th>
    </tr>
    <?php foreach ($books as $book): ?>
    <tr>
        <td><?php echo $book['Book']['id']; ?></td>
        <td>
            <?php echo $book['Book_Basic']['book_name']; ?>
        </td>
        <td>
            <?php echo $book['Book_Basic']['book_author']; ?>
        </td>
        <td>
            <?php echo $book['Book_Version']['isbn']; ?>
        </td>
        <td>
            <?php echo $book['Book_Version']['book_version']; ?>
        </td>
        <td>
            <?php echo $book['Book_Version']['book_search_code']; ?>
        </td>
        <td>
            <?php echo $book['Book_Version']['book_location']; ?>
        </td>
        <td>
            <?php echo $book['Book']['purchase_price']; ?>
        </td>
        <td>
            <?php echo $book_status[$book['Book']['book_status']]; ?>
        </td>
        <td>
            <?php echo $person_levels[$book['Book']['person_level']]; ?>
        </td>
        <td>
            <?php echo $book['Book']['purchase_date']; ?>
        </td>
        <td>
            <?php 
				$delbtn = '生效';
				if ($book['Book']['valid']) {
					echo $this->Html->link('修改', array('action' => 'book_edit', $version_id, $book['Book']['id']));
					$delbtn = '失效';
					echo '&nbsp';
				}
				echo $this->Form->postLink(
				$delbtn,
				array('action' => 'book_delete', $book['Book']['id']),
				array('confirm' => '確認變更?'));
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
