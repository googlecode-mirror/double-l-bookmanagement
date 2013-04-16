<?php
/**中文*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!--
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	-->

	<?php echo $this->Html->charset(); ?>
	<title>
		<?php //echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		//header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
		//header('Pragma: no-cache'); // HTTP 1.0.
		header('Expires: 0'); // Proxies.
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('application');
		echo $this->Html->css('redmond/jquery-ui-1.9.1.custom.css');
        echo $this->Html->script('jquery-1.8.2.js');
        echo $this->Html->script('jquery-ui-1.9.1.custom.js');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
<script type="text/javascript">
	$(function(){
		// 幫 #menu li 加上 hover 事件
		$('#menu>li').hover(function(){
			// 先找到 li 中的子選單
			var _this = $(this),
				_subnav = _this.children('ul');
			
			// 變更目前母選項的背景顏色
			// 同時顯示子選單(如果有的話)
			_this.css('backgroundColor', '#06c').siblings().css('backgroundColor', '');
			_subnav.css('display', 'block');
		} , function(){
			// 同時隱藏子選單(如果有的話)
			// 也可以把整句拆成上面的寫法
			$(this).children('ul').css('display', 'none');
		});
		
		$('#menu>li>ul>li').hover(function(){
			$(this).css('backgroundColor', '#06c').siblings().css('backgroundColor', '');

		}, function(){
			$(this).css('backgroundColor', '').siblings().css('backgroundColor', '');
			// 同時隱藏子選單(如果有的話)
			// 也可以把整句拆成上面的寫法
			//$(this).children('ul').css('display', 'none');
		});

		// 取消超連結的虛線框
		$('a').focus(function(){
			this.blur();
		});
	});
</script>

</head>
<body>
	<div id="container" style="">

		<div id="header" sytle="clear:left; float:left; background: #6494CD; ">
		<div style="width:1366px;">	
			<div style="float:left; height:25px; margin-top: -1px; margin-left: -3px;">
				<?php echo $this->Html->image('bg-logo.png', array('height'=>'71px'));?>
			</div>
			<div id="menu_div" style="float:left;"> 
				<?php 
					if($this->Session->read('user_role'))
						echo $this->element('menu_'.$this->Session->read('user_role'));
				?>
			</div>			
			<div id="account" style="float:left; clean:right;">
			<?php
				if($this->Session->read('isLogin')){
					echo '<li>';
					echo $this->Session->read('user_name');
					echo '</li>';
					echo '<li>';
					echo $this->Html->link(
    					'logout',
    					array('controller' => 'users', 'action' => 'logout'),
  						array(),
    					"Are you sure you wish to logout?"
					);
					echo '</li>';
				}
			?>
			</div>				
		</div>	
		</div>	