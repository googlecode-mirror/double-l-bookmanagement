## datepicker ##
  1. 在view 最前面加上, 宣告 jquery datepicker
  1. 要輸入的欄位 加上 class =>'ref\_field, jquery\_date'
```
 <script>
    $(function() {
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
</script>
<tr>
   <td>購入日期</td>	
   <td><?php echo $this->Form->text('purchase_date', array('readonly'=>true, 'class' => 'ref_field, jquery_date', 'style'=>'width:120px'));?></td>
</tr>

```