<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('請輸入你的帳號與密碼'); ?></legend>
    <?php
        echo $this->Form->input('username', array('label'=>'帳號'));
        echo $this->Form->input('password', array('label'=>'密碼'));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>
</div>
