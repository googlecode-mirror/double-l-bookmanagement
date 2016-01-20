  * 借出作業
```
    Table Name : Lend_Records
    Columns :
       id : 流水號
       record_type : 種類(0:借閱, 1:預約)
       book_id : 書籍
       book_instance_id : 書本UID
       person_id : 出借人
       status : 狀態 (C:出借中, R:歸還, D:遺失, R:預約, D:取消, E:延長)
       reserve_date : 預借日期
       lead_date : 出借日期
       return_date : 歸還日期
       lead_cnt : 續借次數
       create_time : 建立日期
```
  * 歸還作業
  * 歸還作業, 要檢查是否有預借相關資料.
  * 預借建立
```
    Table Name : Reserve_Records
    Columns :
       id : 流水號
       book_id : 書籍
       person_id : 預約人
       status : 狀態 (R:預約, D:取消, E:延長)
       create_date : 日期
```
  * 預借刪除
  * 續借作業
  * 借卡搜尋作業
  * 書籍資料搜尋