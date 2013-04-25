<div>
<div class="pageheader_div"><h1 id="pageheader">書籍資料新增</h1></div>
<div class="pagemenu_div"><?php 
    echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
    echo '&nbsp;';
    if($this->Session->read('user_role') !== 'user') {
    echo $this->Html->link('新增', array('action' => 'book_edit'), array('class' => 'button blue'));
    echo '&nbsp;';
    echo $this->Html->link('匯出書籍', array('action' => 'book_export'), array('class' => 'button blue'));
    echo '&nbsp;';
        
    }
?></div>
<div class="pagemenu_div"><?php 
    
    if($this->Session->read('user_role') !== 'user') {
    echo $this->Form->create('Book',array('action'=>'isbn_add', 'clear'=>'right','div'=>false, 'inputDefaults' => array('label' => false,'div' => false)));
    echo 'ISBN:';
    echo $this->Form->input('isbn', array('size'=>13));
    echo '&nbsp;';
    echo $this->Form->button('ISBN 新增', array('class'=>'button normal blue'));
    echo $this->Form->end();
    echo '&nbsp;';
    }    
?></div>
<div class="pagemenu_div"><?php 
    
    if($this->Session->read('user_role') !== 'user') {
    echo $this->Form->create('Book',array('action'=>'isbn_cn_add', 'clear'=>'right','div'=>false, 'inputDefaults' => array('label' => false,'div' => false)));
    echo 'ISBN:';
    echo $this->Form->input('isbn', array('size'=>13));
    echo '&nbsp;';
    echo $this->Form->button('ISBN 中文新增', array('class'=>'button normal blue'));
    echo $this->Form->end();
    echo '&nbsp;';
    }    
?></div>
